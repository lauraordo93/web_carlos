<?php
$videos = $videos ?? [];
?>
<?php if (!empty($videos)): ?>
    <div class="video-visor">
        <div class="video-container">
            <button class="prev-video" aria-label="Vídeo anterior">&#10094;</button>
            <div id="video-cookie-aviso" style="display: none; position: absolute; top: 0; left: 0; width: 100%; height: 100%; align-items: center; justify-content: center; text-align: center; color: white; padding: 2rem; background: #000; z-index: 10;">
                <p>Para reproducir vídeos de YouTube necesitas aceptar las cookies de terceros.</p>
            </div>
            <iframe id="video-grande" src="" title="Reproductor de YouTube" loading="lazy" frameborder="0" allowfullscreen></iframe>
            <button class="next-video" aria-label="Vídeo siguiente">&#10095;</button>
        </div>

        <div class="video-info">
            <h2 class="sr-only">Vídeos</h2>
            <h3 id="video-titulo">Selecciona un vídeo</h3>
            <p id="video-contenido"></p>
        </div>

        <div class="video-miniaturas">
            <?php foreach ($videos as $v): 
                $urlEmbed = prepararYoutube($v['video_url']);
                $id = substr($urlEmbed, strrpos($urlEmbed, '/') + 1);
                
                // Crear placeholder SVG con el título del vídeo
                $tituloCorto = htmlspecialchars(mb_strimwidth($v['titulo'], 0, 18, '...'), ENT_QUOTES, 'UTF-8');
                $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="120" height="70"><rect width="100%" height="100%" fill="#222"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#fff" font-family="sans-serif" font-size="11">'.$tituloCorto.'</text></svg>';
                $svgBase64 = 'data:image/svg+xml;base64,' . base64_encode($svg);
            ?>
                <img class="miniatura" 
                     src="<?= $svgBase64 ?>" 
                     data-src="https://img.youtube.com/vi/<?= $id ?>/mqdefault.jpg" 
                     alt="Miniatura de: <?= htmlspecialchars($v['titulo']) ?>"
                     loading="lazy"
                     decoding="async"
                     role="button"
                     tabindex="0"
                     data-url="<?= $urlEmbed ?>" 
                     data-titulo="<?= htmlspecialchars($v['titulo']) ?>" 
                     data-contenido="<?= htmlspecialchars($v['contenido'] ?? '') ?>" 
                     data-anio="<?= (!empty($v['fecha']) ? date('Y', strtotime($v['fecha'])) : '') ?>">
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
