<?php

/**
 * Motor de Enrutamiento (Router)
 * 
 * Clase fundamental encargada de procesar la URL entrante, descomponerla 
 * en controlador, método y parámetros, y ejecutar la lógica correspondiente.
 */
class App {
    /** @var string Controlador predeterminado del sistema */
    protected $controller = 'HomeController';
    
    /** @var string Método predeterminado del controlador */
    protected $method = 'index';
    
    /** @var array Argumentos adicionales pasados vía URL */
    protected $params = [];

    /**
     * Inicializa el enrutamiento analizando la solicitud HTTP
     */
    public function __construct() {
        $url = $this->parseUrl();

        // Identificación y validación del controlador solicitado
        if (isset($url[0]) && file_exists(APPROOT . '/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        }

        require_once APPROOT . '/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Identificación y validación del método dentro del controlador
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Extracción de parámetros remanentes
        $this->params = $url ? array_values($url) : [];

        // Ejecución de la lógica de negocio mediante llamada dinámica
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Procesa la cadena de la URL sanitizándola y fragmentándola
     * @return array Segmentos de la URL procesada
     */
    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
