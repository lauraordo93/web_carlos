<?php
include_once(__DIR__ . '/../config/db.php');

// Función para asegurar que la URL sea de tipo "embed" para el iframe
function prepararYoutube($url)
{
    $url = trim($url);

    if ($url === '') {
        return '';
    }

    // Caso: youtu.be/ID
    if (strpos($url, 'youtu.be/') !== false) {
        $videoId = substr($url, strrpos($url, '/') + 1);
        $videoId = explode('?', $videoId)[0];
        return 'https://www.youtube.com/embed/' . $videoId;
    }

    // Caso: youtube.com/watch?v=ID
    if (strpos($url, 'watch?v=') !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        if (!empty($params['v'])) {
            return 'https://www.youtube.com/embed/' . $params['v'];
        }
    }

    // Caso: ya viene en embed
    if (strpos($url, '/embed/') !== false) {
        return $url;
    }

    // Caso: shorts
    if (strpos($url, '/shorts/') !== false) {
        $videoId = substr($url, strrpos($url, '/') + 1);
        $videoId = explode('?', $videoId)[0];
        return 'https://www.youtube.com/embed/' . $videoId;
    }

    return '';
}

$sql = "SELECT * FROM `entradas` WHERE seccion_id=5 ORDER BY fecha DESC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $videos = [];
    while ($row = $result->fetch_assoc()) {
        $videos[] = $row;
    }

    // Visor de Vídeo
    echo '<div class="video-visor">';
    echo '  <div class="video-container">';
    echo '    <button class="prev-video">&#10094;</button>';
    echo '    <iframe id="video-grande" src="" frameborder="0" allowfullscreen></iframe>';
    echo '    <button class="next-video">&#10095;</button>';
    echo '  </div>';

    echo '  <div class="video-info">';
    echo '    <h3 id="video-titulo">Selecciona un vídeo</h3>';
    echo '    <p id="video-contenido"></p>';
    echo '  </div>';

    // Lista de Miniaturas (Tu JS las convertirá en array)
    echo '  <div class="video-miniaturas">';
    foreach ($videos as $v) {
        $urlEmbed = prepararYoutube($v['video_url']);
        // Extraemos ID para la imagen de previsualización
        $id = substr($urlEmbed, strrpos($urlEmbed, '/') + 1);

        echo '<img class="miniatura" 
                src="https://img.youtube.com/vi/' . $id . '/mqdefault.jpg" 
                data-url="' . $urlEmbed . '" 
                data-titulo="' . htmlspecialchars($v['titulo']) . '" 
                data-contenido="' . htmlspecialchars($v['contenido'] ?? '') . '" 
               data-anio="' . (!empty($v['fecha']) ? date('Y', strtotime($v['fecha'])) : '') . '">';
    }
    echo '  </div>';
    echo '</div>';
}
