<?php
include_once(__DIR__ . '/../config/db.php');

// Consulta para la tarjeta (texto + imagen principal)
$sql_tarjetas = "SELECT * FROM `academia` WHERE id=1;";
$result_tarjetas = $conn->query($sql_tarjetas);

echo '<h2>Academia</h2>';
echo '<div id="academia-contenedor-general">';
echo '<div class="academia-contenedor">';

if ($result_tarjetas && $result_tarjetas->num_rows > 0) {
    while ($row = $result_tarjetas->fetch_assoc()) {
        $titulo = htmlspecialchars($row['titulo']);
        $contenido = htmlspecialchars($row['contenido']);
        $foto_url = htmlspecialchars($row['foto_url']);
        $enlace = htmlspecialchars($row['enlace']);
        $instagram = htmlspecialchars($row['instagram']); // nuevo campo

        echo '<div class="academia_class">';

        // Contenedor de texto + enlaces
        echo '  <div class="academia_texto">';
        echo "    <h3>$titulo</h3>";
        echo "    <p>$contenido</p>";

        // Contenedor de enlaces (Web + Instagram)
        echo '    <div class="academia_enlaces">';
        echo "      <a href='$enlace' target='_blank'>Web</a>";

        if (!empty($instagram)) {
            echo "      <a href='$instagram' target='_blank' class='icono instagram'>
                      <i class='fab fa-instagram'></i>
                  </a>";
        }

        echo '    </div>'; // cierre academia_enlaces
        echo '  </div>';   // cierre academia_texto

        // Imagen
        echo '  <div class="academia_imagen">';
        echo "    <img src='/mi_pagweb/$foto_url' alt='Imagen'>";
        echo '  </div>';
   

        echo '</div>'; // cierre academia_class
    }
} else {
    echo '<p>No hay academias disponibles.</p>';
}

echo '</div>'; // cierre academia-contenedor
echo '</div>'; // cierre academia-contenedor-general
?>
