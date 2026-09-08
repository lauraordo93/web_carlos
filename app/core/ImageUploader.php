<?php

/**
 * Servicio centralizado de subida y conversión de imágenes a WebP.
 *
 * Responsabilidades:
 *  - Validar el archivo recibido (tamaño, MIME real, integridad).
 *  - Convertir a WebP preservando transparencia cuando corresponda.
 *  - Redimensionar si la imagen excede las dimensiones configuradas.
 *  - Generar un nombre de archivo seguro y único.
 *  - Devolver la ruta relativa pública para almacenar en base de datos.
 *
 * Uso típico desde un controlador:
 *
 *     $result = ImageUploader::upload($_FILES['foto'], 'img');
 *     if ($result['ok']) {
 *         $foto_url = $result['path']; // 'img/img_xxxx.webp'
 *     } else {
 *         $error = $result['error'];   // Mensaje seguro para el usuario
 *     }
 */
class ImageUploader
{
    /**
     * Procesa la subida de una imagen y la convierte a WebP.
     *
     * @param  array  $file          Entrada de $_FILES (ej. $_FILES['foto'])
     * @param  string $destDir       Carpeta destino relativa a PUBLICROOT (ej. 'img')
     * @param  int    $quality       Calidad WebP (0-100). Por defecto usa WEBP_QUALITY.
     * @param  int    $maxWidth      Ancho máximo. Por defecto usa MAX_IMAGE_WIDTH.
     * @param  int    $maxHeight     Alto máximo. Por defecto usa MAX_IMAGE_HEIGHT.
     * @return array  ['ok' => bool, 'path' => string|null, 'error' => string|null]
     */
    public static function upload(
        array $file,
        string $destDir = 'img',
        int $quality = -1,
        int $maxWidth = -1,
        int $maxHeight = -1
    ): array {

        // --- Valores por defecto desde configuración ---
        if ($quality < 0)   $quality   = defined('WEBP_QUALITY')      ? WEBP_QUALITY      : 82;
        if ($maxWidth < 0)  $maxWidth  = defined('MAX_IMAGE_WIDTH')   ? MAX_IMAGE_WIDTH    : 2400;
        if ($maxHeight < 0) $maxHeight = defined('MAX_IMAGE_HEIGHT')  ? MAX_IMAGE_HEIGHT   : 2400;

        $maxSize = defined('MAX_UPLOAD_SIZE') ? MAX_UPLOAD_SIZE : 10 * 1024 * 1024;
        $allowedMimes = defined('ALLOWED_MIME_TYPES') ? ALLOWED_MIME_TYPES : [
            'image/jpeg', 'image/png', 'image/webp', 'image/gif',
        ];

        // ---------------------------------------------------------------
        // 1. Verificar que se recibió un archivo
        // ---------------------------------------------------------------
        if (!isset($file['tmp_name']) || $file['tmp_name'] === '') {
            return self::fail('No se ha recibido ningún archivo.');
        }

        // ---------------------------------------------------------------
        // 2. Verificar código de error de PHP
        // ---------------------------------------------------------------
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return self::fail(self::uploadErrorMessage($file['error']));
        }

        // ---------------------------------------------------------------
        // 3. Verificar que el archivo temporal existe y fue subido via HTTP
        // ---------------------------------------------------------------
        if (!is_uploaded_file($file['tmp_name'])) {
            return self::fail('El archivo no fue subido correctamente.');
        }

        // ---------------------------------------------------------------
        // 4. Validar tamaño máximo
        // ---------------------------------------------------------------
        if ($file['size'] > $maxSize) {
            $maxMB = round($maxSize / 1024 / 1024, 1);
            return self::fail("El archivo excede el tamaño máximo permitido ({$maxMB} MB).");
        }

        // ---------------------------------------------------------------
        // 5. Validar MIME real con finfo (NO confiar en la extensión)
        // ---------------------------------------------------------------
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $realMime = $finfo->file($file['tmp_name']);

        if (!in_array($realMime, $allowedMimes, true)) {
            return self::fail('El formato de imagen no está permitido. Formatos aceptados: JPEG, PNG, WebP, GIF.');
        }

        // ---------------------------------------------------------------
        // 6. Verificar que GD puede abrir la imagen (integridad)
        // ---------------------------------------------------------------
        if (!self::isGdAvailable()) {
            return self::fail('El servidor no dispone de la extensión GD necesaria para procesar imágenes.');
        }

        $srcImage = self::createImageFromFile($file['tmp_name'], $realMime);
        if ($srcImage === null) {
            return self::fail('El archivo no es una imagen válida o está dañado.');
        }

        // ---------------------------------------------------------------
        // 7. Verificar soporte WebP en GD
        // ---------------------------------------------------------------
        if (!self::hasWebpSupport()) {
            imagedestroy($srcImage);
            return self::fail('El servidor no tiene soporte WebP en GD. Contacte al administrador.');
        }

        // ---------------------------------------------------------------
        // 8. Redimensionar si excede las dimensiones máximas
        // ---------------------------------------------------------------
        $origWidth  = imagesx($srcImage);
        $origHeight = imagesy($srcImage);

        if ($origWidth > $maxWidth || $origHeight > $maxHeight) {
            $srcImage = self::resizeKeepingRatio($srcImage, $origWidth, $origHeight, $maxWidth, $maxHeight);
        }

        // ---------------------------------------------------------------
        // 9. Preservar transparencia (PNG / WebP con alfa)
        // ---------------------------------------------------------------
        $hasAlpha = in_array($realMime, ['image/png', 'image/webp', 'image/gif'], true);
        if ($hasAlpha) {
            imagealphablending($srcImage, false);
            imagesavealpha($srcImage, true);
        }

        // ---------------------------------------------------------------
        // 10. Generar nombre único y seguro
        // ---------------------------------------------------------------
        $uniqueName = 'img_' . bin2hex(random_bytes(8)) . '.webp';

        // ---------------------------------------------------------------
        // 11. Construir ruta absoluta de destino y verificar permisos
        // ---------------------------------------------------------------
        $absoluteDestDir = PUBLICROOT . '/' . trim($destDir, '/');

        if (!is_dir($absoluteDestDir)) {
            if (!@mkdir($absoluteDestDir, 0755, true)) {
                imagedestroy($srcImage);
                return self::fail('No se pudo crear la carpeta de destino.');
            }
        }

        if (!is_writable($absoluteDestDir)) {
            imagedestroy($srcImage);
            return self::fail('La carpeta de destino no tiene permisos de escritura.');
        }

        $absolutePath = $absoluteDestDir . '/' . $uniqueName;

        // Evitar sobrescribir archivos existentes (extremadamente improbable con random_bytes)
        if (file_exists($absolutePath)) {
            $uniqueName = 'img_' . bin2hex(random_bytes(8)) . '_' . time() . '.webp';
            $absolutePath = $absoluteDestDir . '/' . $uniqueName;
        }

        // ---------------------------------------------------------------
        // 12. Guardar como WebP
        // ---------------------------------------------------------------
        $saved = @imagewebp($srcImage, $absolutePath, $quality);
        imagedestroy($srcImage);

        if (!$saved || !file_exists($absolutePath)) {
            // Limpiar archivo parcial si se creó
            if (file_exists($absolutePath)) {
                @unlink($absolutePath);
            }
            return self::fail('Error al convertir la imagen a WebP.');
        }

        // ---------------------------------------------------------------
        // 13. Verificar que el archivo generado es realmente WebP
        // ---------------------------------------------------------------
        $generatedMime = (new \finfo(FILEINFO_MIME_TYPE))->file($absolutePath);
        if ($generatedMime !== 'image/webp') {
            @unlink($absolutePath);
            return self::fail('La conversión no generó un archivo WebP válido.');
        }

        // ---------------------------------------------------------------
        // 14. Devolver ruta relativa pública
        // ---------------------------------------------------------------
        $relativePath = trim($destDir, '/') . '/' . $uniqueName;

        return [
            'ok'    => true,
            'path'  => $relativePath,
            'error' => null,
        ];
    }

    // ===================================================================
    // Métodos internos
    // ===================================================================

    /**
     * Comprueba si la extensión GD está cargada.
     */
    public static function isGdAvailable(): bool
    {
        return extension_loaded('gd');
    }

    /**
     * Comprueba si GD tiene soporte WebP.
     */
    public static function hasWebpSupport(): bool
    {
        if (!self::isGdAvailable()) {
            return false;
        }
        $info = gd_info();
        return !empty($info['WebP Support']);
    }

    /**
     * Crea un recurso de imagen GD a partir de un archivo según su MIME.
     *
     * @return \GdImage|null
     */
    private static function createImageFromFile(string $path, string $mime)
    {
        try {
            switch ($mime) {
                case 'image/jpeg':
                    $img = @imagecreatefromjpeg($path);
                    break;
                case 'image/png':
                    $img = @imagecreatefrompng($path);
                    break;
                case 'image/webp':
                    $img = @imagecreatefromwebp($path);
                    break;
                case 'image/gif':
                    $img = @imagecreatefromgif($path);
                    break;
                default:
                    return null;
            }
        } catch (\Throwable $e) {
            error_log('ImageUploader::createImageFromFile error: ' . $e->getMessage());
            return null;
        }

        return ($img !== false) ? $img : null;
    }

    /**
     * Redimensiona manteniendo la proporción. No amplía imágenes pequeñas.
     *
     * @return \GdImage
     */
    private static function resizeKeepingRatio($srcImage, int $srcW, int $srcH, int $maxW, int $maxH)
    {
        // No ampliar
        if ($srcW <= $maxW && $srcH <= $maxH) {
            return $srcImage;
        }

        $ratioW = $maxW / $srcW;
        $ratioH = $maxH / $srcH;
        $ratio  = min($ratioW, $ratioH);

        $newW = (int) round($srcW * $ratio);
        $newH = (int) round($srcH * $ratio);

        $dst = imagecreatetruecolor($newW, $newH);

        // Preservar transparencia en la imagen destino
        imagealphablending($dst, false);
        imagesavealpha($dst, true);
        $transparent = imagecolorallocatealpha($dst, 0, 0, 0, 127);
        imagefill($dst, 0, 0, $transparent);

        imagecopyresampled($dst, $srcImage, 0, 0, 0, 0, $newW, $newH, $srcW, $srcH);
        imagedestroy($srcImage);

        return $dst;
    }

    /**
     * Genera un resultado de error estandarizado.
     */
    private static function fail(string $message): array
    {
        return [
            'ok'    => false,
            'path'  => null,
            'error' => $message,
        ];
    }

    /**
     * Traduce los códigos de error de PHP para $_FILES a mensajes legibles.
     */
    private static function uploadErrorMessage(int $code): string
    {
        switch ($code) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                return 'El archivo excede el tamaño máximo permitido por el servidor.';
            case UPLOAD_ERR_PARTIAL:
                return 'La subida del archivo se interrumpió. Inténtelo de nuevo.';
            case UPLOAD_ERR_NO_FILE:
                return 'No se seleccionó ningún archivo.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Error de configuración del servidor (carpeta temporal).';
            case UPLOAD_ERR_CANT_WRITE:
                return 'No se pudo guardar el archivo en el servidor.';
            case UPLOAD_ERR_EXTENSION:
                return 'Una extensión del servidor bloqueó la subida.';
            default:
                return 'Error desconocido al subir el archivo.';
        }
    }
}
