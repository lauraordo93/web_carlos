<?php
include_once(__DIR__ . '/../config/db.php');

$sql = "SELECT foto_url FROM entradas WHERE seccion_id = 2 AND foto_url IS NOT NULL AND TRIM(foto_url) <> '' ORDER BY id ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $imagenes = [];

    while ($row = $result->fetch_assoc()) {
        $imagenes[] = htmlspecialchars($row['foto_url']);
    }

    $primera = $imagenes[0];

    // Visor grande
    echo '<div class="visor galeria-visor">';
    echo '<div class="imagen-container">';
    echo '<button class="prev-img">&#10094;</button>';
    echo '<img id="imagen-grande" src="' . $primera . '" alt="Imagen grande">';
    echo '<button class="next-img">&#10095;</button>';
    echo '</div>'; // cierre imagen-container
    echo '</div>'; // cierre visor

    // Miniaturas (todas, se mostrará un máximo visible con JS)
    echo '<div class="miniaturas-container">';
    echo '<div class="galeria-miniaturas">';
    foreach ($imagenes as $img) {
        echo '<img src="' . $img . '" onclick="mostrarImagenGaleria(this)">';
    }
    echo '</div>'; // cierre galeria-miniaturas
    echo '</div>'; // cierre miniaturas-container

} else {
    echo '<p>No hay imágenes disponibles.</p>';
}
?>
