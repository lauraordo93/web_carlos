<?php
session_start();
// Protección de ruta
if (!isset($_SESSION['admin_id'])) {
    header("Location: iniciar_sesion.php");
    exit;
}

include_once(__DIR__ . '/../config/db.php');

// --- CONFIGURACIÓN DE PAGINACIÓN ---
$registros_por_pagina = 10;
$pagina_actual = isset($_GET['p']) ? (int)$_GET['p'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Secciones permitidas según BBDD: 5=Videos, 2=Galeria, 6=Entrevistas
$secciones_permitidas = [
    5 => 'Vídeos',
    2 => 'Galería (Imágenes)',
    6 => 'Entrevistas'
];

$id_sec = isset($_GET['sec']) ? (int)$_GET['sec'] : 5;
if (!array_key_exists($id_sec, $secciones_permitidas)) {
    $id_sec = 5;
}

// 1. Contar total de registros para calcular páginas
$sql_count = "SELECT COUNT(*) as total FROM entradas WHERE seccion_id = ?";
$stmt_c = $conn->prepare($sql_count);
$stmt_c->bind_param("i", $id_sec);
$stmt_c->execute();
$total_registros = $stmt_c->get_result()->fetch_assoc()['total'];
$total_paginas = ceil($total_registros / $registros_por_pagina);

// 2. Consulta con LIMIT para no cargar todo de golpe
$sql = "SELECT id, titulo, fecha, foto_url FROM entradas WHERE seccion_id = ? ORDER BY fecha DESC LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii", $id_sec, $registros_por_pagina, $offset);
$stmt->execute();
$resultado = $stmt->get_result();

$titulo_gestion = $secciones_permitidas[$id_sec];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - <?php echo $titulo_gestion; ?></title>
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/entradas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="admin-body">

    <header class="admin-header">
        <div class="admin-topbar">
            <div class="admin-brand">
                <span class="admin-sax">🎷</span>
                <span class="admin-text"><strong>Administración</strong><span>Panel de Control</span></span>
            </div>
            <div class="admin-links">
                <a href="../index.php"><i class="fa-solid fa-house"></i> Volver a la web</a>
                <a href="cerrar_sesion.php" class="admin-salir"><i class="fa-solid fa-power-off"></i> Salir</a>
            </div>
        </div>
    </header>

    <main class="admin-main">
        <aside class="admin-sidebar">
            <h2>Secciones</h2>
            <a href="?sec=5" class="admin-btn <?php echo $id_sec == 5 ? 'active' : ''; ?>">Vídeos</a>
            <a href="?sec=2" class="admin-btn <?php echo $id_sec == 2 ? 'active' : ''; ?>">Imágenes</a>
            <a href="?sec=6" class="admin-btn <?php echo $id_sec == 6 ? 'active' : ''; ?>">Entrevistas</a>
            <hr>
            <a href="formulario_entradas.php?sec=<?php echo $id_sec; ?>" class="admin-btn-nueva">
                <i class="fa-solid fa-plus"></i> Nuevo Registro
            </a>
        </aside>

        <section class="admin-table-container">
            <h1 class="admin-title">Listado de <?php echo $titulo_gestion; ?></h1>

            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Recurso / Título</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($fila = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <?php if ($id_sec == 2 && !empty($fila['foto_url'])): ?>
                                        <img src="../<?php echo htmlspecialchars($fila['foto_url']); ?>" alt="img" class="img-thumb">
                                    <?php endif; ?>
                                    <span><?php echo htmlspecialchars($fila['titulo'] ?: $fila['foto_url']); ?></span>
                                </div>
                            </td>
                            <td><?php echo $fila['fecha'] ?: 'S/D'; ?></td>
                            <td class="admin-actions">
                                <a href="formulario_entradas.php?id=<?php echo $fila['id']; ?>&sec=<?php echo $id_sec; ?>" class="editar"><i class="fa-solid fa-pen"></i></a>
                                <a href="borrar_entradas.php?id=<?php echo $fila['id']; ?>&sec=<?php echo $id_sec; ?>" class="borrar" onclick="return confirm('¿Eliminar registro?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <?php if ($total_paginas > 1): ?>
                <div class="pagination">
                    <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                        <a href="?sec=<?php echo $id_sec; ?>&p=<?php echo $i; ?>" class="page-link <?php echo ($i == $pagina_actual) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                    <?php endfor; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
    <footer class="admin-footer">
        <p class="copyright-line">
            &copy; 2026 Todos los derechos reservados
            <a href="https://lauraordo93.github.io/Portfolio/" target="_blank" rel="noopener">lauraordonez.dev</a>
        </p>
    </footer>
</body>

</html>