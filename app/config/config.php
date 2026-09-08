<?php

$db_defaults = [
    'DB_HOST' => 'localhost',
    'DB_USER' => 'root',
    'DB_PASS' => '',
    'DB_NAME' => 'my_pagweb',
    'APP_BASE_PATH' => null,
];

$envPath = __DIR__ . '/../../.env';
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
    if ($env) {
        $db_defaults = array_merge($db_defaults, $env);
    }
}

define('DB_HOST', $db_defaults['DB_HOST']);
define('DB_USER', $db_defaults['DB_USER']);
define('DB_PASS', $db_defaults['DB_PASS']);
define('DB_NAME', $db_defaults['DB_NAME']);

$httpsEnabled = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    || (!empty($_SERVER['SERVER_PORT']) && (int) $_SERVER['SERVER_PORT'] === 443);

$scheme = $httpsEnabled ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
$detectedBasePath = rtrim(str_replace('/index.php', '', $scriptName), '/');
$basePath = $db_defaults['APP_BASE_PATH'] !== null
    ? '/' . trim((string) $db_defaults['APP_BASE_PATH'], '/')
    : $detectedBasePath;

if ($basePath === '/') {
    $basePath = '';
}

define('URLROOT', $scheme . '://' . $host . $basePath);
define('APPROOT', dirname(__DIR__));
define('PUBLICROOT', dirname(APPROOT));
define('SITENAME', 'Carlos Ordonez - Web Oficial');

// ---------------------------------------------------------------------------
// Configuración de subida y conversión de imágenes
// ---------------------------------------------------------------------------
define('WEBP_QUALITY', 82);                      // Calidad WebP (0-100)
define('MAX_UPLOAD_SIZE', 10 * 1024 * 1024);     // 10 MB
define('MAX_IMAGE_WIDTH', 2400);                  // px – no amplía imágenes pequeñas
define('MAX_IMAGE_HEIGHT', 2400);                 // px – conserva proporción
define('ALLOWED_MIME_TYPES', [
    'image/jpeg',
    'image/png',
    'image/webp',
    'image/gif',
]);