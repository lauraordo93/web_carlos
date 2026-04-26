<?php
// Archivo de conexión heredado (Legacy) para el panel de administración
// Los nuevos modelos usan app/core/Database.php con PDO

$envFile = __DIR__ . '/../.env';
$config = [];
if (file_exists($envFile)) {
    $config = parse_ini_file($envFile);
}

$servername = $config['DB_HOST'] ?? "localhost";
$username   = $config['DB_USER'] ?? "root";
$password   = $config['DB_PASS'] ?? "";
$database   = $config['DB_NAME'] ?? "my_pagweb";

$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
