<?php
include_once(__DIR__ . '/../config/db.php');

$sql = "SELECT titulo, contenido FROM entradas WHERE seccion_id = 1 ORDER BY fecha DESC LIMIT 1;";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo '<h2>Biografía</h2>';
    // Mostramos el contenido interpretando etiquetas HTML, sin usar htmlspecialchars
    echo '<p>' . nl2br($row["contenido"]) . '</p>';
//    echo '<p>' . nl2br(htmlspecialchars($row["contenido"])) . '</p>';
} else {
    echo '<h2>Biografía</h2>';
    echo '<p>No hay biografía disponible en este momento.</p>';
}

// 🔗 Enlace al PDF (siempre visible)
echo '<p><a href="../doc/bio.pdf" download class="btn-descarga-biografia">📥 Descargar biografía</a></p>';

?>