<?php
$biografia = $biografia ?? null;
?>
<section id="biografia">
    <?php if (!empty($biografia)): ?>
        <h2>Biografía</h2>
        <p><?= nl2br($biografia['contenido']) ?></p>
    <?php else: ?>
        <h2>Biografía</h2>
        <p>No hay biografía disponible en este momento.</p>
    <?php endif; ?>

    <div class="bio-links">
        <a href="<?= asset_url('doc/bio.pdf') ?>" download class="btn-descarga-biografia">📥 Descargar biografía</a>
        <div class="artist-yamaha">
            <strong>Artist by</strong>
            <a href="https://es.yamaha.com/es/musical-instruments/brass-woodwinds/artists/c/carlos-ordonez-de%20arce.html" target="_blank" rel="noopener noreferrer">
                <img src="<?= asset_url('img/logo_yamaha1.png') ?>" alt="Yamaha">
            </a>
        </div>
    </div>
</section>
