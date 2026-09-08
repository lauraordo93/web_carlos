<?php

class ErrorController extends Controller {
    public function index() {
        http_response_code(404);
        
        $this->appendPublicCSS();

        $data = [
            'titulo_pagina' => 'Página no encontrada | Carlos Ordóñez de Arce',
            'seoTitle' => 'Página no encontrada | Carlos Ordóñez de Arce',
            'seoDescription' => 'La página solicitada no existe.',
            'seoRobots' => 'noindex, follow',
        ];

        $this->view('errors/404', $data);
    }
}
