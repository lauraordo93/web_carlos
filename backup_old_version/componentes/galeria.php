<?php
include_once(__DIR__ . '/../config/db.php');

$sql = "SELECT foto_url FROM entradas 
        WHERE seccion_id = 2 
          AND foto_url IS NOT NULL 
          AND TRIM(foto_url) <> '' 
        ORDER BY id ASC";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $imagenes = [];

    while ($row = $result->fetch_assoc()) {
        $url = trim($row['foto_url']);

        $imagenes[] = [
            'full'  => htmlspecialchars($url, ENT_QUOTES, 'UTF-8'),
            'thumb' => htmlspecialchars($url, ENT_QUOTES, 'UTF-8')
        ];
    }

    echo '<div class="swiper mainSwiper" id="swiper-principal">';
    echo '  <div class="swiper-wrapper">';

    foreach ($imagenes as $index => $img) {
        $loading = $index === 0 ? 'eager' : 'lazy';
        $fetchpriority = $index === 0 ? 'high' : 'auto';

        echo '<div class="swiper-slide">';
        echo '  <img 
                    src="' . $img['full'] . '" 
                    alt="Imagen de galería" 
                    class="click-zoom"
                    loading="' . $loading . '"
                    decoding="async"
                    fetchpriority="' . $fetchpriority . '"
                />';
        echo '</div>';
    }

    echo '  </div>';
    echo '  <div class="swiper-pagination"></div>';
    echo '  <div class="swiper-button-next"></div>';
    echo '  <div class="swiper-button-prev"></div>';
    echo '</div>';

    echo '<div class="swiper thumbSwiper">';
    echo '  <div class="swiper-wrapper">';

    foreach ($imagenes as $img) {
        echo '<div class="swiper-slide">';
        echo '  <img 
                    src="' . $img['thumb'] . '" 
                    alt="Miniatura"
                    loading="lazy"
                    decoding="async"
                />';
        echo '</div>';
    }

    echo '  </div>';
    echo '</div>';
} else {
    echo '<p>No hay imágenes disponibles.</p>';
}
