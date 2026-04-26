<?php if (!empty($videos)): ?>
    <div class="video-visor">
        <div class="video-container">
            <button class="prev-video">&#10094;</button>
            <iframe id="video-grande" src="" frameborder="0" allowfullscreen></iframe>
            <button class="next-video">&#10095;</button>
        </div>

        <div class="video-info">
            <h3 id="video-titulo">Selecciona un vídeo</h3>
            <p id="video-contenido"></p>
        </div>

        <div class="video-miniaturas">
            <?php foreach ($videos as $v): 
                $urlEmbed = prepararYoutube($v['video_url']);
                $id = substr($urlEmbed, strrpos($urlEmbed, '/') + 1);
            ?>
                <img class="miniatura" 
                     src="https://img.youtube.com/vi/<?= $id ?>/mqdefault.jpg" 
                     data-url="<?= $urlEmbed ?>" 
                     data-titulo="<?= htmlspecialchars($v['titulo']) ?>" 
                     data-contenido="<?= htmlspecialchars($v['contenido'] ?? '') ?>" 
                     data-anio="<?= (!empty($v['fecha']) ? date('Y', strtotime($v['fecha'])) : '') ?>">
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
