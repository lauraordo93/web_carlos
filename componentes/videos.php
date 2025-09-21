<?php
include_once(__DIR__ . '/../config/db.php');

function transformarYoutubeEmbed($url)
{
    parse_str(parse_url($url, PHP_URL_QUERY), $params);
    if (isset($params['v'])) {
        return 'https://www.youtube.com/embed/' . $params['v'];
    }
    return $url;
}

$sql = "SELECT * FROM `entradas` WHERE seccion_id=5;";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo '<h2>Vídeos</h2>';
    echo '<div class="slider-videos">'; // contenedor de todos los vídeos

    $index = 0;
    while ($row = $result->fetch_assoc()) {
        $titulo = htmlspecialchars($row['titulo']);
        $contenido = htmlspecialchars($row['contenido']);
        $video_url = htmlspecialchars($row['video_url']);
        $fecha = htmlspecialchars($row['fecha']);
        $anio = date('Y', strtotime($fecha));
        $activo = $index === 0 ? 'activo' : '';
        $video_url_embed = transformarYoutubeEmbed($video_url);

        echo '<div class="video ' . $activo . '">';
        echo '  <div class="video-info">';
        echo "<h3>$titulo</h3>";
        echo "<p>$contenido <strong>Año $anio</strong></p>";
        echo '  </div>';
        echo '  <div class="video-frame">';
        echo '<iframe width="560" height="315" src="' . $video_url_embed . '" title="' . $titulo . '" frameborder="0" allowfullscreen></iframe>';
        echo '</div>';
        echo '</div>';

        $index++;
    }

    // Botones de navegación
    echo '<button class="prev-video">&#10094;</button>'; // < izquierda
    echo '<button class="next-video">&#10095;</button>'; // > derecha

    echo '</div>'; // fin slider-videos
} else {
    echo '<p>No hay vídeos disponibles.</p>';
}
?>
