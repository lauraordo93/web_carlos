<?php
// Incluir solo una vez el archivo de conexión a la base de datos
include_once(__DIR__ . '/../config/db.php');

// Consulta SQL para obtener texto y URL
$sql = "SELECT nombre_pagina, logo FROM encabezado_logo LIMIT 1";
$result = $conn->query($sql);

$logo_url = ''; // Inicializar

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $logo_url = htmlspecialchars($row["logo"]);
    // $logo_url = '/mi_pagweb/' . htmlspecialchars($row["logo"]);

    // Mostrar el título
    //  echo '<div class="text">';
    // echo '<h1 class="nombre_pag">' . htmlspecialchars($row["nombre_pagina"]) . '</h1>';
    // echo '</div>';
}
?>
<!-- background-image: url('<?php echo $logo_url; ?>');-->

<!-- Aquí ya se puede imprimir el estilo porque $logo_url está definido -->
<style>
    header#inicio {
        background-image: url('<?php echo $logo_url; ?>');
        background-size: cover;
        /* cubre toda el área del header */
        background-position: top center;
        /* fija la parte superior de la imagen */
        background-repeat: no-repeat;
        width: 100%;
        min-height: 105vh;
        /* altura inicial en pantallas grandes */
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    /* Laptops grandes y tablets grandes */
    @media screen and (max-width: 1440px) {
        header#inicio {
            background-image: url('img/Carlos_cabecera4.jpg');
            /* versión más adecuada */
            min-height: 100vh;
            padding: 2rem;
            background-size: cover;
            /* ocupa todo el contenedor */
            background-position: center top;
            /* centramos la parte importante */
            background-attachment: scroll;
            /* evita problemas de fixed */
        }
    }

    /* Laptops(No solucionado!) y tablets grandes (ipad si) */
    @media screen and (max-width: 1024px) {
        header#inicio {
            background-image: url('img/Carlos_cabecera4.jpg');
            /* versión más adecuada */
            min-height: 50vh;
            /* altura más proporcional */
            padding: 1.5rem;
        }
    }

    /* Tablets medianas */
    @media screen and (max-width: 768px) {
        header#inicio {
            min-height: 60vh;
            padding: 1rem;
            background-position: center center;
            /* centramos la imagen */
            background-attachment: scroll;
            /* quitar fixed en móvil */
        }
    }

    /* Móviles pequeños */
    @media screen and (max-width: 480px) {
        header#inicio {
            background-image: url('img/Carlos_cabecera4.jpg');
            /* versión más adecuada */
            min-height: 25vh;
            padding: 2.5rem;
            background-position: center center;
            background-size: cover;
        }
    }
</style>