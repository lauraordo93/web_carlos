<section id="entrevistas">
    <?php if (!empty($entrevistas)): ?>
        <h2>Entrevistas</h2>
        <div class="contenedor-entrevistas">
            <?php foreach ($entrevistas as $row): ?>
                <article class="entrevista">
                    <div class="contenido">
                        <h3><?= htmlspecialchars($row["titulo"]) ?></h3>
                        <p><?= nl2br(htmlspecialchars($row["contenido"])) ?></p>
                        <?php if (!empty($row["enlace_url"])): ?>
                            <a href="<?= htmlspecialchars($row["enlace_url"]) ?>" target="_blank" class="btn-entrevista">Ver en YouTube</a>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($row["foto_url"])): ?>
                        <img src="<?= htmlspecialchars($row["foto_url"]) ?>" alt="Logo" class="logo-entrevista">
                    <?php endif; ?>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
