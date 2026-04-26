<?php
$is_home = false;
ob_start();
?>

<main>
    <section id="texto-legal-content" style=" padding-top: 100px; padding-bottom: 50px;">
        <div class="container" style="max-width: 900px; margin: auto; padding: 0 20px; text-align: left;">
            
            <h1 style="color: var(--color_yamaha); margin-bottom: 30px; text-align: center;">
                <?= $titulo ?>
            </h1>
            
            <div class="texto-legal">
                <?php 
                $file_path = __DIR__ . '/texts/' . $view_file . '.php';
                if (file_exists($file_path)) {
                    include $file_path;
                } else {
                    echo "<p>Documento no encontrado.</p>";
                }
                ?>
            </div>
        </div>
    </section>
</main>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/default.php';
?>
