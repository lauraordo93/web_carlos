<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: iniciar_sesion.php");
    exit;
}

include_once(__DIR__ . '/../config/db.php');

$secciones_permitidas = [
    5 => 'Vídeos',
    2 => 'Galería',
    6 => 'Entrevistas'
];

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$id_sec = isset($_GET['sec']) ? (int)$_GET['sec'] : 5;

if (!array_key_exists($id_sec, $secciones_permitidas)) {
    $id_sec = 5;
}

$modo_edicion = false;
$error = '';

$entrada = [
    'titulo' => '',
    'contenido' => '',
    'foto_url' => '',
    'video_url' => '',
    'fecha' => '',
    'enlace_url' => '',
    'seccion_id' => $id_sec
];

if ($id > 0) {
    $sql = "SELECT id, titulo, contenido, foto_url, video_url, fecha, enlace_url, seccion_id
            FROM entradas
            WHERE id = ?
            LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $fila = $res->fetch_assoc();
    $stmt->close();

    if ($fila) {
        $entrada = $fila;
        $id_sec = (int)$fila['seccion_id'];
        $modo_edicion = true;
    } else {
        $error = "No se encontró el registro.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $id_sec = isset($_POST['seccion_id']) ? (int)$_POST['seccion_id'] : 5;

    if (!array_key_exists($id_sec, $secciones_permitidas)) {
        $id_sec = 5;
    }

    $titulo     = trim($_POST['titulo'] ?? '');
    $contenido  = trim($_POST['contenido'] ?? '');
    $video_url  = trim($_POST['video_url'] ?? '');
    $fecha      = trim($_POST['fecha'] ?? '');
    $enlace_url = trim($_POST['enlace_url'] ?? '');
    $foto_url_actual = trim($_POST['foto_url_actual'] ?? '');
    $foto_url = $foto_url_actual;

    if ($fecha === '') {
        $fecha = null;
    }

    // SUBIDA DE IMAGEN
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $permitidas = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
            $tipo = mime_content_type($_FILES['foto']['tmp_name']);

            if (!in_array($tipo, $permitidas, true)) {
                $error = "Solo se permiten imágenes JPG, PNG, WEBP o GIF.";
            } else {
                $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                $nombre_unico = uniqid('img_', true) . '.' . strtolower($extension);

                $ruta_destino_fisica = __DIR__ . '/../img/' . $nombre_unico;
                $ruta_bd = 'img/' . $nombre_unico;

                if (move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino_fisica)) {
                    $foto_url = $ruta_bd;
                } else {
                    $error = "No se pudo subir la imagen.";
                }
            }
        } else {
            $error = "Error al subir la imagen.";
        }
    }

    // VALIDACIONES POR SECCIÓN
    if ($error === '') {
        if ($id_sec === 5) {
            if ($titulo === '' || $contenido === '' || $video_url === '') {
                $error = "En vídeos debes completar título, descripción y URL del vídeo.";
            }

            $foto_url = null;
            $enlace_url = null;
        }

        if ($id_sec === 2) {
            if ($foto_url === '') {
                $error = "En galería debes subir una imagen.";
            }

            $titulo = '';
            $contenido = null;
            $video_url = null;
            $fecha = null;
            $enlace_url = null;
        }

        if ($id_sec === 6) {
            if ($titulo === '' || $contenido === '' || $foto_url === '' || $enlace_url === '') {
                $error = "En entrevistas debes completar título, descripción, imagen y enlace.";
            } elseif (!filter_var($enlace_url, FILTER_VALIDATE_URL)) {
                $error = "El enlace no es válido.";
            }

            $video_url = null;
            $fecha = null;
        }
    }

    if ($error === '') {
        if ($id > 0) {
            $sql = "UPDATE entradas
                    SET titulo = ?, contenido = ?, foto_url = ?, video_url = ?, fecha = ?, seccion_id = ?, enlace_url = ?
                    WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "sssssisi",
                $titulo,
                $contenido,
                $foto_url,
                $video_url,
                $fecha,
                $id_sec,
                $enlace_url,
                $id
            );

            if ($stmt->execute()) {
                $stmt->close();
                header("Location: listar_entradas.php?sec=" . $id_sec);
                exit;
            } else {
                $error = "Error al actualizar el registro.";
            }
        } else {
            $sql = "INSERT INTO entradas (titulo, contenido, foto_url, video_url, fecha, seccion_id, enlace_url)
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param(
                "sssssis",
                $titulo,
                $contenido,
                $foto_url,
                $video_url,
                $fecha,
                $id_sec,
                $enlace_url
            );

            if ($stmt->execute()) {
                $stmt->close();
                header("Location: listar_entradas.php?sec=" . $id_sec);
                exit;
            } else {
                $error = "Error al guardar el registro.";
            }
        }
    }

    $entrada = [
        'titulo' => $titulo,
        'contenido' => $contenido,
        'foto_url' => $foto_url ?? '',
        'video_url' => $video_url ?? '',
        'fecha' => $fecha ?? '',
        'enlace_url' => $enlace_url ?? '',
        'seccion_id' => $id_sec
    ];
}

$titulo_formulario = $modo_edicion ? 'Editar registro' : 'Nuevo registro';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($titulo_formulario); ?></title>
    <link rel="stylesheet" href="../css/formulario.css">

</head>

<body class="admin-body">

    <div class="form-box">
        <h1><?php echo htmlspecialchars($titulo_formulario); ?></h1>

        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="foto_url_actual" value="<?php echo htmlspecialchars($entrada['foto_url']); ?>">

            <div class="form-row">
                <label for="seccion_id">Tipo de contenido</label>
                <select name="seccion_id" id="seccion_id" required>
                    <option value="5" <?php echo ((int)$entrada['seccion_id'] === 5) ? 'selected' : ''; ?>>Vídeo</option>
                    <option value="2" <?php echo ((int)$entrada['seccion_id'] === 2) ? 'selected' : ''; ?>>Galería</option>
                    <option value="6" <?php echo ((int)$entrada['seccion_id'] === 6) ? 'selected' : ''; ?>>Entrevista</option>
                </select>
            </div>

            <div class="form-row campo campo-titulo">
                <label for="titulo">Título</label>
                <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($entrada['titulo']); ?>">
            </div>

            <div class="form-row campo campo-contenido">
                <label for="contenido">Descripción</label>
                <textarea name="contenido" id="contenido"><?php echo htmlspecialchars($entrada['contenido']); ?></textarea>
            </div>

            <div class="form-row campo campo-video">
                <label for="video_url">URL del vídeo</label>
                <input type="text" name="video_url" id="video_url" value="<?php echo htmlspecialchars($entrada['video_url']); ?>">
            </div>

            <div class="form-row campo campo-fecha">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" value="<?php echo htmlspecialchars($entrada['fecha']); ?>">
            </div>

            <div class="form-row campo campo-imagen">
                <label for="foto">Imagen</label>
                <input type="file" name="foto" id="foto" accept="image/*">

                <?php if (!empty($entrada['foto_url'])): ?>
                    <img src="../<?php echo htmlspecialchars(trim($entrada['foto_url'])); ?>" alt="Vista previa" class="preview-img">
                <?php endif; ?>
            </div>

            <div class="form-row campo campo-enlace">
                <label for="enlace_url">Enlace externo</label>
                <input type="url" name="enlace_url" id="enlace_url"
                    placeholder="https://..."
                    value="<?php echo htmlspecialchars($entrada['enlace_url']); ?>">
            </div>

            <div class="acciones">
                <button type="submit" class="btn btn-guardar">Guardar</button>
                <a href="listar_entradas.php?sec=<?php echo (int)$entrada['seccion_id']; ?>" class="btn btn-volver">Cancelar</a>
            </div>
        </form>
    </div>


    <script src="../js/formEntradas.js"></script>
</body>

</html>