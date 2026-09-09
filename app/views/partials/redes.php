<?php
$redes = $redes ?? [];
?>
<div id="redes" class="redes-sociales">
    <?php if (!empty($redes)): ?>
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
    <?php endif; ?>
</div>
