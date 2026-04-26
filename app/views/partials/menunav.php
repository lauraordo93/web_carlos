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
                    // En el MVC, los enlaces internos pueden seguir siendo anclas a la home
                    echo '<li><a href="index.php#' . htmlspecialchars($id) . '">' . htmlspecialchars($nombre) . '</a></li>';
                endif;
            endforeach;
        else:
            echo '<li>No se encontró ningún elemento de menú.</li>';
        endif;
        ?>
        <li class="admin-icon">
            <a href="admin/iniciar_sesion.php" title="Administración">🎷</a>
        </li>
    </ul>

    <button class="nav-toggle" aria-label="Abrir menú">
        <span></span>
        <span></span>
        <span></span>
    </button>
</div>
