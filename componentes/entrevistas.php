<?php
include_once(__DIR__ . '/../config/db.php');
include_once(__DIR__ . '/../config/funciones.php');

$sql = "SELECT * FROM `entradas` WHERE seccion_id=6";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo '<h2>Entrevistas</h2>';
    echo '<div class="contenedor-entrevistas">'; // ABRIR CONTENEDOR
   
    while ($row = $result->fetch_assoc()) {
    
        echo '<article class="entrevista">';

        echo '<div class="contenido">';
        echo '<h3>' . htmlspecialchars($row["titulo"]) . '</h3>';

        // Mostrar video si existe(oculto de momento)
        // if (!empty($row["enlace_url"])) {
        //     $embedUrl = transformarYoutubeEmbed($row["enlace_url"]);
        //     echo '<div class="video-container" style="margin-bottom: 2em;">';
        //     echo '<iframe src="' . htmlspecialchars($embedUrl) . '" frameborder="0" allowfullscreen style="width: 100%; aspect-ratio: 16/9;"></iframe>';
        //     echo '</div>';
        // }

        echo '<p>' . nl2br(htmlspecialchars($row["contenido"])) . '</p>';
        if (!empty($row["enlace_url"])) {
            echo '<a href="' . htmlspecialchars($row["enlace_url"]) . '" target="_blank" class="btn-entrevista">Ver en YouTube</a>';
        }
        echo '</div>';

        if (!empty($row["foto_url"])) {
            echo '<img src="' . htmlspecialchars($row["foto_url"]) . '" alt="Logo" class="logo-entrevista">';
        }

        echo '</article>';
    }

    echo '</div>'; // CERRAR CONTENEDOR
}
?>