<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Admin' ?> - Carlos Ordoñez</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    <!-- CSS dinámicos desde el controlador -->
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link rel="stylesheet" href="<?= URLROOT ?>/<?= $css ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>

<body class="admin-body">

    <!-- Header según CSS -->
    <header class="admin-header">
        <div class="admin-topbar">
            <div class="admin-brand">
                <div class="admin-sax">🎷</div>
                <div class="admin-text">
                    <strong>Carlos Ordoñez</strong>
                    <span>Panel de Control</span>
                </div>
            </div>

            <div class="admin-links">
                <a href="<?= URLROOT ?>" target="_blank"><i class="fas fa-external-link-alt"></i> Ver Web</a>
                <a href="<?= URLROOT ?>/admin/logout" class="admin-salir"><i class="fas fa-sign-out-alt"></i> Salir</a>
            </div>
        </div>
    </header>

    <!-- Título de página con el efecto de brillo morado -->
    <div class="admin-title">
        <?= $titulo ?? 'Gestión' ?>
    </div>

    <!-- Main Layout Flex -->
    <main class="admin-main">
        <div class="admin-container" style="display: flex; gap: 30px; width: 100%; max-width: 1300px;">

            <!-- Sidebar Lateral -->
            <aside class="admin-sidebar">
                <h2>Secciones</h2>
                <nav>
                    <a href="<?= URLROOT ?>/admin?sec=5" class="admin-btn <?= ($id_sec == 5) ? 'active' : '' ?>">
                        <i class="fas fa-video"></i> Vídeos
                    </a>
                    <a href="<?= URLROOT ?>/admin?sec=2" class="admin-btn <?= ($id_sec == 2) ? 'active' : '' ?>">
                        <i class="fas fa-images"></i> Galería
                    </a>
                    <a href="<?= URLROOT ?>/admin?sec=6" class="admin-btn <?= ($id_sec == 6) ? 'active' : '' ?>">
                        <i class="fas fa-microphone"></i> Entrevistas
                    </a>
                </nav>

                <a href="<?= URLROOT ?>/admin/nueva/<?= $id_sec ?>" class="admin-btn-nueva">
                    <i class="fas fa-plus"></i> NUEVO REGISTRO
                </a>
            </aside>

            <!-- Contenedor de Tabla / Contenido -->
            <div class="admin-table-container">
                <?= $content ?>
            </div>

        </div>
    </main>

    <!-- Footer según CSS -->
    <footer class="admin-footer">
        <p class="copyright-line">
            &copy; 2026 Todos los derechos reservados
            <a href="https://lauraordo93.github.io/Portfolio/" target="_blank" rel="noopener">lauraordonez.dev</a>
        </p>
    </footer>

    <!-- JS dinámicos desde el controlador -->
    <?php if (isset($extra_js)): ?>
        <?php foreach ($extra_js as $js): ?>
            <script src="<?= URLROOT ?>/<?= $js ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>