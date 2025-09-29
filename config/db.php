<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Leer archivo .env
$config = parse_ini_file(__DIR__ . '/../.env');
if (!$config) {
    exit("❌ Error: no se pudo leer el archivo .env");
}
$servername = "localhost";
$username = "root";
$password = ""; 
$database = "my_pagweb";
// Variables de conexión
// $servername = $config['DB_HOST'];
// $username   = $config['DB_USER'];
// $password   = $config['DB_PASS'];
// $database   = $config['DB_NAME'];

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8mb4");

// Comprobar conexión
if ($conn->connect_error) {
    exit("Conexión fallida: " . $conn->connect_error);
}
?>


