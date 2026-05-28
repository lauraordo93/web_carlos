<?php
$academia = $academia ?? null;
?>
<section id="madrid-sax-academy">
    <div id="academia-contenedor-general">
        <div class="academia-contenedor">
            <h2>Academia</h2>
            <?php if (!empty($academia)): 
                $titulo = htmlspecialchars($academia['titulo']);
                $contenido = htmlspecialchars($academia['contenido']);
                $foto_url = htmlspecialchars(asset_url($academia['foto_url']));
                $enlace = htmlspecialchars($academia['enlace']);
                $instagram = htmlspecialchars($academia['instagram'] ?? '');
            ?>
                <div class="academia_class">
                    <div class="academia_texto">
                        <h3><?= $titulo ?></h3>
                        <p><?= $contenido ?></p>
                        <div class="academia_enlaces">
                            <a href="<?= $enlace ?>" target="_blank">Web</a>
                            <?php if (!empty($instagram)): ?>
                                <a href="<?= $instagram ?>" target="_blank" class="icono instagram">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="academia_imagen">
                        <img src="<?= $foto_url ?>" alt="Imagen">
                    </div>
                </div>
            <?php else: ?>
                <p>No hay academias disponibles.</p>
            <?php endif; ?>
        </div>
    </div>
</section>
