<?php
include_once(__DIR__ . '/../config/db.php');

$sql = "SELECT foto_url FROM entradas WHERE seccion_id = 2 AND foto_url IS NOT NULL AND TRIM(foto_url) <> '' ORDER BY id ASC";
$result = $conn->query($sql);


if ($result && $result->num_rows > 0) {
    // Tomamos la primera imagen para mostrar como grande
    $row = $result->fetch_assoc();
    $foto = htmlspecialchars($row["foto_url"]);

    // Imagen grande inicial
    echo '<div class="visor">';
    echo '<img id="imagen-grande" src="' . $foto . '" alt="Imagen grande">';
    echo '</div>';

    // Miniaturas
    echo '<div class="miniaturas">';
    echo '<img src="' . $foto . '" onclick="mostrarImagen(this)">';
    
    while ($row = $result->fetch_assoc()) {
        $foto = htmlspecialchars($row["foto_url"]);
        echo '<img src="' . $foto . '" onclick="mostrarImagen(this)">';
    }
    echo '</div>';

} else {
    echo '<p>No hay imágenes en la galería.</p>';
}
?>


