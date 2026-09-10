<?php
$evento = $evento ?? (object) [
    'titulo' => '',
    'descripcion' => '',
    'fecha' => '',
    'lugar' => '',
    'seccion_id' => 3,
];
$modo_edicion = !empty($modo_edicion);
$titulo = $titulo ?? 'Evento';
$error = $error ?? '';

ob_start();
?>

<div class="form-box">
    <h1><?= htmlspecialchars($titulo, ENT_QUOTES, 'UTF-8') ?></h1>

    <?php if (!empty($error)): ?>
        <div class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form action="" method="POST">
        <input type="hidden" name="submit_token" value="<?= htmlspecialchars($submit_token ?? '', ENT_QUOTES, 'UTF-8') ?>">
        <div class="form-row">
            <label for="titulo">Título del evento</label>
            <input
                type="text"
                name="titulo"
                id="titulo"
                value="<?= htmlspecialchars($evento->titulo, ENT_QUOTES, 'UTF-8') ?>"
                placeholder="Ej. Concierto en Madrid"
                required>
        </div>

        <div class="form-row">
            <label for="fecha">Fecha</label>
            <input
                type="date"
                name="fecha"
                id="fecha"
                value="<?= htmlspecialchars((string) $evento->fecha, ENT_QUOTES, 'UTF-8') ?>"
                onclick="if (this.showPicker) this.showPicker()"
                onfocus="if (this.showPicker) this.showPicker()"
                required>
        </div>

        <div class="form-row">
            <label for="lugar">Lugar</label>
            <input
                type="text"
                name="lugar"
                id="lugar"
                value="<?= htmlspecialchars((string) $evento->lugar, ENT_QUOTES, 'UTF-8') ?>"
                placeholder="Auditorio, ciudad o sala">
        </div>

        <div class="form-row">
            <label for="descripcion">Descripción</label>
            <textarea
                name="descripcion"
                id="descripcion"
                placeholder="Información adicional del evento"><?= htmlspecialchars((string) $evento->descripcion, ENT_QUOTES, 'UTF-8') ?></textarea>
        </div>

        <div class="acciones">
            <button type="submit" class="btn btn-guardar">
                <i class="fas fa-save"></i> <?= $modo_edicion ? 'GUARDAR CAMBIOS' : 'CREAR EVENTO' ?>
            </button>
            <a href="<?= URLROOT ?>/admin/agenda" class="btn btn-volver">
                <i class="fas fa-times"></i> CANCELAR
            </a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>
