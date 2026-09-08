<?php
$biografia = $biografia ?? null;
$parrafos_html = '';
if (!empty($biografia)) {
    $contenido_bio = $biografia['contenido'];
    // 1. Quitar guiones de fin de línea generados al copiar de un PDF
    $contenido_bio = preg_replace('/-\r?\n\s*/', '', $contenido_bio);
    // 2. Unificar saltos de línea a \n
    $contenido_bio = str_replace("\r\n", "\n", $contenido_bio);
    // 3. Reemplazar saltos de línea simples por un espacio
    $contenido_bio = preg_replace('/(?<!\n)\n(?!\n)/', ' ', $contenido_bio);
    // 4. Limpiar posibles espacios dobles
    $contenido_bio = preg_replace('/[ \t]+/', ' ', $contenido_bio);
    
    // 5. Separar por los verdaderos saltos de párrafo (ignorando espacios intermedios)
    $parrafos = preg_split('/\n\s*\n/', trim($contenido_bio));
    
    if (count($parrafos) > 0) {
        foreach ($parrafos as $p) {
            $parrafos_html .= '<p class="bio-parrafo">' . htmlspecialchars(trim($p)) . '</p>';
        }
    }
}
?>
<section id="biografia" class="caja-seccion">
    <?php if (!empty($biografia)): ?>
        <h2>Biografía</h2>
        <div class="bio-texto">
            <?= $parrafos_html ?>
        </div>
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
