<?php
// Inicializar variables
$nombre = '';
$email = '';
$mensaje = '';
$success_msg = '';
$error_msg = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contacto_submit'])) {
    $nombre = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $mensaje = isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : '';

    // --- Enviar correo a tu hermano ---
    $to = "carloso96@hotmail.com"; // 🔹 CAMBIA esto por su email real
    $subject = "Nuevo mensaje desde la web";
    $body = "Has recibido un nuevo mensaje:\n\n"
          . "Nombre: $nombre\n"
          . "Email: $email\n\n"
          . "Mensaje:\n$mensaje\n";
    $headers = "From: no-reply@tuweb.com\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($to, $subject, $body, $headers)) {
        $success_msg = "✅ Mensaje enviado correctamente";
        $nombre = $email = $mensaje = ''; // limpiar campos
    } else {
        $error_msg = "❌ Hubo un error al enviar el correo.";
    }
}
?>
<div id="contacto" class="footer-right">
    <h3>Contacto</h3>

    <?php if(!empty($success_msg)) echo "<p class='success'>$success_msg</p>"; ?>
    <?php if(!empty($error_msg)) echo "<p class='error'>$error_msg</p>"; ?>

    <form action="" method="post">
        <input type="text" name="nombre" placeholder="Nombre" required value="<?php echo $nombre; ?>">
        <input type="email" name="email" placeholder="Email" required value="<?php echo $email; ?>">
        <textarea name="mensaje" rows="3" placeholder="Mensaje" required><?php echo $mensaje; ?></textarea>
        <button type="submit" name="contacto_submit">Enviar</button>
    </form>
</div>
