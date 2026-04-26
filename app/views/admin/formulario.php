<?php
ob_start();
$entrada = $data['entrada'];
?>

<div class="content-header">
    <h1><?= $data['titulo'] ?></h1>
    <a href="<?= URLROOT ?>/admin?sec=<?= $data['id_sec'] ?>" class="admin-btn-sec">
        <i class="fas fa-arrow-left"></i> Volver al listado
    </a>
</div>

<?php if (!empty($data['error'])): ?>
    <div class="error"><?= $data['error'] ?></div>
<?php endif; ?>

<form action="" method="POST" enctype="multipart/form-data" class="admin-form" style="max-width: 800px;">
    <input type="hidden" name="seccion_id" value="<?= $data['id_sec'] ?>">
    <input type="hidden" name="foto_url_actual" value="<?= $entrada->foto_url ?>">

    <div class="form-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        
        <!-- Título -->
        <div class="form-group" style="grid-column: span 2;">
            <label for="titulo">Título del registro</label>
            <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($entrada->titulo) ?>" placeholder="Título descriptivo">
        </div>

        <!-- Contenido / Descripción -->
        <div class="form-group" style="grid-column: span 2;">
            <label for="contenido">Descripción / Texto</label>
            <textarea name="contenido" id="contenido" placeholder="Escribe aquí el contenido..."><?= htmlspecialchars($entrada->contenido) ?></textarea>
        </div>

        <!-- URL Vídeo (Solo si es sección 5) -->
        <?php if ($data['id_sec'] == 5): ?>
        <div class="form-group" style="grid-column: span 2;">
            <label for="video_url">URL de YouTube</label>
            <input type="text" name="video_url" id="video_url" value="<?= htmlspecialchars($entrada->video_url) ?>" placeholder="https://www.youtube.com/watch?v=...">
        </div>
        <?php endif; ?>

        <!-- Enlace Externo (Solo si es sección 6) -->
        <?php if ($data['id_sec'] == 6): ?>
        <div class="form-group" style="grid-column: span 2;">
            <label for="enlace_url">Enlace externo (URL)</label>
            <input type="text" name="enlace_url" id="enlace_url" value="<?= htmlspecialchars($entrada->enlace_url) ?>" placeholder="https://...">
        </div>
        <?php endif; ?>

        <!-- Imagen -->
        <div class="form-group">
            <label for="foto">Imagen (Sube una nueva si deseas cambiarla)</label>
            <input type="file" name="foto" id="foto" accept="image/*">
            <?php if (!empty($entrada->foto_url)): ?>
                <div style="margin-top: 10px;">
                    <span style="font-size: 12px; color: var(--admin-muted);">Actual:</span><br>
                    <img src="<?= URLROOT ?>/public/<?= $entrada->foto_url ?>" style="width: 100px; border-radius: 8px; margin-top: 5px;">
                </div>
            <?php endif; ?>
        </div>

        <!-- Fecha -->
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" id="fecha" value="<?= $entrada->fecha ?>">
        </div>

    </div>

    <button type="submit" class="admin-btn" style="margin-top: 30px;">
        <i class="fas fa-save"></i> <?= $data['modo_edicion'] ? 'GUARDAR CAMBIOS' : 'CREAR REGISTRO' ?>
    </button>
</form>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>
