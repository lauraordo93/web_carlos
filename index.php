<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Página web Carlos</title>
    <link rel="stylesheet" href="css/pagweb.css?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>


<body>

    <header id="inicio">

        <nav class="nav-container">
            <?php include('componentes/menunav.php'); ?>
        </nav>

        <div class="logo">
            <?php include('componentes/logo.php'); ?>

        </div>


        <div class="intro">
            <?php include('componentes/sobremi.php'); ?>
        </div>


    </header>
    <div class="redes-sociales-movil">
        <?php include_once('componentes/redes.php'); ?>
    </div>

    <section id="biografia">
        <?php include('componentes/biografia.php'); ?>
    </section>
    <section id="madrid-sax-academy">
        <?php include('componentes/academia.php'); ?>
    </section>


    <section id="galeria">
        <h2>Galería</h2>
        <div class="tabs">

            <button class="tab-btn active" data-tab="imagenes">Imágenes</button>
            <button class="tab-btn" data-tab="videos">Vídeos</button>
        </div>

        <div class="galeria active" id="imagenes">
            <?php include('componentes/galeria.php'); ?>
        </div>

        <div class="galeria" id="videos">
            <?php include('componentes/videos.php'); ?>
        </div>
    </section>

    <section id="entrevistas">
        <?php include('componentes/entrevistas.php'); ?>
    </section>

    <section id="agenda">
        <div class="mensaje-agenda">
            <?php include_once('componentes/agenda.php'); ?>
            <label for="agenda-progress"><strong>En desarrollo...</strong></label>
            <progress id="agenda-progress" class="agenda" value="30" max="100"></progress>
        </div>
    </section>

    <footer class="footerprincipal">
        <div class="footer-container">
            <div class="footer-left">
                <img src="img/imagen_derecha.jpg" alt="Logo" class="footer-logo">
            </div>

            <?php include('componentes/contacto.php'); ?>
        </div>

        <div class="footer-bottom">
            <p class="copyright-line">
                &copy; 2026 Todos los derechos reservados Lauraordonez.dev
            </p>
            <div class="enlaces-legales-container">
                <a href="legales.php?doc=aviso_legal">Aviso Legal</a> |
                <a href="legales.php?doc=privacidad">Política de Privacidad</a> |
                <a href="legales.php?doc=cookies">Política de Cookies</a>
            </div>
        </div>
    </footer>
    <!-- Banner de cookies -->
<!-- Ventana de cookies -->
<div id="overlay-cookies" class="overlay-cookies">
  <div class="modal-cookies">
      <h3>Configuración de cookies 🎷</h3>
    <p>
      Usamos cookies propias y de terceros para analizar el uso del sitio y mejorar tu experiencia.
      Puedes aceptar todas las cookies o rechazarlas.
      <a href="legales.php?doc=cookies" target="_blank">Más información</a>
    </p>
    <div class="cookies-botones">
      <button id="btn-aceptar-cookies">Aceptar todas</button>
      <button id="btn-rechazar-cookies" class="btn-secundario">Rechazar</button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
  Fancybox.bind("[data-fancybox='gallery']", {
    // Opciones personalizadas 
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/banner_cookies.js"></script>
    <script src="js/gal_vieBTN.js"></script>
    <script src="js/sobremi.js"></script>
    <script src="js/galeria.js"></script>
    <script src="js/video.js"></script>
    <script src="js/menuHambur.js"></script>

</body>

</html>