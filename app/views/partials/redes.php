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
            <a href="<?= $enlace ?>" target="_blank" class="icono <?= $red_nombre ?>">
                <i class="<?= $clase_icono ?> fa-<?= $icono ?>"></i>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
