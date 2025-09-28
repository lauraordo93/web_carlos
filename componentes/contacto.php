<?php
include_once(__DIR__ . '/../config/db.php'); // Ajusta ruta

// Inicializar variables
$nombre = '';
$email = '';
$mensaje = '';
$success_msg = '';
$error_msg = '';

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contacto_submit'])) {
    $nombre = isset($_POST['nombre']) ? $conn->real_escape_string($_POST['nombre']) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
    $mensaje = isset($_POST['mensaje']) ? $conn->real_escape_string($_POST['mensaje']) : '';
    $seccion_id = 6;

    $sql = "INSERT INTO contacto (nombre, email, mensaje, seccion_id) 
            VALUES ('$nombre', '$email', '$mensaje', '$seccion_id')";

    if ($conn->query($sql) === TRUE) {
        $success_msg = "✅ Mensaje enviado correctamente";
        $nombre = $email = $mensaje = '';
    } else {
        $error_msg = "❌ Error al enviar el mensaje: " . $conn->error;
    }
}
?>
<div id="contacto" class="footer-right">
    <h3>Contacto</h3>

    <?php if(!empty($success_msg)) echo "<p class='success'>$success_msg</p>"; ?>
    <?php if(!empty($error_msg)) echo "<p class='error'>$error_msg</p>"; ?>

    <form action="" method="post">
        <input type="text" name="nombre" placeholder="Nombre" required value="<?php echo htmlspecialchars($nombre); ?>">
        <input type="email" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($email); ?>">
        <textarea name="mensaje" rows="3" placeholder="Mensaje" required><?php echo htmlspecialchars($mensaje); ?></textarea>
        <button type="submit" name="contacto_submit">Enviar</button>
    </form>
</div>
