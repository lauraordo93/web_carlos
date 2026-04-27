<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: iniciar_sesion.php");
    exit;
}

include_once(__DIR__ . '/../config/db.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$id_sec = isset($_GET['sec']) ? (int)$_GET['sec'] : 5;

$secciones_permitidas = [2, 5, 6];
if (!in_array($id_sec, $secciones_permitidas, true)) {
    $id_sec = 5;
}

if ($id <= 0) {
    header("Location: listar_entradas.php?sec=" . $id_sec);
    exit;
}

// Opcional: comprobar que existe y pertenece a la sección
$sql_check = "SELECT id FROM entradas WHERE id = ? AND seccion_id = ? LIMIT 1";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("ii", $id, $id_sec);
$stmt_check->execute();
$res = $stmt_check->get_result();
$existe = $res->fetch_assoc();
$stmt_check->close();

if (!$existe) {
    header("Location: listar_entradas.php?sec=" . $id_sec);
    exit;
}

$sql = "DELETE FROM entradas WHERE id = ? AND seccion_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id, $id_sec);
$stmt->execute();
$stmt->close();

header("Location: listar_entradas.php?sec=" . $id_sec);
exit;
