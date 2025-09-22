<?php
include_once(__DIR__ . '/../config/db.php');

function transformarYoutubeEmbed($url)
{
    parse_str(parse_url($url, PHP_URL_QUERY), $params);
    return isset($params['v']) ? 'https://www.youtube.com/embed/' . $params['v'] : $url;
}

// Obtener vídeos
$sql = "SELECT * FROM `entradas` WHERE seccion_id=5;";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $videos = [];

    // Guardamos todos los vídeos en un array para iterar
    while ($row = $result->fetch_assoc()) {
        $videos[] = [
            'titulo' => htmlspecialchars($row['titulo']),
            'contenido' => htmlspecialchars($row['contenido']),
            'video_url' => htmlspecialchars($row['video_url']),
            'anio' => date('Y', strtotime($row['fecha'])),
            'video_embed' => transformarYoutubeEmbed($row['video_url'])
        ];
    }

    // Primer vídeo
    $primero = $videos[0];

    // Visor grande + botones
    echo '<div class="visor">';
    // echo '<h2>Vídeos</h2>';
    echo '<div class="video-container">';
    echo '<button class="prev-video">&#10094;</button>';
    echo '<iframe id="video-grande" width="560" height="315" src="' . $primero['video_embed'] . '" frameborder="0" allowfullscreen></iframe>';
    echo '<button class="next-video">&#10095;</button>';
    echo '</div>'; // fin video-container
    echo '<div class="video-info">';
    echo '<h3 id="video-titulo">' . $primero['titulo'] . '</h3>';
    echo '<p id="video-contenido">' . $primero['contenido'] . ' (Año ' . $primero['anio'] . ')</p>';
    echo '</div>';
    echo '</div>'; // fin visor

    // Miniaturas
    echo '<div class="miniaturas">';
    foreach ($videos as $v) {
        $idVideo = substr($v['video_embed'], strrpos($v['video_embed'], '/') + 1);
        $thumbnail = "https://img.youtube.com/vi/$idVideo/0.jpg";
        echo '<img class="miniatura" src="' . $thumbnail . '" data-url="' . $v['video_embed'] . '" data-titulo="' . $v['titulo'] . '" data-contenido="' . $v['contenido'] . '" data-anio="' . $v['anio'] . '">';
    }
    echo '</div>';

} else {
    echo '<p>No hay vídeos disponibles.</p>';
}
?>
