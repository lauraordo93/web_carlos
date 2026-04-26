<?php

class AdminController extends Controller
{

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        // Activos globales del admin
        $this->appendCSS('css/admin.css?v=' . filemtime(PUBLICROOT . '/css/admin.css'));
    }

    /**
     * Verificar sesión de forma privada
     */
    private function checkSession()
    {
        if (!isset($_SESSION['admin_id'])) {
            header("Location: " . URLROOT . "/admin/login");
            exit;
        }
    }

    public function index()
    {
        $this->checkSession();

        $entradaModel = $this->model('EntradaModel');
        $id_sec = isset($_GET['sec']) ? (int)$_GET['sec'] : 5;

        // Paginación
        $limit = 6; // Solo 6 registros por página para evitar colapso
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
            'total_paginas' => $total_paginas
        ];

        $this->view('admin/index', $data);
    }

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
                // Seguridad: Regenerar el ID de sesión al iniciar sesión
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

    public function logout()
    {
        session_destroy();
        header("Location: " . URLROOT . "/admin/login");
        exit;
    }

    /**
     *  lógica de Borrar
     */
    public function borrar($id)
    {
        $this->checkSession();
        $entradaModel = $this->model('EntradaModel');

        // Obtener seccion para el redirect posterior
        $entrada = $entradaModel->getById($id);
        $sec = $entrada ? $entrada['seccion_id'] : 5;

        if ($entradaModel->delete($id)) {
            header("Location: " . URLROOT . "/admin?sec=" . $sec);
        } else {
            die("Error al borrar el registro.");
        }
    }

    /**
     *  lógica de Formulario (Nueva/Editar)
     */
    public function editar($id = 0)
    {
        $this->checkSession();
        $entradaModel = $this->model('EntradaModel');
        $error = '';

        // Modo Edición vs Nueva
        $modo_edicion = ($id > 0);
        $id_sec = isset($_GET['sec']) ? (int)$_GET['sec'] : 5;

        if ($modo_edicion) {
            $entrada = $entradaModel->getById($id);
            if (!$entrada) die("Registro no encontrado.");
            $id_sec = $entrada['seccion_id'];
        } else {
            $entrada = [
                'titulo' => '',
                'contenido' => '',
                'foto_url' => '',
                'video_url' => '',
                'fecha' => '',
                'enlace_url' => '',
                'seccion_id' => $id_sec
            ];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_sec = (int)$_POST['seccion_id'];
            $titulo = trim($_POST['titulo'] ?? '');
            $contenido = trim($_POST['contenido'] ?? '');
            $video_url = trim($_POST['video_url'] ?? '');
            $fecha = trim($_POST['fecha'] ?? '') ?: null;
            $enlace_url = trim($_POST['enlace_url'] ?? '');
            $foto_url = $_POST['foto_url_actual'] ?? '';

            // Lógica de subida de imagen rescatada
            if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                $permitidas = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
                $tipo = mime_content_type($_FILES['foto']['tmp_name']);

                if (in_array($tipo, $permitidas)) {
                    $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                    $nombre_unico = 'img_' . uniqid() . '.' . $extension;
                    $ruta_destino = __DIR__ . '/../../public/img/' . $nombre_unico;

                    if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino)) {
                        $foto_url = 'img/' . $nombre_unico;
                    }
                } else {
                    $error = "Formato de imagen no permitido.";
                }
            }

            if (empty($error)) {
                $datos = [
                    'titulo' => $titulo,
                    'contenido' => $contenido,
                    'foto_url' => $foto_url,
                    'video_url' => $video_url,
                    'fecha' => $fecha,
                    'seccion_id' => $id_sec,
                    'enlace_url' => $enlace_url
                ];

                if ($modo_edicion) {
                    $exito = $entradaModel->update($id, $datos);
                } else {
                    $exito = $entradaModel->create($datos);
                }

                if ($exito) {
                    header("Location: " . URLROOT . "/admin?sec=" . $id_sec);
                    exit;
                } else {
                    $error = "Error al guardar en la base de datos.";
                }
            }
        }

        $data = [
            'titulo' => $modo_edicion ? 'Editar Registro' : 'Nuevo Registro',
            'entrada' => (object)$entrada,
            'id_sec' => $id_sec,
            'error' => $error,
            'modo_edicion' => $modo_edicion
        ];

        $this->view('admin/formulario', $data);
    }

    // Alias para nueva entrada
    public function nueva($sec = 5)
    {
        $_GET['sec'] = $sec;
        $this->editar(0);
    }
}
