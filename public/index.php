<?php
// Configuración básica
require_once '../app/config/config.php';

// Mostrar errores (quitar en producción)
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

// Cargar helpers
require_once '../app/config/helpers.php';

// Cargar núcleo
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/core/Model.php';
require_once '../app/core/App.php';

// Iniciar la aplicación
$app = new App();
