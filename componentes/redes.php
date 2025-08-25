<?php
include_once(__DIR__ . '/../config/db.php');

$sql = "SELECT nombre_red, enlace FROM redes";
$result = $conn->query($sql);

$redes = [];

if ($result && $result->num_rows > 0) {
    while ($fila = $result->fetch_assoc()) {
        $redes[] = $fila;
    }
}
?>

<div id="redes" class="redes-sociales">
    <?php foreach ($redes as $red): ?>
        <?php
        $nombre = strtolower($red['nombre_red']);
        $enlace = $red['enlace'];

        if ($nombre === 'correo electrónico') {
            $icono = 'envelope';
            $clase_icono = 'fas';
            $enlace = 'mailto:' . $enlace;
        } else {
            $icono = $nombre;
            $clase_icono = 'fab';
        }
        ?>
        <a href="<?= $enlace ?>" target="_blank" class="icono <?= $nombre ?>">
            <i class="<?= $clase_icono ?> fa-<?= $icono ?>"></i>
        </a>
    <?php endforeach; ?>
</div>