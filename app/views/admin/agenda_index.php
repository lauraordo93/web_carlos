<?php
$eventos = $eventos ?? [];

$formatearFecha = static function ($fecha) {
    if (empty($fecha)) {
        return 'S/D';
    }

    $timestamp = strtotime($fecha);
    return $timestamp ? date('d/m/Y', $timestamp) : 'S/D';
};

$hoy = date('Y-m-d');

ob_start();
?>

<h1 class="admin-title">Agenda</h1>

<table class="admin-table">
    <thead>
        <tr>
            <th>Evento</th>
            <th>Fecha</th>
            <th>Lugar</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($eventos)): ?>
            <tr>
                <td colspan="5" style="text-align: center; padding: 40px;">
                    <i class="fas fa-calendar-xmark" style="font-size: 30px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                    No hay eventos en la agenda.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($eventos as $evento): ?>
                <?php $es_proximo = !empty($evento['fecha']) && $evento['fecha'] >= $hoy; ?>
                <?php $estado = empty($evento['fecha']) ? 'Sin fecha' : ($es_proximo ? 'Próximo' : 'Anterior'); ?>
                <tr>
                    <td data-label="Evento">
                        <strong><?= htmlspecialchars($evento['titulo'] !== '' ? $evento['titulo'] : 'Sin título', ENT_QUOTES, 'UTF-8') ?></strong>
                        <?php if (!empty($evento['descripcion'])): ?>
                            <span class="admin-table-muted">
                                <?= nl2br(htmlspecialchars($evento['descripcion'], ENT_QUOTES, 'UTF-8')) ?>
                            </span>
                        <?php endif; ?>
                    </td>
                    <td data-label="Fecha">
                        <?= htmlspecialchars($formatearFecha($evento['fecha']), ENT_QUOTES, 'UTF-8') ?>
                    </td>
                    <td data-label="Lugar">
                        <?= !empty($evento['lugar']) ? htmlspecialchars($evento['lugar'], ENT_QUOTES, 'UTF-8') : 'S/D' ?>
                    </td>
                    <td data-label="Estado">
                        <span class="agenda-status <?= $es_proximo ? 'agenda-status-proximo' : 'agenda-status-pasado' ?>">
                            <?= htmlspecialchars($estado, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </td>
                    <td data-label="Acciones" class="admin-actions">
                        <a href="<?= URLROOT ?>/admin/agendaEditar/<?= (int) $evento['id'] ?>" class="editar" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="<?= URLROOT ?>/admin/agendaBorrar/<?= (int) $evento['id'] ?>" method="POST" style="display:inline;" onsubmit="return confirm('¿Confirma la eliminación definitiva de este evento?')">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="borrar" style="border:none; background:none; cursor:pointer;" title="Borrar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>
