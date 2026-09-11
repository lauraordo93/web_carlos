<?php

/**
 * Controlador de Administración
 * 
 * Gestiona las operaciones principales del panel de control: 
 * autenticación, listado de contenidos y operaciones CRUD.
 */
class AdminController extends Controller
{
    /**
     * Constructor del controlador
     * Inicializa la sesión y carga los activos CSS necesarios.
     */
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $this->appendCSS('css/admin.css?v=' . filemtime(PUBLICROOT . '/css/admin.css'));
        $this->appendCSS('css/entradas.css?v=' . filemtime(PUBLICROOT . '/css/entradas.css'));
    }

    /**
     * Validación de sesión activa
     * Redirige al login si no existe una identidad administrativa.
     */
    private function checkSession()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: " . URLROOT . "/admin/login");
            exit;
        }
    }

    private function setFlash($type, $message)
    {
        $_SESSION['flash'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    /**
     * Vista principal del panel
     * Muestra el listado de registros con soporte para paginación y filtrado por sección.
     */
    public function index()
    {
        $this->checkSession();

        $entradaModel = $this->model('EntradaModel');
        $id_sec = isset($_GET['sec']) ? (int)$_GET['sec'] : 5;

        // Configuración de paginación
        $limit = 6;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        $total_registros = $entradaModel->countBySeccion($id_sec);
        $total_paginas = ceil($total_registros / $limit);

        $data = [
            'titulo' => 'Panel de Administración',
            'entradas' => $entradaModel->getBySeccion($id_sec, $limit, $offset, 'id DESC'),
            'id_sec' => $id_sec,
            'page' => $page,
            'total_registros' => $total_registros,
            'total_paginas' => $total_paginas,
            'csrf_token' => $this->getCsrfToken()
        ];

        $this->view('admin/index', $data);
    }

    /**
     * Autenticación de administradores
     * Procesa las credenciales y establece la persistencia de la sesión.
     */
    public function login()
    {
        if (isset($_SESSION['admin_id'])) {
            header("Location: " . URLROOT . "/admin");
            exit;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['usuario'] ?? '');
            $password = trim($_POST['password'] ?? '');

            $adminModel = $this->model('AdminModel');
            $user = $adminModel->login($username, $password);

            if ($user) {
                session_regenerate_id(true);
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_user'] = $user['usuario'];
                header("Location: " . URLROOT . "/admin");
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        }

        $data = ['titulo' => 'Iniciar Sesión - Admin', 'error' => $error];
        $this->view('admin/login', $data);
    }

    /**
     * Gestión de tokens CSRF (protección contra Cross-Site Request Forgery)
     */
    private function getCsrfToken(): string
    {
        if (empty($_SESSION['admin_csrf_token'])) {
            $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['admin_csrf_token'];
    }

    private function validateCsrfToken(string $token): bool
    {
        if (empty($_SESSION['admin_csrf_token']) || empty($token)) {
            return false;
        }
        return hash_equals($_SESSION['admin_csrf_token'], $token);
    }

    /**
     * Gestión de tokens de idempotencia (protección contra doble submit)
     */
    private function generateSubmitToken(): string
    {
        if (!isset($_SESSION['admin_submit_tokens']) || !is_array($_SESSION['admin_submit_tokens'])) {
            $_SESSION['admin_submit_tokens'] = [];
        }

        // Limpieza de tokens antiguos (caducidad de 2 horas = 7200s)
        $now = time();
        foreach ($_SESSION['admin_submit_tokens'] as $t => $timestamp) {
            if ($now - $timestamp > 7200) {
                unset($_SESSION['admin_submit_tokens'][$t]);
            }
        }

        $token = bin2hex(random_bytes(32));
        $_SESSION['admin_submit_tokens'][$token] = $now;

        return $token;
    }

    private function consumeSubmitToken(string $token): bool
    {
        if (empty($token) || !isset($_SESSION['admin_submit_tokens'][$token])) {
            return false;
        }

        $timestamp = $_SESSION['admin_submit_tokens'][$token];
        unset($_SESSION['admin_submit_tokens'][$token]);

        if (time() - $timestamp > 7200) {
            return false;
        }

        return true;
    }

    /**
     * Finalización de sesión
     */
    public function logout()
    {
        session_destroy();
        header("Location: " . URLROOT . "/admin/login");
        exit;
    }

    /**
     * Eliminación de registros
     * @param int $id Identificador del registro a suprimir
     */
    public function borrar($id)
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setFlash('error', 'Método no permitido. Utilice POST para borrar.');
            header("Location: " . URLROOT . "/admin");
            exit;
        }

        $csrf_token = trim($_POST['csrf_token'] ?? '');
        if (!$this->validateCsrfToken($csrf_token)) {
            $this->setFlash('error', 'Error de seguridad CSRF. Operación denegada.');
            header("Location: " . URLROOT . "/admin");
            exit;
        }

        $entradaModel = $this->model('EntradaModel');

        $entrada = $entradaModel->getById($id);
        $sec = $entrada ? $entrada['seccion_id'] : 5;

        if ($entradaModel->delete($id)) {
            header("Location: " . URLROOT . "/admin?sec=" . $sec);
        } else {
            die("Error al procesar la solicitud de eliminación.");
        }
    }

    /**
     * Gestión de registros (Creación / Edición)
     * Procesa el formulario de entrada de datos y gestiona la carga de archivos.
     * @param int $id Identificador para edición (0 para nuevos registros)
     */
    public function agenda()
    {
        $this->checkSession();

        $agendaModel = $this->model('AgendaModel');

        $data = [
            'titulo' => 'Agenda',
            'eventos' => $agendaModel->getAllEvents(),
            'admin_section' => 'agenda',
            'id_sec' => 0,
            'csrf_token' => $this->getCsrfToken()
        ];

        $this->view('admin/agenda_index', $data);
    }

    public function agendaNueva()
    {
        $this->agendaEditar(0);
    }

    public function agendaEditar($id = 0)
    {
        $this->checkSession();
        $this->appendCSS('css/formulario.css?v=' . filemtime(PUBLICROOT . '/css/formulario.css'));

        $agendaModel = $this->model('AgendaModel');
        $modo_edicion = ((int) $id > 0);
        $error = '';

        if ($modo_edicion) {
            $evento = $agendaModel->findById($id);

            if (!$evento) {
                $this->setFlash('error', 'El evento solicitado no existe.');
                header("Location: " . URLROOT . "/admin/agenda");
                exit;
            }
        } else {
            $evento = [
                'id' => null,
                'titulo' => '',
                'descripcion' => '',
                'fecha' => '',
                'lugar' => '',
                'seccion_id' => 3
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csrf_token = trim($_POST['csrf_token'] ?? '');
            if (!$this->validateCsrfToken($csrf_token)) {
                $this->setFlash('error', 'Error de seguridad CSRF. Operación denegada.');
                header("Location: " . URLROOT . "/admin/agenda");
                exit;
            }

            $token = trim($_POST['submit_token'] ?? '');
            if (!$this->consumeSubmitToken($token)) {
                $this->setFlash('error', 'La petición ha caducado o ya ha sido procesada. Por favor, inténtelo de nuevo si es necesario.');
                header("Location: " . URLROOT . "/admin/agenda");
                exit;
            }
            $titulo = trim($_POST['titulo'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $fecha = trim($_POST['fecha'] ?? '');
            $lugar = trim($_POST['lugar'] ?? '');

            if ($titulo === '') {
                $error = 'El título es obligatorio.';
            } elseif ($fecha === '') {
                $error = 'La fecha es obligatoria.';
            } elseif (!$this->isValidDate($fecha)) {
                $error = 'La fecha indicada no es válida.';
            }

            $evento = [
                'id' => $modo_edicion ? (int) $id : null,
                'titulo' => $titulo,
                'descripcion' => $descripcion,
                'fecha' => $fecha,
                'lugar' => $lugar,
                'seccion_id' => 3
            ];

            if ($error === '') {
                $datos = [
                    'titulo' => $titulo,
                    'descripcion' => $descripcion !== '' ? $descripcion : null,
                    'fecha' => $fecha,
                    'lugar' => $lugar !== '' ? $lugar : null,
                    'seccion_id' => 3
                ];

                $exito = $modo_edicion
                    ? $agendaModel->update($id, $datos)
                    : $agendaModel->create($datos);

                if ($exito) {
                    $this->setFlash('success', $modo_edicion ? 'Evento actualizado correctamente.' : 'Evento creado correctamente.');
                    header("Location: " . URLROOT . "/admin/agenda");
                    exit;
                }

                $error = 'Error al guardar el evento.';
            }
        }

        $data = [
            'titulo' => $modo_edicion ? 'Editar Evento' : 'Nuevo Evento',
            'evento' => (object) $evento,
            'modo_edicion' => $modo_edicion,
            'error' => $error,
            'admin_section' => 'agenda',
            'id_sec' => 0,
            'csrf_token' => $this->getCsrfToken(),
            'submit_token' => $this->generateSubmitToken()
        ];

        $this->view('admin/agenda_formulario', $data);
    }

    public function agendaBorrar($id = 0)
    {
        $this->checkSession();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setFlash('error', 'Método no permitido. Utilice POST para borrar.');
            header("Location: " . URLROOT . "/admin/agenda");
            exit;
        }

        $csrf_token = trim($_POST['csrf_token'] ?? '');
        if (!$this->validateCsrfToken($csrf_token)) {
            $this->setFlash('error', 'Error de seguridad CSRF. Operación denegada.');
            header("Location: " . URLROOT . "/admin/agenda");
            exit;
        }

        $agendaModel = $this->model('AgendaModel');
        $evento = $agendaModel->findById($id);

        if (!$evento) {
            $this->setFlash('error', 'El evento solicitado no existe.');
            header("Location: " . URLROOT . "/admin/agenda");
            exit;
        }

        if ($agendaModel->delete($id)) {
            $this->setFlash('success', 'Evento eliminado correctamente.');
        } else {
            $this->setFlash('error', 'No se pudo eliminar el evento.');
        }

        header("Location: " . URLROOT . "/admin/agenda");
        exit;
    }

    private function isValidDate($date)
    {
        $parsed = DateTime::createFromFormat('Y-m-d', $date);
        return $parsed && $parsed->format('Y-m-d') === $date;
    }

    public function editar($id = 0)
    {
        $this->checkSession();
        $this->appendCSS('css/formulario.css?v=' . filemtime(PUBLICROOT . '/css/formulario.css'));
        $entradaModel = $this->model('EntradaModel');

        $error = '';
        $modo_edicion = ($id > 0);
        $id_sec = isset($_GET['sec']) ? (int)$_GET['sec'] : 5;

        if ($modo_edicion) {
            $entrada = $entradaModel->getById($id);
            if (!$entrada) die("El registro solicitado no existe.");
            $id_sec = $entrada['seccion_id'];
        } else {
            $entrada = [
                'titulo' => '', 'contenido' => '', 'foto_url' => '',
                'video_url' => '', 'fecha' => '', 'enlace_url' => '',
                'seccion_id' => $id_sec
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_sec = (int)($_POST['seccion_id'] ?? 5);

            $csrf_token = trim($_POST['csrf_token'] ?? '');
            if (!$this->validateCsrfToken($csrf_token)) {
                $this->setFlash('error', 'Error de seguridad CSRF. Operación denegada.');
                header("Location: " . URLROOT . "/admin?sec=" . $id_sec);
                exit;
            }

            $token = trim($_POST['submit_token'] ?? '');
            if (!$this->consumeSubmitToken($token)) {
                $this->setFlash('error', 'La petición ha caducado o ya ha sido procesada. Por favor, inténtelo de nuevo si es necesario.');
                header("Location: " . URLROOT . "/admin?sec=" . $id_sec);
                exit;
            }
            $id_sec = (int)$_POST['seccion_id'];
            $titulo = trim($_POST['titulo'] ?? '');
            $contenido = trim($_POST['contenido'] ?? '');
            $video_url = trim($_POST['video_url'] ?? '');
            $fecha = trim($_POST['fecha'] ?? '') ?: null;
            $enlace_url = trim($_POST['enlace_url'] ?? '');
            $foto_url = $_POST['foto_url_actual'] ?? '';

            // Tratamiento de archivos multimedia (conversión WebP centralizada)
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
                $result = ImageUploader::upload($_FILES['foto'], 'img');

                if ($result['ok']) {
                    $foto_url = $result['path'];
                } else {
                    $error = $result['error'];
                }
            }

            if (empty($error)) {
                $datos = [
                    'titulo' => $titulo, 'contenido' => $contenido, 'foto_url' => $foto_url,
                    'video_url' => $video_url, 'fecha' => $fecha, 'seccion_id' => $id_sec,
                    'enlace_url' => $enlace_url
                ];

                $exito = $modo_edicion ? $entradaModel->update($id, $datos) : $entradaModel->create($datos);

                if ($exito) {
                    header("Location: " . URLROOT . "/admin?sec=" . $id_sec);
                    exit;
                } else {
                    $error = "Error al persistir la información en el sistema.";
                }
            }
        }

        $data = [
            'titulo' => $modo_edicion ? 'Editar Registro' : 'Nuevo Registro',
            'entrada' => (object)$entrada,
            'id_sec' => $id_sec,
            'error' => $error,
            'modo_edicion' => $modo_edicion,
            'csrf_token' => $this->getCsrfToken(),
            'submit_token' => $this->generateSubmitToken()
        ];

        $this->view('admin/formulario', $data);
    }

    /**
     * Endpoint para creación de nuevos registros
     * @param int $sec Identificador de la sección destino
     */
    public function nueva($sec = 5)
    {
        $_GET['sec'] = $sec;
        $this->editar(0);
    }
}
