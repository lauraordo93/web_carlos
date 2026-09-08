<?php
$is_home = false;
ob_start();
?>

<main>
    <section class="caja-seccion" style="text-align: center; padding: 4rem 1rem;">
        <h1 style="color: var(--color_yamahaClaro); font-size: 4rem; margin-bottom: 1rem;">404</h1>
        <h2>Página no encontrada</h2>
        <p style="margin-top: 1rem;">La página que buscas no existe o ha cambiado de dirección.</p>
        <div style="margin-top: 2rem;">
            <a href="<?= site_url() ?>" style="display: inline-block; padding: 10px 20px; background-color: var(--color_yamaha); color: #fff; text-decoration: none; border-radius: 4px; font-weight: 600;">Volver al inicio</a>
        </div>
    </section>
</main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/default.php';
?>
