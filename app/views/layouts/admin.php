<?php
$titulo = $titulo ?? 'Administración';
$id_sec = isset($id_sec) ? (int) $id_sec : 5;
$content = $content ?? '';
$extra_css = $extra_css ?? [];
$extra_js = $extra_js ?? [];
?><!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Administración' ?> - Carlos Ordoñez</title>
    
    <!-- Tipografía y recursos iconográficos -->
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- Inyección de estilos CSS específicos de la vista -->
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link rel="stylesheet" href="<?= asset_url($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body class="admin-body">

    <!-- Cabecera Superior (Topbar) -->
    <header class="admin-header">
        <div class="admin-topbar">
            <div class="admin-brand">
                <div class="admin-sax">🎷</div>
                <div class="admin-text">
                    <strong>Administración</strong>
                    <span></span>
                </div>
            </div>

            <div class="admin-links">
                <a href="<?= URLROOT ?>"><i class="fas fa-external-link-alt"></i> Visualizar Web</a>
                <a href="<?= URLROOT ?>/admin/logout" class="admin-salir"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <!-- Estructura Principal del Panel -->
    <main class="admin-main">

        <!-- Navegación Lateral (Sidebar) -->
        <aside class="admin-sidebar">
            <h2>Categorías</h2>
            <a href="<?= URLROOT ?>/admin?sec=5" class="admin-btn <?= ($id_sec == 5) ? 'active' : '' ?>">
                <i class="fas fa-video"></i> Vídeos
            </a>
            <a href="<?= URLROOT ?>/admin?sec=2" class="admin-btn <?= ($id_sec == 2) ? 'active' : '' ?>">
                <i class="fas fa-images"></i> Galería
            </a>
            <a href="<?= URLROOT ?>/admin?sec=6" class="admin-btn <?= ($id_sec == 6) ? 'active' : '' ?>">
                <i class="fas fa-microphone"></i> Entrevistas
            </a>

            <hr>
            
            <a href="<?= URLROOT ?>/admin/nueva/<?= $id_sec ?>" class="admin-btn-nueva">
                NUEVO REGISTRO
            </a>
        </aside>

        <!-- Área de Contenido Dinámico -->
        <div class="admin-table-container">
            <?= $content ?? '' ?>
        </div>

    </main>

    <!-- Pie de Página Administrativo -->
    <footer class="admin-footer">
        <p class="copyright-line">
            &copy; <?= date('Y') ?> Carlos Ordoñez. Gestión de contenidos.
            Desarrollado por <a href="https://lauraordo93.github.io/Portfolio/" target="_blank" rel="noopener">lauraordonez.dev</a>
        </p>
    </footer>

    <!-- Inyección de scripts JS específicos de la vista -->
    <?php if (isset($extra_js)): ?>
        <?php foreach ($extra_js as $js): ?>
            <script src="<?= asset_url($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>