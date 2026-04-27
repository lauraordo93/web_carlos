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
    public function index($doc = 'aviso_legal') {
        // Carga de recursos estáticos
        $this->appendCSS('css/pagweb.css?v=' . filemtime(PUBLICROOT . '/css/pagweb.css'));
        $this->appendJS('js/menuHambur.js?v=' . filemtime(PUBLICROOT . '/js/menuHambur.js'));
        $this->appendJS('js/banner_cookies.js?v=' . filemtime(PUBLICROOT . '/js/banner_cookies.js'));

        $doc = $_GET['doc'] ?? $doc;

        // Modelos para la consistencia del layout (navegación y cabecera)
        $menuModel = $this->model('MenuModel');
        $headerModel = $this->model('HeaderModel');

        // Selección dinámica del contenido según el documento solicitado
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
