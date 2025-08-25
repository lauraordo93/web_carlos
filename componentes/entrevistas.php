<?php
include_once(__DIR__ . '/../config/db.php');
//SELECT titulo, contenido, enlace_url FROM entradas WHERE seccion_id=6;
// Consulta para obtener todas las entrevistas
// $sql = "SELECT * FROM entrevistas_id;";
$sql="SELECT * FROM `entradas` WHERE seccion_id=6";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    echo '<h2>Entrevistas</h2>';
    while ($row = $result->fetch_assoc()) {
        echo '<article class="entrevista">';
        echo '<h3>' . htmlspecialchars($row["titulo"]) . '</h3>';
        echo '<p>' . nl2br(htmlspecialchars($row["contenido"])) . '</p>';
        if (!empty($row["enlace_url"])) {
            echo '<a href="' . htmlspecialchars($row["enlace_url"]) . '" target="_blank" class="btn-entrevista">Leer entrevista</a>';
        }
        echo '</article>';
    }
} else {
    echo '<p>No hay entrevistas disponibles en este momento.</p>';
}
?>