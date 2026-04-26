<?php

/**
 * CONFIGURACIÓN GLOBAL
 */

// 1. Datos de la Base de Datos (Valores por defecto)
$db_defaults = [
    'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_PASS' => '',
    'DB_NAME' => 'my_pagweb'
];

// 2. Intentar cargar desde .env para sobreescribir
$envPath = __DIR__ . '/../../.env';
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
    if ($env) {
        $db_defaults = array_merge($db_defaults, $env);
    }
}

// 3. Definir constantes globales
define('DB_HOST', $db_defaults['DB_HOST']);
define('DB_USER', $db_defaults['DB_USER']);
define('DB_PASS', $db_defaults['DB_PASS']);
define('DB_NAME', $db_defaults['DB_NAME']);

// URL Raíz (Ajusta esto según tu entorno)
define('URLROOT', 'http://localhost/web_carlos');

// Rutas Físicas
define('APPROOT', dirname(dirname(__FILE__)));
define('PUBLICROOT', APPROOT . '/../public');

// Nombre del sitio
define('SITENAME', 'Carlos Ordoñez - Web Oficial');
