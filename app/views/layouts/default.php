<?php
$titulo_pagina = $titulo_pagina ?? 'Página web Carlos';
$is_home = $is_home ?? false;
$content = $content ?? '';
$extra_css = $extra_css ?? [];
$extra_js = $extra_js ?? [];
$menu = $menu ?? [];
$redes = $redes ?? [];
$header = $header ?? [];
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $titulo_pagina ?? 'Página web Carlos' ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="apple-touch-icon" href="<?= asset_url('img/sax.png') ?>">
    <link rel="icon" type="image/png" href="<?= asset_url('img/sax.png') ?>">

    <!-- CSS dinámicos desde el controlador -->
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link rel="stylesheet" href="<?= asset_url($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-H3W4025HLX"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-H3W4025HLX');
    </script>

</head>

<body>

    <header id="inicio">
        <nav class="nav-container">
            <?php include __DIR__ . '/../partials/menunav.php'; ?>
        </nav>

        <?php if (isset($is_home) && $is_home): ?>
            <div class="logo">
                <?php include __DIR__ . '/../partials/logo.php'; ?>
            </div>

            <div class="intro">
                <?php include __DIR__ . '/../home/sections/sobremi.php'; ?>
            </div>
        <?php else: ?>
            <div class="contenedor-del-logo">
                <img src="<?= asset_url('img/pentagrama4.jpg') ?>" alt="Logo central" class="imagen-logo">
            </div>
        <?php endif; ?>
    </header>

    <?php if (isset($is_home) && $is_home): ?>
        <div class="redes-sociales-movil">
            <?php include __DIR__ . '/../partials/redes.php'; ?>
        </div>
    <?php endif; ?>

    <main>
        <?= $content ?>
    </main>

    <footer class="footerprincipal">
        <div class="footer-container">
            <div class="footer-left">
                <img src="<?= asset_url('img/imagen_derecha.jpg') ?>" alt="Logo" class="footer-logo">
            </div>

            <?php include __DIR__ . '/../partials/contacto.php'; ?>
        </div>

        <div class="footer-bottom">
            <p class="copyright-line">
                &copy; 2026 Todos los derechos reservados
                <a href="https://lauraordo93.github.io/Portfolio/" target="_blank" rel="noopener">lauraordonez.dev</a>
            </p>
            <div class="enlaces-legales-container">
                <a href="<?= site_url('legal?doc=aviso_legal') ?>">Aviso Legal</a> |
                <a href="<?= site_url('legal?doc=privacidad') ?>">Política de Privacidad</a> |
                <a href="<?= site_url('legal?doc=cookies') ?>">Política de Cookies</a>
            </div>
        </div>
    </footer>

    <!-- Ventana de cookies -->
    <div id="overlay-cookies" class="overlay-cookies">
        <div class="modal-cookies">
            <h3>Configuración de cookies 🎷</h3>
            <p>
                Usamos cookies propias y de terceros para analizar el uso del sitio y mejorar tu experiencia.
                Puedes aceptar todas las cookies o rechazarlas.
                <a href="<?= site_url('legal?doc=cookies') ?>" target="_blank">Más información</a>
            </p>
            <div class="cookies-botones">
                <button id="btn-aceptar-cookies">Aceptar todas</button>
                <button id="btn-rechazar-cookies" class="btn-secundario">Rechazar</button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        if (typeof Fancybox !== 'undefined') {
            Fancybox.bind("[data-fancybox='gallery']", {});
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- JS dinámicos desde el controlador -->
    <?php if (isset($extra_js)): ?>
        <?php foreach ($extra_js as $js): ?>
            <script src="<?= asset_url($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>