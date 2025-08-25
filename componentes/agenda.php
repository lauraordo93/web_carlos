<?php
include_once(__DIR__ . '/../config/db.php');

// Consulta para obtener la biografía (suponiendo que está en la tabla 'entradas' y la sección biografía tiene seccion_id=7, por ejemplo)
$sql = "SELECT * FROM agenda;";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo '<h2>Agenda</h2>';
    echo '<p>' . nl2br(htmlspecialchars($row["descripcion"])) . ' <i class="fas fa-calendar-alt" style="margin-left: 10px;"></i></p>';


} else {
    echo '<h2>AGENDA</h2>';
    echo '<p>No hay Agenda disponible en este momento.</p>';
}
?>



