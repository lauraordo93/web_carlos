<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Página web Carlos</title>
    <link rel="stylesheet" href="css/pagweb.css?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
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
   
    <div id="galeria" class="tabs">
        <button class="tab-btn active" data-tab="imagenes">Imágenes</button>
        <button class="tab-btn" data-tab="videos">Vídeos</button>
    </div>

    <div class="galeria active" id="imagenes">
        <?php include('componentes/galeria.php'); ?>
    </div>

    <div class="galeria" id="videos">
        <?php include('componentes/videos.php'); ?>
    </div>

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



    <footer>

        <div class="pie">
            <p>
<<<<<<< HEAD
                &copy; 2025 Todos los derechos reservados Lauraordonez.dev
              
=======
                &copy; 2025 Todos los derechos reservados lauraordonez.dev
             
>>>>>>> pruebasvarias
            </p>
            <a class="init" href="#inicio">Volver al inicio</a>
        </div>
    </footer>


<<<<<<< HEAD
=======
    <!--Animación java script-->
 
>>>>>>> pruebasvarias
    <script src="js/sobremi.js"></script>
     <script src="js/galeria.js"></script>
      <script src="js/video.js"></script>
    <script src="js/menuHambur.js"></script>
   
</body>

</html>