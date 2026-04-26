<?php

class HomeController extends Controller {
    public function index() {
        // Cargar activos dinámicos
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

        // Cargar modelos
        $entradaModel = $this->model('EntradaModel');
        $redSocialModel = $this->model('RedSocialModel');
        $academiaModel = $this->model('AcademiaModel');
        $menuModel = $this->model('MenuModel');
        $headerModel = $this->model('HeaderModel');

        // Manejo del formulario de contacto
        $success_msg = '';
        $error_msg = '';
        $contacto_nombre = '';
        $contacto_email = '';
        $contacto_mensaje = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contacto_submit'])) {
            $contacto_nombre  = htmlspecialchars($_POST['nombre'] ?? '');
            $contacto_email   = htmlspecialchars($_POST['email'] ?? '');
            $contacto_mensaje = htmlspecialchars($_POST['mensaje'] ?? '');

            // Guardar en BD (Simplificado con PDO)
            try {
                $db = (new Database())->connect();
                $sql = "INSERT INTO contacto (nombre, email, mensaje) VALUES (?, ?, ?)";
                $stmt = $db->prepare($sql);
                $stmt->execute([$contacto_nombre, $contacto_email, $contacto_mensaje]);

                // Enviar a Formspree
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
                    $nombre = $email = $mensaje = ''; 
                } else {
                    $error_msg = "❌ Hubo un error al enviar el mensaje";
                }
            } catch (Exception $e) {
                $error_msg = "❌ Error en el servidor.";
            }
        }

        // Obtener datos para la vista
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

        // Renderizar vista
        $this->view('home/index', $data);
    }
}
