<?php
include_once(__DIR__ . '/../config/db.php');

function transformarYoutubeEmbed($url)
{
    parse_str(parse_url($url, PHP_URL_QUERY), $params);
    if (isset($params['v'])) {
        return 'https://www.youtube.com/embed/' . $params['v'];
    }
    return $url; // Por si ya está en formato embed o no tiene 'v'
}

// $sql = "SELECT * FROM videos;";
$sql="SELECT * FROM `entradas` WHERE seccion_id=5;";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo '<h2>Vídeos</h2>';

    while ($row = $result->fetch_assoc()) {
        $titulo = htmlspecialchars($row['titulo']);
        $contenido = htmlspecialchars($row['contenido']);
        $video_url = htmlspecialchars($row['video_url']);
        $fecha = htmlspecialchars($row['fecha']);
        $anio = date('Y', strtotime($fecha));

        // Aquí transformamos la URL normal a URL embed
        $video_url_embed = transformarYoutubeEmbed($video_url);

        echo '<div class="video">';
        echo '  <div class="video-info">';
        echo "<h3>$titulo</h3>";
        echo "<p>$contenido <strong>Año $anio</strong></p>";
        echo '  </div>';
        echo '  <div class="video-frame">';
        echo '<iframe width="560" height="315" src="' . $video_url_embed . '" title="' . $titulo . '" frameborder="0" allowfullscreen></iframe>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p>No hay vídeos disponibles.</p>';
}
?>