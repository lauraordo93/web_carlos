<?php
$biografia = $biografia ?? null;
$contenido_bio = '';
if (!empty($biografia)) {
    $contenido_bio = $biografia['contenido'];
    // 1. Quitar guiones de fin de línea generados al copiar de un PDF ("estudian-\ntes" -> "estudiantes")
    $contenido_bio = preg_replace('/-\r?\n\s*/', '', $contenido_bio);
    // 2. Unificar saltos de línea a \n
    $contenido_bio = str_replace("\r\n", "\n", $contenido_bio);
    // 3. Reemplazar saltos de línea simples por un espacio (para evitar que se partan frases por la mitad)
    // Conserva los saltos de línea dobles o mayores que indican un verdadero cambio de párrafo.
    $contenido_bio = preg_replace('/(?<!\n)\n(?!\n)/', ' ', $contenido_bio);
    // 4. Limpiar posibles espacios dobles o múltiples que hayan quedado al unir líneas
    $contenido_bio = preg_replace('/[ \t]+/', ' ', $contenido_bio);
}
?>
<section id="biografia" class="caja-seccion">
    <?php if (!empty($biografia)): ?>
        <h2>Biografía</h2>
        <p><?= nl2br($contenido_bio) ?></p>
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
