<?php
include_once(__DIR__ . '/../config/db.php');

$sql = "SELECT foto_url FROM entradas WHERE seccion_id = 2 AND foto_url IS NOT NULL AND TRIM(foto_url) <> '' ORDER BY id ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $imagenes = [];
    while ($row = $result->fetch_assoc()) {
        $imagenes[] = htmlspecialchars($row['foto_url']);
    }

    // 1. VISOR GRANDE
    echo '<div class="swiper mainSwiper" id="swiper-principal">';
    echo '  <div class="swiper-wrapper">';
    foreach ($imagenes as $img) {
        echo '<div class="swiper-slide">';
        // Solo la imagen, sin etiquetas <a> que abran pestañas
        echo '  <img src="' . $img . '" alt="Imagen" class="click-zoom" />';
        echo '</div>';
    }
    echo '  </div>';

    echo '  <div class="swiper-pagination"></div>';

    echo '  <div class="swiper-button-next"></div>';
    echo '  <div class="swiper-button-prev"></div>';
    echo '</div>';

    // 2. MINIATURAS (Se quedan igual)
    echo '<div class="swiper thumbSwiper">';
    echo '  <div class="swiper-wrapper">';
    foreach ($imagenes as $img) {
        echo '<div class="swiper-slide"><img src="' . $img . '" alt="Miniatura" /></div>';
    }
    echo '  </div>';
    echo '</div>';

} else {
    echo '<p>No hay imágenes disponibles.</p>';
}
?>