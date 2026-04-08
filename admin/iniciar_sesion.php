<?php
session_start();
include_once(__DIR__ . '/../config/db.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usuario = trim($_POST['usuario'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($usuario === '' || $password === '') {
    $error = "Rellena usuario y contraseña";
  } else {
    $sql = "SELECT id, password_hash FROM admin_usuario WHERE usuario = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
      $error = "Error en la consulta: " . $conn->error;
    } else {
      $stmt->bind_param("s", $usuario);
      $stmt->execute();
      $res = $stmt->get_result();
      $admin = $res->fetch_assoc();
      $stmt->close();

      if ($admin && password_verify($password, $admin['password_hash'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: listar_entradas.php?sec=5");
        exit;
      } else {
        $error = "Usuario o contraseña incorrectos";
      }
    }
  }
}

$titulo = "Iniciar sesión";
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($titulo); ?> - Admin</title>

  <link rel="stylesheet" href="../css/admin.css?v=1">
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
        <a href="../index.php" title="Volver a la web"><i class="fa-solid fa-house"></i></a>
      </div>
    </div>


  </header>

  <main class="admin-main">

    <form method="post" class="admin-form">
      <h1 class="admin-title"><?php echo htmlspecialchars($titulo); ?></h1>

      <label>Usuario</label>
      <input type="text" name="usuario" required>

      <label>Contraseña</label>
      <input type="password" name="password" required>

      <button type="submit" class="admin-btn">Entrar</button>

      <?php if ($error): ?>
        <p class="error"><?php echo htmlspecialchars($error); ?></p>
      <?php endif; ?>
    </form>

  </main>

  <footer class="admin-footer">
    <p class="copyright-line">
      &copy; 2026 Todos los derechos reservados
      <a href="https://lauraordo93.github.io/Portfolio/" target="_blank" rel="noopener">lauraordonez.dev</a>
    </p>
  </footer>

</body>

</html>