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
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            if (file_exists(APPROOT . '/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            } else {
                $this->trigger404();
                return;
            }
        }

        require_once APPROOT . '/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // Identificación y validación del método dentro del controlador
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                $this->trigger404();
                return;
            }
        }

        // Extracción de parámetros remanentes
        $this->params = $url ? array_values($url) : [];

        // Ejecución de la lógica de negocio mediante llamada dinámica
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    /**
     * Muestra la página 404 y detiene la ejecución
     */
    protected function trigger404() {
        require_once APPROOT . '/controllers/ErrorController.php';
        $controller = new ErrorController();
        $controller->index();
        exit;
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
