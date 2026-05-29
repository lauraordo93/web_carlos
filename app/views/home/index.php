<?php
// Indicar que estamos en la home para el layout
$is_home = true;

// Empezar a capturar el contenido
ob_start();
?>

<?php include __DIR__ . '/sections/biografia.php'; ?>
<?php include __DIR__ . '/sections/academia.php'; ?>
<?php include __DIR__ . '/sections/galeria.php'; ?>
<?php include __DIR__ . '/sections/entrevistas.php'; ?>
<?php include __DIR__ . '/sections/agenda.php'; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/default.php';
?>
