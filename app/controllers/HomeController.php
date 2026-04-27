<?php

/**
 * Controlador de la Página Principal (Home)
 * 
 * Orquestador de la visualización pública, gestionando la carga de contenidos 
 * dinámicos y la recepción de solicitudes de contacto.
 */
class HomeController extends Controller {
    
    /**
     * Punto de entrada para la página principal
     */
    public function index() {
        // Carga de activos multimedia y de diseño
        $this->appendCSS('css/pagweb.css?v=' . filemtime(PUBLICROOT . '/css/pagweb.css'));
        
        $scripts = [
            'js/banner_cookies.js',
            'js/gal_vieBTN.js',
            'js/sobremi.js',
            'js/galeria.js',
            'js/video.js',
            'js/menuHambur.js'
        ];
        
        foreach ($scripts as $script) {
            $this->appendJS($script . '?v=' . filemtime(PUBLICROOT . '/' . $script));
        }

        // Inicialización de modelos de negocio
        $entradaModel = $this->model('EntradaModel');
        $redSocialModel = $this->model('RedSocialModel');
        $academiaModel = $this->model('AcademiaModel');
        $menuModel = $this->model('MenuModel');
        $headerModel = $this->model('HeaderModel');

        // Gestión de comunicación externa (Formulario de contacto)
        $success_msg = '';
        $error_msg = '';
        $contacto_nombre = '';
        $contacto_email = '';
        $contacto_mensaje = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contacto_submit'])) {
            $contacto_nombre  = htmlspecialchars($_POST['nombre'] ?? '');
            $contacto_email   = htmlspecialchars($_POST['email'] ?? '');
            $contacto_mensaje = htmlspecialchars($_POST['mensaje'] ?? '');

            try {
                $db = (new Database())->connect();
                $sql = "INSERT INTO contacto (nombre, email, mensaje) VALUES (?, ?, ?)";
                $stmt = $db->prepare($sql);
                $stmt->execute([$contacto_nombre, $contacto_email, $contacto_mensaje]);

                // Integración con servicio de terceros (Formspree)
                $formspree_url = "https://formspree.io/f/meorgrrz";
                $data_post = [
                    'name' => $contacto_nombre,
                    'email' => $contacto_email,
                    'message' => $contacto_mensaje
                ];

                $options = [
                    'http' => [
                        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method'  => 'POST',
                        'content' => http_build_query($data_post),
                    ],
                ];
                $context  = stream_context_create($options);
                $result = @file_get_contents($formspree_url, false, $context);

                if ($result !== false) {
                    $success_msg = "✅ Mensaje enviado correctamente";
                    $contacto_nombre = $contacto_email = $contacto_mensaje = ''; 
                } else {
                    $error_msg = "❌ Hubo un error al enviar el mensaje";
                }
            } catch (Exception $e) {
                $error_msg = "❌ Error en el servidor al procesar el mensaje.";
            }
        }

        // Estructuración del conjunto de datos para la vista
        $data = [
            'titulo_pagina' => 'Página web Carlos',
            'sobre_mi' => $entradaModel->getSobreMi(),
            'biografia' => $entradaModel->getBiografia(),
            'redes' => $redSocialModel->getAll(),
            'academia' => $academiaModel->getFirst(),
            'galeria' => $entradaModel->getGaleria(),
            'videos' => $entradaModel->getVideos(),
            'entrevistas' => $entradaModel->getEntrevistas(),
            'menu' => $menuModel->getAll(),
            'header' => $headerModel->getLogo(),
            'success_msg' => $success_msg,
            'error_msg' => $error_msg,
            'contacto_nombre' => $contacto_nombre,
            'contacto_email' => $contacto_email,
            'contacto_mensaje' => $contacto_mensaje
        ];

        $this->view('home/index', $data);
    }
}
