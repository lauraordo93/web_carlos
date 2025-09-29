<?php
// Importar clases de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Incluir archivos de PHPMailer moderno
require __DIR__ . '/../phpmailer/src/Exception.php';
require __DIR__ . '/../phpmailer/src/PHPMailer.php';
require __DIR__ . '/../phpmailer/src/SMTP.php';

// Inicializar variables
$nombre = '';
$email = '';
$mensaje = '';
$success_msg = '';
$error_msg = '';

// Leer configuración desde .env
$config = parse_ini_file(__DIR__ . '/../.env');
if (!$config) exit("❌ No se pudo leer el archivo .env");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contacto_submit'])) {
    $nombre  = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $email   = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $mensaje = isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : '';

    $mail = new PHPMailer(true);

    try {
        // Configuración SMTP
        $mail->isSMTP();
        $mail->Host       = $config['SMTP_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $config['SMTP_USER'];
        $mail->Password   = $config['SMTP_PASS'];
        $mail->SMTPSecure = 'tls'; // o PHPMailer::ENCRYPTION_STARTTLS si tu versión lo soporta
        $mail->Port       = $config['SMTP_PORT'];

        // Remitente y destinatario
        $mail->setFrom($config['SMTP_USER'], 'Web Contacto');
        $mail->addAddress('lauraordo93@hotmail.com'); // destinatario final
        $mail->addReplyTo($email, $nombre);

        // Contenido del correo
        $mail->isHTML(false);
        $mail->Subject = 'Nuevo mensaje desde la web';
        $mail->Body    = "Has recibido un nuevo mensaje:\n\nNombre: $nombre\nEmail: $email\n\nMensaje:\n$mensaje";

        // Enviar
        $mail->send();
        $success_msg = "✅ Mensaje enviado correctamente";
        $nombre = $email = $mensaje = ''; // limpiar campos
    } catch (Exception $e) {
        $error_msg = "❌ Hubo un error al enviar el correo: " . $e->getMessage();
    }
}
?>




<div id="contacto" class="footer-right">
    <h3>Contacto</h3>

    <?php if (!empty($success_msg))
        echo "<p class='success'>$success_msg</p>"; ?>
    <?php if (!empty($error_msg))
        echo "<p class='error'>$error_msg</p>"; ?>

    <form action="" method="post">
        <input type="text" name="nombre" placeholder="Nombre" required value="<?php echo $nombre; ?>">
        <input type="email" name="email" placeholder="Email" required value="<?php echo $email; ?>">
        <textarea name="mensaje" rows="3" placeholder="Mensaje" required><?php echo $mensaje; ?></textarea>
        <button type="submit" name="contacto_submit">Enviar</button>
    </form>
</div>