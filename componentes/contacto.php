<?php
// Inicializar variables
$nombre = '';
$email = '';
$mensaje = '';
$success_msg = '';
$error_msg = '';

include_once(__DIR__ . '/../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contacto_submit'])) {
    $nombre  = isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : '';
    $email   = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $mensaje = isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : '';

    // 1️⃣ Guardar en la base de datos
    $sql = "INSERT INTO contacto (nombre, email, mensaje) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $email, $mensaje);
    $stmt->execute();
    $stmt->close();

    // 2️⃣ Enviar a Formspree
    $formspree_url = "https://formspree.io/f/meorgrrz"; //  URL correo c de Formspree
    $data = [
        'name' => $nombre,
        'email' => $email,
        'message' => $mensaje
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($formspree_url, false, $context);

    if ($result !== false) {
        $success_msg = "✅ Mensaje enviado correctamente";
        $nombre = $email = $mensaje = ''; // limpiar campos
    } else {
        $error_msg = "❌ Hubo un error al enviar el mensaje";
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
