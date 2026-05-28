<?php
$menu = $menu ?? [];
?>
<div class="nav-container">
    <ul class="nav-menu">
        <?php
        $ids_personalizados = [
            'Biografía' => 'biografia',
            'Madrid Sax Academy' => 'madrid-sax-academy',
            'Galería' => 'galeria',
            'Entrevistas' => 'entrevistas',
            'Contacto' => 'contacto',
        ];

        if (!empty($menu)):
            foreach ($menu as $row):
                $nombre = $row['nombre'];
                if (isset($ids_personalizados[$nombre])):
                    $id = $ids_personalizados[$nombre];
                    $href = site_url('#' . $id);
                    echo '<li><a href="' . htmlspecialchars($href, ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') . '</a></li>';
                endif;
            endforeach;
        else:
            echo '<li>No se encontró ningún elemento de menú.</li>';
        endif;
        ?>
        <li class="admin-icon">
            <a href="<?= site_url('admin/login') ?>" title="Administración">🎷</a>
        </li>
    </ul>

    <button class="nav-toggle" aria-label="Abrir menú">
        <span></span>
        <span></span>
        <span></span>
    </button>
</div>