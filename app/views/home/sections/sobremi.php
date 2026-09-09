<?php
$sobre_mi = $sobre_mi ?? null;
$redes = $redes ?? [];
?>
<?php if (!empty($sobre_mi)): ?>
    <h2 class="sobre-mi-titulo"><?= htmlspecialchars($sobre_mi['titulo']) ?></h2>
    <div class="sobre-mi-texto">
        <p><?= nl2br(htmlspecialchars($sobre_mi['contenido'])) ?></p>
        <div class="centrado">
            <a href="#biografia" class="vermas">Bio completa</a>
        </div>
        <div id="redes" class="redes-sociales">
                <?php foreach ($redes as $red): ?>
                    <?php
                    $red_nombre = strtolower($red['nombre_red']);
                    $enlace = $red['enlace'];
                    if ($red_nombre === 'correo electrónico') {
                        $icono = 'envelope';
                        $clase_icono = 'fas';
                        $enlace = 'mailto:' . $enlace;
                    } else {
                        $icono = $red_nombre;
                        $clase_icono = 'fab';
                    }
                    ?>
                    <a href="<?= $enlace ?>" target="_blank" rel="noopener" class="icono <?= $red_nombre ?>" aria-label="<?= htmlspecialchars($red['nombre_red'], ENT_QUOTES, 'UTF-8') ?>">
                        <i class="<?= $clase_icono ?> fa-<?= $icono ?>" aria-hidden="true"></i>
                    </a>
                <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
