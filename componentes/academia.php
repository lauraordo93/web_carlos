<?php
include_once(__DIR__ . '/../config/db.php');

// Consulta para la tarjeta (texto + imagen principal)
$sql_tarjetas = "SELECT * FROM `academia` WHERE id=1;";
$result_tarjetas = $conn->query($sql_tarjetas);

// Consulta para la imagen derecha (solo imagen)
$sql_imagen = "SELECT foto_url FROM academia WHERE foto_url LIKE '%derecha%';";
$result_imagen = $conn->query($sql_imagen);

if ($result_tarjetas && $result_tarjetas->num_rows > 0) {
    echo '<h2>Academia</h2>';
    echo '<div id="academia-contenedor-general">';

    // Contenedor de la tarjeta izquierda
    echo '<div class="academia-contenedor">';

    while ($row = $result_tarjetas->fetch_assoc()) {
        $titulo = htmlspecialchars($row['titulo']);
        $contenido = htmlspecialchars($row['contenido']);
        $foto_url = htmlspecialchars($row['foto_url']);
        $enlace = htmlspecialchars($row['enlace']);

        echo '<div class="academia_class">';
        echo '  <div class="academia_texto">';
        echo "    <h3>$titulo</h3>";
        echo "    <p>$contenido</p>";
        echo "    <a href='$enlace' target='_blank'>Ver más</a>";
        echo '  </div>';

        // Imagen dentro de la tarjeta
        echo '  <div class="academia_imagen">';

        //Remplazo codigo(localhost) para servidor:
        echo "    <img src='/mi_pagweb/$foto_url' alt='Imagen'>";

        // echo "    <img src='$foto_url' alt='Imagen'>";//code servidor
        echo '  </div>';

        echo '</div>'; // cierre academia_class
    }

    echo '</div>'; // cierre academia-contenedor


} else {
    echo '<p>No hay academias disponibles.</p>';
}
?>