<?php
$proximos_eventos = $proximos_eventos ?? [];
$eventos_anteriores = $eventos_anteriores ?? [];

$formatearFecha = static function ($fecha) {
    if (empty($fecha)) {
        return '';
    }

    $timestamp = strtotime($fecha);
    return $timestamp ? date('d/m/Y', $timestamp) : '';
};
?>

<section id="agenda">
    <h2>Agenda</h2>

    <div class="agenda-bloque">
        <h3>Próximos eventos</h3>

        <?php if (!empty($proximos_eventos)): ?>
            <div class="agenda-lista">
                <?php foreach ($proximos_eventos as $evento): ?>
                    <article class="agenda-evento">
                        <time datetime="<?= htmlspecialchars($evento['fecha'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($formatearFecha($evento['fecha']), ENT_QUOTES, 'UTF-8') ?>
                        </time>

                        <div class="agenda-evento-contenido">
                            <h4><?= htmlspecialchars($evento['titulo'], ENT_QUOTES, 'UTF-8') ?></h4>

                            <?php if (!empty($evento['lugar'])): ?>
                                <p class="agenda-lugar"><?= htmlspecialchars($evento['lugar'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php endif; ?>

                            <?php if (!empty($evento['descripcion'])): ?>
                                <p class="agenda-descripcion"><?= nl2br(htmlspecialchars($evento['descripcion'], ENT_QUOTES, 'UTF-8')) ?></p>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="mensaje-agenda">
                <p>Muy pronto anunciaremos nuevos conciertos y eventos.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($eventos_anteriores)): ?>
        <div class="agenda-bloque agenda-bloque-pasados">
            <h3>Eventos anteriores</h3>

            <div class="agenda-lista">
                <?php foreach ($eventos_anteriores as $evento): ?>
                    <article class="agenda-evento agenda-evento-pasado">
                        <time datetime="<?= htmlspecialchars($evento['fecha'], ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($formatearFecha($evento['fecha']), ENT_QUOTES, 'UTF-8') ?>
                        </time>

                        <div class="agenda-evento-contenido">
                            <h4><?= htmlspecialchars($evento['titulo'], ENT_QUOTES, 'UTF-8') ?></h4>

                            <?php if (!empty($evento['lugar'])): ?>
                                <p class="agenda-lugar"><?= htmlspecialchars($evento['lugar'], ENT_QUOTES, 'UTF-8') ?></p>
                            <?php endif; ?>

                            <?php if (!empty($evento['descripcion'])): ?>
                                <p class="agenda-descripcion"><?= nl2br(htmlspecialchars($evento['descripcion'], ENT_QUOTES, 'UTF-8')) ?></p>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</section>
