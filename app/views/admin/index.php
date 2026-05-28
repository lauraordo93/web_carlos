<?php
$entradas = $entradas ?? [];
$id_sec = isset($id_sec) ? (int) $id_sec : 5;
$page = isset($page) ? (int) $page : 1;
$total_paginas = isset($total_paginas) ? (int) $total_paginas : 0;
/**
 * Vista: Listado de Entradas (Admin)
 * 
 * Muestra una tabla con los registros de la sección seleccionada,
 * con acciones de edición, borrado y sistema de paginación.
 */

// Mapeo de identificadores de sección para visualización de títulos
$secciones = [
    5 => 'Vídeos',
    2 => 'Galería',
    6 => 'Entrevistas'
];
$titulo_seccion = $secciones[$id_sec] ?? 'Contenido';

// Captura de contenido para su integración en el layout administrativo
ob_start();
?>

<h1 class="admin-title">Listado de <?= $titulo_seccion ?></h1>

<table class="admin-table">
    <thead>
        <tr>
            <th>Recurso / Título</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($entradas)): ?>
            <tr>
                <td colspan="3" style="text-align: center; padding: 40px;">
                    <i class="fas fa-folder-open" style="font-size: 30px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                    No se han encontrado registros en esta categoría.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($entradas as $entrada): ?>
                <tr>
                    <td data-label="Recurso / Título">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <?php if ($id_sec == 2 && !empty($entrada['foto_url'])): ?>
                                <img src="<?= asset_url($entrada['foto_url']) ?>" loading="lazy" class="img-thumb">
                            <?php endif; ?>
                            <span><?= htmlspecialchars($entrada['titulo'] ?: $entrada['foto_url']) ?></span>
                        </div>
                    </td>
                    <td data-label="Fecha">
                        <?= $entrada['fecha'] ?: 'S/D' ?>
                    </td>
                    <td data-label="Acciones" class="admin-actions">
                        <a href="<?= URLROOT ?>/admin/editar/<?= $entrada['id'] ?>" class="editar" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= URLROOT ?>/admin/borrar/<?= $entrada['id'] ?>" 
                           class="borrar" 
                           title="Borrar"
                           onclick="return confirm('¿Confirma la eliminación definitiva de este registro?')">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<?php if (isset($total_paginas) && $total_paginas > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="<?= URLROOT ?>/admin?sec=<?= $id_sec ?>&page=<?= $i ?>" 
               class="page-link <?= ($i == $page) ? 'active' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>
