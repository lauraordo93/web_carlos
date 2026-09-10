<?php
$titulo = $titulo ?? 'Iniciar Sesión';
$error = $error ?? '';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?> - Carlos Ordóñez de Arce</title>
    <meta name="robots" content="noindex, nofollow">

    <link rel="stylesheet" href="<?= asset_url('css/admin.css?v=' . time()) ?>">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body class="admin-body">

    <header class="admin-header">
        <div class="admin-topbar">
            <div class="admin-brand">
                <span class="admin-sax">🎷</span>
                <span class="admin-text">Administración</span>
            </div>

            <div class="admin-links">
                <a href="<?= URLROOT ?>" title="Volver a la web"><i class="fa-solid fa-house"></i></a>
            </div>
        </div>
    </header>


    <main class="admin-main">
        <form action="<?= URLROOT ?>/admin/login" method="POST" class="admin-form">
            <h1 class="admin-title"><?= $titulo ?></h1>

            <label for="usuario">Usuario</label>
            <input type="text" name="usuario" id="usuario" autocomplete="username" required autofocus>

            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" autocomplete="current-password" required>

            <button type="submit" class="admin-btn">ENTRAR</button>

            <?php if (!empty($error)): ?>
                <div class="error">
                    <i class="fas fa-exclamation-triangle"></i> <?= $error ?>
                </div>
            <?php endif; ?>
        </form>

    </main>

    <footer class="admin-footer">
        <p class="copyright-line">
            &copy; <?= date('Y') ?> Todos los derechos reservados
            <a href="https://lauraordo93.github.io/Portfolio/" target="_blank" rel="noopener">lauraordonez.dev</a>
        </p>
    </footer>

    <script src="<?= asset_url('js/admin_submit.js?v=' . time()) ?>"></script>
</body>

</html>

