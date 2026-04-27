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
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    /**
     * Renderiza una vista y extrae los datos proporcionados
     * @param string $view Ruta relativa de la vista dentro del directorio app/views
     * @param array $data Conjunto de datos dinámicos para la vista
     */
    public function view($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            // Integración de activos dinámicos en el flujo de datos
            $data['extra_css'] = $this->extra_css;
            $data['extra_js'] = $this->extra_js;

            // Desempaquetado de variables para acceso directo en plantillas
            extract($data);
            require_once '../app/views/' . $view . '.php';
        } else {
            die("Error crítico: El recurso de vista '$view' es inaccesible o no existe.");
        }
    }
}
