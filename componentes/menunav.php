<?php
include_once(__DIR__ . '/../config/db.php');

// Consulta para obtener todos los elementos del menú ordenados por ID
// $sql = "SELECT * FROM menu ORDER BY id ASC";
//Consulta ordenada por preferencia Usuario
$sql = "SELECT * FROM menu 
        ORDER BY FIELD(nombre, 'Biografía', 'Madrid Sax Academy', 'Galería', 'Videos', 'Entrevistas', 'Agenda','Contacto')";
$result = $conn->query($sql);

// IDs personalizados
$ids_personalizados = [
    'Biografía' => 'biografia',
    'Madrid Sax Academy' => 'madrid-sax-academy',
    'Galería' => 'galeria',
    // 'Videos' => 'videos',
    'Entrevistas' => 'entrevistas',
    'Agenda' => 'agenda',
    'Contacto' => 'contacto',
    // 'Redes Sociales' => 'redes'
];

// Contenedor del menú
echo '<div class="nav-container">';
echo '<ul class="nav-menu">';

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nombre = $row['nombre'];

        if (isset($ids_personalizados[$nombre])) {
            $id = $ids_personalizados[$nombre];
            //Cambio para que funciona con legal
           echo '<li><a href="index.php#' . htmlspecialchars($id) . '">' . htmlspecialchars($nombre) . '</a></li>';
        }
    }
} else {
    echo '<li>No se encontró ningún elemento de menú.</li>';
}

echo '</ul>';

// Botón hamburguesa para móvil
echo '<button class="nav-toggle" aria-label="Abrir menú">
        <span></span>
        <span></span>
        <span></span>
      </button>';

echo '</div>';
?>