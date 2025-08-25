<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "sql101.infinityfree.com";
$usuario = "if0_39744310";
$pass = "HcGAOCHi2pBr"; 
$bd = "if0_39744310_pagweb";

$conexion = new mysqli($host, $usuario, $pass, $bd);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
echo "¡Conexión exitosa!";
?>
