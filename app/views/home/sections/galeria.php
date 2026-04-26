<section id="galeria">
    <h2>Galería</h2>
    <div class="tabs">
        <button class="tab-btn active" data-tab="imagenes">Imágenes</button>
        <button class="tab-btn" data-tab="videos">Vídeos</button>
    </div>

    <div class="galeria active" id="imagenes">
        <?php if (!empty($galeria)): ?>
            <div class="swiper mainSwiper" id="swiper-principal">
                <div class="swiper-wrapper">
                    <?php foreach ($galeria as $index => $row): 
                        $url = htmlspecialchars(trim($row['foto_url']), ENT_QUOTES, 'UTF-8');
                        $loading = $index === 0 ? 'eager' : 'lazy';
                        $fetchpriority = $index === 0 ? 'high' : 'auto';
                    ?>
                        <div class="swiper-slide">
                            <img src="<?= $url ?>" alt="Imagen de galería" class="click-zoom" loading="<?= $loading ?>" decoding="async" fetchpriority="<?= $fetchpriority ?>" />
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <div class="swiper thumbSwiper">
                <div class="swiper-wrapper">
                    <?php foreach ($galeria as $row): 
                        $url = htmlspecialchars(trim($row['foto_url']), ENT_QUOTES, 'UTF-8');
                    ?>
                        <div class="swiper-slide">
                            <img src="<?= $url ?>" alt="Miniatura" loading="lazy" decoding="async" />
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <p>No hay imágenes disponibles.</p>
        <?php endif; ?>
    </div>

    <div class="galeria" id="videos">
        <?php include __DIR__ . '/videos.php'; ?>
    </div>
</section>
