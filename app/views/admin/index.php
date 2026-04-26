<?php
// Título específico de la sección
$secciones = [
    5 => 'Vídeos',
    2 => 'Galería',
    6 => 'Entrevistas'
];
$titulo_seccion = $secciones[$id_sec] ?? 'Contenido';

// Empezar a capturar para el layout de admin
ob_start();
?>

<h1>Listado de <?= $titulo_seccion ?> <span style="font-size: 14px; color: var(--admin-muted); font-weight: 400;">(Total: <?= $total_registros ?? 0 ?>)</span></h1>

<table class="admin-table">
    <thead>
        <tr>
            <th>Recurso / Título</th>
            <th>Fecha</th>
            <th style="text-align: center;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($entradas)): ?>
            <tr>
                <td colspan="3" style="text-align: center; padding: 40px;">
                    <i class="fas fa-folder-open" style="font-size: 30px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                    No hay registros en esta sección.
                </td>
            </tr>
        <?php else: ?>
            <?php foreach ($entradas as $entrada): ?>
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <?php if ($id_sec == 2 && !empty($entrada['foto_url'])): ?>
                                <img src="<?= URLROOT ?>/public/<?= $entrada['foto_url'] ?>" loading="lazy" style="width: 40px; height: 40px; object-fit: cover; border-radius: 6px; border: 1px solid var(--admin-border);">
                            <?php endif; ?>
                            <span style="font-weight: 500;"><?= htmlspecialchars($entrada['titulo'] ?: $entrada['foto_url']) ?></span>
                        </div>
                    </td>
                    <td>
                        <div style="font-size: 13px; color: var(--admin-muted);">
                            <?= $entrada['fecha'] ?: 'S/D' ?>
                        </div>
                    </td>
                    <td class="admin-actions" style="text-align: center;">
                        <a href="<?= URLROOT ?>/admin/editar/<?= $entrada['id'] ?>" class="editar" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= URLROOT ?>/admin/borrar/<?= $entrada['id'] ?>" 
                           class="borrar" 
                           title="Borrar"
                           onclick="return confirm('¿Estás seguro de que quieres eliminar este registro?')">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<!-- Paginación -->
<?php if (isset($total_paginas) && $total_paginas > 1): ?>
    <div class="admin-pagination" style="margin-top: 20px; display: flex; justify-content: center; gap: 10px;">
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
            <a href="<?= URLROOT ?>/admin?sec=<?= $id_sec ?>&page=<?= $i ?>" 
               class="admin-btn-sec <?= ($i == $page) ? 'active' : '' ?>"
               style="padding: 8px 16px; min-width: 40px; text-align: center; border-radius: 8px; <?= ($i == $page) ? 'background: var(--yamaha-purple); color: white; border-color: var(--yamaha-purple);' : 'background: rgba(255,255,255,0.05);' ?>">
                <?= $i ?>
            </a>
        <?php endfor; ?>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/admin.php';
?>
