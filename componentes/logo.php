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

// Consulta para las redes sociales
$sql_redes = "SELECT nombre_red, enlace FROM redes";
$result_redes = $conn->query($sql_redes);
$redes = [];
if ($result_redes && $result_redes->num_rows > 0) {
    while ($fila = $result_redes->fetch_assoc()) {
        $redes[] = $fila;
    }
}
?>


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
        min-height: 100vh;
        /* altura inicial en pantallas grandes */
        display: flex;
        justify-content: center;
        /* align-items: center; */
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
            background-image: url('img/Carlos_cabecera33.jpg');
            /* versión más adecuada */
            min-height: 43vh;
            /* altura más proporcional */
            padding: 1.5rem;
            background-position: center center;
            background-size: cover;
        }
    }

    /* Tablets medianas */
    @media screen and (max-width: 768px) {
        header#inicio {
            min-height: 47vh;
            padding: 2rem;

            background-position: center center;
            /* centramos la imagen */
            background-attachment: scroll;
            /* quitar fixed en móvil */
        }
    }

    /* Móviles pequeños */
    @media screen and (max-width: 480px) {
        header#inicio {
            background-image: url('img/Carlos_cabeceramedia.jpg');
            /* versión más adecuada */
            min-height: 24vh;
            /* siempre altura máxima */
            padding: 1.2rem;
            background-position: right center;
            background-size: cover;
            -webkit-text-size-adjust: 100%;
        }
    }
</style>