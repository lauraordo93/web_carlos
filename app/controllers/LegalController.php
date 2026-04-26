<?php

class LegalController extends Controller {
    public function index($doc = 'aviso_legal') {
        // Cargar activos dinámicos
        $this->appendCSS('css/pagweb.css?v=' . filemtime(PUBLICROOT . '/css/pagweb.css'));
        $this->appendJS('js/menuHambur.js?v=' . filemtime(PUBLICROOT . '/js/menuHambur.js'));
        $this->appendJS('js/banner_cookies.js?v=' . filemtime(PUBLICROOT . '/js/banner_cookies.js'));

        $doc = $_GET['doc'] ?? $doc;

        // Cargar modelos comunes para el layout
        $menuModel = $this->model('MenuModel');
        $headerModel = $this->model('HeaderModel');

        switch ($doc) {
            case 'privacidad':
                $titulo = 'Política de Privacidad';
                $view_file = 'politica_privacidad_texto';
                break;
            case 'cookies':
                $titulo = 'Política de Cookies';
                $view_file = 'politica_cookies_texto';
                break;
            case 'aviso_legal':
            default:
                $titulo = 'Aviso Legal';
                $view_file = 'aviso_legal_texto';
                break;
        }

        $data = [
            'titulo' => $titulo,
            'view_file' => $view_file,
            'titulo_pagina' => $titulo . ' - Página web Carlos',
            'menu' => $menuModel->getAll(),
            'header' => $headerModel->getLogo()
        ];

        $this->view('legal/index', $data);
    }
}
