<?php
$titulo_pagina = $titulo_pagina ?? SITENAME;
$is_home = $is_home ?? false;
$content = $content ?? '';
$extra_css = $extra_css ?? [];
$extra_js = $extra_js ?? [];
$menu = $menu ?? [];
$redes = $redes ?? [];
$header = $header ?? [];

// ---------------------------------------------------------
// Metadatos SEO (Fase 2)
// ---------------------------------------------------------
// Si los controladores pasan $seoTitle o $seoDescription, se usarán; si no, defaults globales
$seoTitle = $seoTitle ?? $titulo_pagina;
$seoDescription = $seoDescription ?? 'Web oficial de Carlos Ordóñez de Arce.';

// Generar canonical url de producción independiente del host actual y del subdirectorio local
$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';
if (defined('BASE_PATH') && BASE_PATH !== '') {
    if (strpos($currentPath, BASE_PATH) === 0) {
        $currentPath = substr($currentPath, strlen(BASE_PATH));
    }
}
if ($currentPath === '' || $currentPath[0] !== '/') {
    $currentPath = '/' . ltrim($currentPath, '/');
}
$seoCanonical = $seoCanonical ?? (rtrim(CANONICAL_URLROOT, '/') . $currentPath);

$seoRobots = $seoRobots ?? 'index, follow';
$seoImage = $seoImage ?? (CANONICAL_URLROOT . '/img/pentagrama4.jpg');

// Escapar para atributos HTML
$escTitle = esc_attr($seoTitle);
$escDesc = esc_attr($seoDescription);
$escCanonical = esc_attr($seoCanonical);
$escRobots = esc_attr($seoRobots);
$escImage = esc_attr($seoImage);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $escTitle ?></title>
    <meta name="description" content="<?= $escDesc ?>">
    <link rel="canonical" href="<?= $escCanonical ?>">
    <meta name="robots" content="<?= $escRobots ?>">

    <!-- Open Graph -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= $escTitle ?>">
    <meta property="og:description" content="<?= $escDesc ?>">
    <meta property="og:url" content="<?= $escCanonical ?>">
    <meta property="og:image" content="<?= $escImage ?>">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $escTitle ?>">
    <meta name="twitter:description" content="<?= $escDesc ?>">
    <meta name="twitter:image" content="<?= $escImage ?>">

    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="apple-touch-icon" href="<?= asset_url('img/sax.png') ?>">
    <link rel="icon" type="image/png" href="<?= asset_url('img/sax.png') ?>">

    <!-- CSS dinámicos desde el controlador -->
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <link rel="stylesheet" href="<?= asset_url($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>


    <?php if (!empty($jsonLd)): ?>
    <script type="application/ld+json">
        <?= json_encode(
            $jsonLd,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
        ) ?>
    </script>
    <?php endif; ?>
</head>

<body>

    <header id="inicio">
        <nav class="nav-container">
            <?php include __DIR__ . '/../partials/menunav.php'; ?>
        </nav>

        <?php if (isset($is_home) && $is_home): ?>
            <div class="logo">
                <?php include __DIR__ . '/../partials/logo.php'; ?>
                <h1 class="sr-only">Carlos Ordóñez de Arce</h1>
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
                <a href="<?= site_url('legal/aviso-legal') ?>">Aviso Legal</a> |
                <a href="<?= site_url('legal/privacidad') ?>">Política de Privacidad</a> |
                <a href="<?= site_url('legal/cookies') ?>">Política de Cookies</a>
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
                <a href="<?= site_url('legal/cookies') ?>" target="_blank">Más información</a>
            </p>
            <div class="cookies-botones">
                <button type="button" id="btn-aceptar-cookies">Aceptar todas</button>
                <button type="button" id="btn-rechazar-cookies" class="btn-secundario">Rechazar</button>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- JS dinámicos desde el controlador -->
    <?php if (isset($extra_js)): ?>
        <?php foreach ($extra_js as $js): ?>
            <script src="<?= asset_url($js) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>

</body>

</html>