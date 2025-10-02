<?php
// 1. Lógica para determinar qué documento mostrar (aviso, privacidad o cookies)
$documento = $_GET['doc'] ?? 'aviso_legal'; 

switch ($documento) {
    case 'privacidad':
        $titulo = 'Política de Privacidad';
        // RUTA CORREGIDA: Asumiendo que tus archivos de texto están en la carpeta 'legales'
        $ruta_texto = 'legales/politica_privacidad_texto.php';
        break;
    case 'cookies':
        $titulo = 'Política de Cookies';
        $ruta_texto = 'legales/politica_cookies_texto.php';
        break;
    case 'aviso_legal':
    default:
        $titulo = 'Aviso Legal';
        $ruta_texto = 'legales/aviso_legal_texto.php';
        break;
}

// 2. Inicio del Bloque HTML y HEAD (Copiado de tu index.php)
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?> - Página web Carlos</title>
    <link rel="stylesheet" href="css/pagweb.css?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    </head>

<body>
    
    <header id="inicio" style="min-height: 150px;">
        <nav class="nav-container">
            <?php include('componentes/menunav.php'); ?>
        </nav>
       <div class="contenedor-del-logo">
  <img src="img/pentagrama4.jpg" alt="Logo central" class="imagen-logo">
</div>
    </header>
 
<main>
    <section id="texto-legal-content" style="padding-top: 100px; padding-bottom: 50px;">
        <div class="container" style="max-width: 900px; margin: auto; padding: 0 20px; text-align: left;">
            
            <h1 style="color: var(--color_yamaha); margin-bottom: 30px; text-align: center;">
                <?php echo $titulo; ?>
            </h1>
            
            <div class="texto-legal">
                <?php 
                // Esto abre el archivo de texto y PEGA su contenido aquí
                include $ruta_texto; 
                ?>
            </div>
        </div>
    </section>
</main>
<footer class="footerprincipal">


   <div class="footer-bottom">
    <p class="copyright-line">
        &copy; 2025 Todos los derechos reservados Lauraordonez.dev
    </p>
    <div class="enlaces-legales-container">
        <a href="legales.php?doc=aviso_legal">Aviso Legal</a> | 
        <a href="legales.php?doc=privacidad">Política de Privacidad</a> | 
        <a href="legales.php?doc=cookies">Política de Cookies</a>
    </div>
</div>

</footer>


    <script src="js/gal_vieBTN.js"></script>
    <script src="js/sobremi.js"></script>
    <script src="js/galeria.js"></script>
    <script src="js/video.js"></script>
    <script src="js/menuHambur.js"></script>

</body>

</html>