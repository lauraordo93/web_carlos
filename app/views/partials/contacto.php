<?php
$success_msg = $success_msg ?? '';
$error_msg = $error_msg ?? '';
$contacto_nombre = $contacto_nombre ?? '';
$contacto_email = $contacto_email ?? '';
$contacto_mensaje = $contacto_mensaje ?? '';
?>
<div id="contacto" class="footer-right">
    <h3>Contacto</h3>

    <?php if (isset($success_msg) && !empty($success_msg)): ?>
        <p class='success'><?= $success_msg ?></p>
    <?php endif; ?>
    <?php if (isset($error_msg) && !empty($error_msg)): ?>
        <p class='error'><?= $error_msg ?></p>
    <?php endif; ?>

    <form action="" method="post">
        <label for="contacto_nombre" class="sr-only">Nombre</label>
        <input type="text" name="nombre" id="contacto_nombre" placeholder="Nombre" autocomplete="name" required value="<?= $contacto_nombre ?? '' ?>">
        
        <label for="contacto_email" class="sr-only">Email</label>
        <input type="email" name="email" id="contacto_email" placeholder="Email" autocomplete="email" required value="<?= $contacto_email ?? '' ?>">
        
        <label for="contacto_mensaje" class="sr-only">Mensaje</label>
        <textarea name="mensaje" id="contacto_mensaje" rows="3" placeholder="Mensaje" required><?= $contacto_mensaje ?? '' ?></textarea>
        
        <button type="submit" name="contacto_submit">Enviar</button>
    </form>
</div>