<?php

class Controller {
    protected $extra_css = [];
    protected $extra_js = [];

    /**
     * Añade un archivo CSS a la cola de la página
     */
    public function appendCSS($file) {
        $this->extra_css[] = $file;
    }

    /**
     * Añade un archivo JS a la cola de la página
     */
    public function appendJS($file) {
        $this->extra_js[] = $file;
    }

    /**
     * Carga un modelo
     */
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    /**
     * Carga una vista
     */
    public function view($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            // Añadir CSS y JS dinámicos a los datos de la vista
            $data['extra_css'] = $this->extra_css;
            $data['extra_js'] = $this->extra_js;

            // Extraer el array de datos para que las variables estén disponibles en la vista
            extract($data);
            require_once '../app/views/' . $view . '.php';
        } else {
            die("La vista '$view' no existe.");
        }
    }
}
