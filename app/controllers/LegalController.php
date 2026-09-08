<?php

/**
 * Controlador de Documentación Legal
 * 
 * Gestiona la visualización de los textos legales obligatorios: 
 * Aviso Legal, Política de Privacidad y Política de Cookies.
 */
class LegalController extends Controller {
    
    /**
     * Renderiza el documento legal solicitado
     * 
     * @param string $doc Identificador del documento legal
     */
    public function index() {
        if (!isset($_GET['doc'])) {
            $this->trigger404();
            return;
        }

        $doc = $_GET['doc'];
        
        $map = [
            'aviso_legal' => 'aviso-legal',
            'privacidad' => 'privacidad',
            'cookies' => 'cookies'
        ];

        if (array_key_exists($doc, $map)) {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: " . URLROOT . "/legal/" . $map[$doc]);
            exit;
        }

        $this->trigger404();
    }

    private function trigger404() {
        require_once APPROOT . '/controllers/ErrorController.php';
        $controller = new ErrorController();
        $controller->index();
        exit;
    }

    public function aviso_legal() {
        $this->renderDoc('Aviso Legal', 'aviso_legal_texto', 'aviso-legal');
    }

    public function privacidad() {
        $this->renderDoc('Política de Privacidad', 'politica_privacidad_texto', 'privacidad');
    }

    public function cookies() {
        $this->renderDoc('Política de Cookies', 'politica_cookies_texto', 'cookies');
    }

    private function renderDoc($titulo, $view_file, $slug) {
        $this->appendPublicCSS();
        $this->appendJS('js/menu_hambur.js?v=' . filemtime(PUBLICROOT . '/js/menu_hambur.js'));
        $this->appendJS('js/banner_cookies.js?v=' . filemtime(PUBLICROOT . '/js/banner_cookies.js'));

        $menuModel = $this->model('MenuModel');
        $headerModel = $this->model('HeaderModel');

        $data = [
            'titulo' => $titulo,
            'view_file' => $view_file,
            'titulo_pagina' => $titulo . ' - Página web Carlos',
            'seoTitle' => $titulo . ' | Carlos Ordoñez',
            'seoDescription' => 'Texto legal: ' . $titulo . ' de la web oficial de Carlos Ordoñez.',
            'seoCanonical' => CANONICAL_URLROOT . '/legal/' . $slug,
            'menu' => $menuModel->getAll(),
            'header' => $headerModel->getLogo()
        ];

        $this->view('legal/index', $data);
    }
}
