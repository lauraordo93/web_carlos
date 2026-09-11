<?php
/**
 * Vista: Formulario de Gestión de Contenido (Admin)
 *
 * Interfaz unificada para la creación y edición de registros.
 * Gestiona dinámicamente los campos según la seccion de destino.
 */

$entrada = $entrada ?? (object) [
    'titulo' => '',
    'contenido' => '',
    'foto_url' => '',
    'video_url' => '',
    'fecha' => '',
    'enlace_url' => '',
];
$id_sec = isset($id_sec) ? (int) $id_sec : 5;
$modo_edicion = !empty($modo_edicion);
$titulo = $titulo ?? 'Formulario';
$error = $error ?? '';

ob_start();
?>

<div class="form-box">
    <h1><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="submit_token" value="<?= htmlspecialchars($submit_token ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="foto_url_actual" value="<?= htmlspecialchars($entrada->foto_url, ENT_QUOTES, 'UTF-8') ?>">

        <div class="form-row">
            <label for="seccion_id">Categoría del Contenido</label>
            <?php if (!$modo_edicion): ?>
                <select name="seccion_id" id="seccion_id" required>
                    <option value="5" <?= ($id_sec == 5) ? 'selected' : '' ?>>Vídeo</option>
                    <option value="2" <?= ($id_sec == 2) ? 'selected' : '' ?>>Imagen / Galería</option>
                    <option value="6" <?= ($id_sec == 6) ? 'selected' : '' ?>>Entrevista</option>
                </select>
            <?php else: ?>
                <input type="text" value="<?= ($id_sec == 2 ? 'Galería' : ($id_sec == 5 ? 'Vídeo' : 'Entrevista')) ?>" disabled>
                <input type="hidden" name="seccion_id" id="seccion_id" value="<?= $id_sec ?>">
            <?php endif; ?>
        </div>

        <div class="form-row campo campo-titulo">
            <label for="titulo">Título descriptivo</label>
            <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($entrada->titulo, ENT_QUOTES, 'UTF-8') ?>" placeholder="Introduzca el título">
        </div>

        <div class="form-row campo campo-contenido">
            <label for="contenido">Descripción / Cuerpo</label>
            <textarea name="contenido" id="contenido" placeholder="Describa el contenido aquí..."><?= htmlspecialchars($entrada->contenido, ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <div class="form-row campo campo-video">
            <label for="video_url">Identificador o URL de Vídeo</label>
            <input type="text" name="video_url" id="video_url" value="<?= htmlspecialchars($entrada->video_url, ENT_QUOTES, 'UTF-8') ?>" placeholder="https://www.youtube.com/watch?v=...">
        </div>

        <div class="form-row campo campo-enlace">
            <label for="enlace_url">Referencia / Enlace Externo</label>
            <input type="text" name="enlace_url" id="enlace_url" value="<?= htmlspecialchars($entrada->enlace_url, ENT_QUOTES, 'UTF-8') ?>" placeholder="https://...">
        </div>

        <div class="form-row campo campo-imagen">
            <label for="foto">Activo Multimedia (Imagen)</label>
            <input type="file" name="foto" id="foto" accept="image/*">
            <?php if (!empty($entrada->foto_url)): ?>
                <img src="<?= asset_url($entrada->foto_url) ?>" class="preview-img" alt="Vista previa del activo">
            <?php endif; ?>
        </div>

        <div class="form-row campo campo-fecha">
            <label for="fecha">Fecha de publicación</label>
            <input type="date" name="fecha" id="fecha" value="<?= htmlspecialchars((string) $entrada->fecha, ENT_QUOTES, 'UTF-8') ?>" onclick="this.showPicker()">
        </div>

        <div class="acciones">
            <button type="submit" class="btn btn-guardar">
                <i class="fas fa-save"></i> <?= $modo_edicion ? 'GUARDAR CAMBIOS' : 'CREAR REGISTRO' ?>
            </button>
            <a href="<?= URLROOT ?>/admin?sec=<?= $id_sec ?>" class="btn btn-volver">
                <i class="fas fa-times"></i> CANCELAR
            </a>
        </div>
    </form>
</div>

<script src="<?= asset_url('js/form_entradas.js') ?>"></script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>