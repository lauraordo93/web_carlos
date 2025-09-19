<?php
// Incluir solo una vez el archivo de conexión a la base de datos
include_once(__DIR__ . '/../config/db.php');

// Consulta SQL para obtener el registro de "sobre mi"
$sql = "SELECT * FROM `entradas` WHERE titulo = 'sobre mi' LIMIT 1;";
$result = $conn->query($sql);

// Verificar si hay resultados
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    echo '<h2 class="sobre-mi-titulo">' . htmlspecialchars($row["titulo"]) . '</h2>';

    echo '<div class="sobre-mi-texto">';
    echo '<p>' . nl2br(htmlspecialchars($row["contenido"])) . '</p>';

    echo '<div class="centrado">';
    echo '<a href="#biografia" class="vermas">Bio completa</a>';
    echo '</div>';

    // Aquí añadimos las redes sociales **dentro del bloque "Sobre mí"**
    echo '<div id="redes" class="redes-sociales">';
    $numRedes = count($redes);
    for ($i = 0; $i < $numRedes; $i++) {
        $nombre = strtolower($redes[$i]['nombre_red']);
        $enlace = $redes[$i]['enlace'];

        if ($nombre === 'correo electrónico') {
            $icono = 'envelope';
            $clase_icono = 'fas';
            $enlace = 'mailto:' . $enlace;
        } else {
            $icono = $nombre;
            $clase_icono = 'fab';
        }
        echo '<a href="' . $enlace . '" target="_blank" class="icono ' . $nombre . '">';
        echo '<i class="' . $clase_icono . ' fa-' . $icono . '"></i>';
        echo '</a>';
    }
    echo '</div>'; // cierre redes sociales

    echo '</div>'; // cierre sobre-mi-texto
} else {
    echo "<p>No se encontró contenido para 'Sobre mí'.</p>";
}
?>
