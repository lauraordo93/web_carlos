<?php
include_once(__DIR__ . '/../config/db.php');
//SELECT foto_url FROM entradas WHERE foto_url IS NOT NULL AND foto_url != '';
// $sql = "SELECT * FROM `galeria`";
$sql="SELECT foto_url FROM entradas WHERE seccion_id = 2 AND foto_url IS NOT NULL AND TRIM(foto_url) <> '' ORDER BY id ASC";;
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo '<h2>Galería</h2>';
    echo '<div class="galeria-contenedor"><div class="galeria">';

    while ($row = $result->fetch_assoc()) { //esto para local
        $foto = htmlspecialchars($row["foto_url"]);
        echo '<a href="/mi_pagweb/' . $foto . '" target="_blank">';
        echo '<img src="/mi_pagweb/' . $foto . '" alt="Imagen de galería">';
        echo '</a>';
    }
// while ($row = $result->fetch_assoc()) { //servidor
//     $foto = $row["foto_url"];
//     $foto = trim($row["foto_url"]);
//     echo '<a href="' . $foto . '" target="_blank">';
//     echo '<img src="' . $foto . '" alt="Imagen de galería">';
//     echo '</a>';
// }


    echo '</div></div>';
} else {
    echo '<p>No hay imágenes en la galería.</p>';
}
?>