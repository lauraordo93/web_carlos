<?php

/**
 * Clase Base Controller
 * 
 * Provee la funcionalidad esencial para todos los controladores del sistema, 
 * gestionando la carga de modelos, renderizado de vistas e inyección de activos.
 */
class Controller {
    /** @var array Almacén de activos CSS inyectados dinámicamente */
    protected $extra_css = [];
    
    /** @var array Almacén de activos JS inyectados dinámicamente */
    protected $extra_js = [];

    /**
     * Registra un recurso CSS para su inclusión en la cabecera
     * @param string $file Ruta relativa del archivo CSS
     */
    public function appendCSS($file) {
        $this->extra_css[] = $file;
    }

    /**
     * Registra las hojas de estilo publicas en el orden de cascada esperado.
     */
    protected function appendPublicCSS() {
        $styles = [
            'css/base.css',
            'css/nav.css',
            'css/intro.css',
            'css/biografia.css',
            'css/entrevistas.css',
            'css/tabs.css',
            'css/videos.css',
            'css/galeria.css',
            'css/academia.css',
            'css/agenda.css',
            'css/redes.css',
            'css/footer.css',
            'css/legales.css',
            'css/cookies.css'
        ];

        foreach ($styles as $style) {
            $path = PUBLICROOT . '/' . $style;
            $version = file_exists($path) ? '?v=' . filemtime($path) : '';
            $this->appendCSS($style . $version);
        }
    }
    /**
     * Registra un recurso JavaScript para su inclusión en el pie de página
     * @param string $file Ruta relativa del archivo JS
     */
    public function appendJS($file) {
        $this->extra_js[] = $file;
    }

    /**
     * Instancia un modelo de datos
     * @param string $model Nombre de la clase del modelo
     * @return object Instancia del modelo solicitado
     */
    public function model($model) {
        require_once APPROOT . '/models/' . $model . '.php';
        return new $model();
    }

    /**
     * Renderiza una vista y extrae los datos proporcionados
     * @param string $view Ruta relativa de la vista dentro del directorio app/views
     * @param array $data Conjunto de datos dinámicos para la vista
     */
    public function view($view, $data = []) {
        $viewPath = APPROOT . '/views/' . $view . '.php';
        if (file_exists($viewPath)) {
            // Integración de activos dinámicos en el flujo de datos
            $data['extra_css'] = $this->extra_css;
            $data['extra_js'] = $this->extra_js;

            // Desempaquetado de variables para acceso directo en plantillas
            extract($data, EXTR_SKIP);
            require_once $viewPath;
        } else {
            die("Error crítico: El recurso de vista '$view' es inaccesible o no existe.");
        }
    }
}
