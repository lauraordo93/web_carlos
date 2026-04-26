<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?> - Admin</title>
    <link rel="stylesheet" href="<?= URLROOT ?>/public/css/admin.css?v=2">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="admin-body" style="display: flex; align-items: center; justify-content: center; padding: 20px;">

    <form action="<?= URLROOT ?>/admin/login" method="POST" class="admin-form">
        <div style="text-align: center; margin-bottom: 25px;">
            <div class="admin-sax" style="margin: 0 auto 15px; width: 50px; height: 50px; font-size: 26px;">🔐</div>
            <h2 style="margin: 0;">Acceso Administrativo</h2>
            <p style="font-size: 13px; color: var(--admin-muted); margin-top: 5px;">Introduce tus credenciales para continuar</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="error">
                <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
            </div>
        <?php endif; ?>

        <div class="form-group">
            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" placeholder="Ej: admin" required autofocus>
        </div>

        <div class="form-group" style="margin-top: 15px;">
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" placeholder="••••••••" required>
        </div>

        <button type="submit" class="admin-btn">
            INICIAR SESIÓN <i class="fas fa-sign-in-alt" style="margin-left: 8px;"></i>
        </button>

        <div style="text-align: center; margin-top: 25px; padding-top: 15px; border-top: 1px solid var(--admin-border);">
            <a href="<?= URLROOT ?>" style="color: var(--yamaha-purple-2); text-decoration: none; font-size: 13px;">
                <i class="fas fa-arrow-left"></i> Volver a la web pública
            </a>
        </div>
    </form>

</body>
</html>
