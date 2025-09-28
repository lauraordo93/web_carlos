<?php

$servername = "localhost";
$username = "root";
$password = ""; 
$database = "my_pagweb";
// $servername = "sql101.infinityfree.com";
// $username = "if0_39744310";
// $password = "HcGAOCHi2pBr"; 
// $database = "if0_39744310_paginaweb";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8mb4");
// Comprobar conexión
if ($conn->connect_error) {
    exit("Conexión fallida: " . $conn->connect_error);
}
?>