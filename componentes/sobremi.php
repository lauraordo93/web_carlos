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
    // Mostrar contenido de la base de datos
    // echo '<h2 class="mt-3">' . htmlspecialchars($row["titulo"]) . '</h2>';
    echo '<div class="sobre-mi-texto">';
    echo '<p>' . nl2br(htmlspecialchars($row["contenido"])) . '</p>';
    echo '<div class="centrado">';
    echo '<a href="#biografia" class="vermas">Biografía</a>';
    echo '</div>';
    echo '</div>';
} else {
    echo "<p>No se encontró contenido para 'Sobre mí'.</p>";
}
?>