<?php
include_once(__DIR__ . '/../config/db.php');

// Consulta para sacar todas las fotos de la galería
$sql = "SELECT foto_url FROM entradas WHERE seccion_id = 2 AND foto_url IS NOT NULL AND TRIM(foto_url) <> '' ORDER BY id ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    

    // Mostrar la imagen grande inicial
    echo '<div class="visor">';
    // echo '<h2>Galería</h2>';
    $row = $result->fetch_assoc();
    $foto = htmlspecialchars($row["foto_url"]);
    echo '<img id="imagen-grande" src="/mi_pagweb/' . $foto . '" alt="Imagen grande">';
    echo '</div>';

    // Mostrar miniaturas
    echo '<div class="miniaturas">';
    echo '<img src="/mi_pagweb/' . $foto . '" onclick="mostrarImagen(this)">';
    while ($row = $result->fetch_assoc()) {
        $foto = htmlspecialchars($row["foto_url"]);
        echo '<img src="/mi_pagweb/' . $foto . '" onclick="mostrarImagen(this)">';
    }
    echo '</div>';

} else {
    echo '<p>No hay imágenes en la galería.</p>';
}



?>