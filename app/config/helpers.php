<?php

/**
 * Función para asegurar que la URL sea de tipo "embed" para el iframe
 */
function prepararYoutube($url) {
    $url = trim($url);

    if ($url === '') {
        return '';
    }

    // Caso: youtu.be/ID
    if (strpos($url, 'youtu.be/') !== false) {
        $videoId = substr($url, strrpos($url, '/') + 1);
        $videoId = explode('?', $videoId)[0];
        return 'https://www.youtube.com/embed/' . $videoId;
    }

    // Caso: youtube.com/watch?v=ID
    if (strpos($url, 'watch?v=') !== false) {
        parse_str(parse_url($url, PHP_URL_QUERY), $params);
        if (!empty($params['v'])) {
            return 'https://www.youtube.com/embed/' . $params['v'];
        }
    }

    // Caso: ya viene en embed
    if (strpos($url, '/embed/') !== false) {
        return $url;
    }

    // Caso: shorts
    if (strpos($url, '/shorts/') !== false) {
        $videoId = substr($url, strrpos($url, '/') + 1);
        $videoId = explode('?', $videoId)[0];
        return 'https://www.youtube.com/embed/' . $videoId;
    }

    return '';
}

/**
 * Función para transformar URLs de YouTube para entrevistas
 */
function transformarYoutubeEmbed($url) {
    $shortUrlRegex = '/youtu.be\/([a-zA-Z0-9_-]+)\??/i';
    $longUrlRegex = '/youtube.com\/((?:embed)|(?:watch))((?:\?v\=)|(?:\/))([a-zA-Z0-9_-]+)/i';

    $youtube_id = '';

    if (preg_match($longUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }

    if (preg_match($shortUrlRegex, $url, $matches)) {
        $youtube_id = $matches[count($matches) - 1];
    }

    if (!empty($youtube_id)) {
        return 'https://www.youtube.com/embed/' . $youtube_id;
    }

    return $url;
}
function asset_url($path) {
    $path = trim((string) $path);

    if ($path === '') {
        return '';
    }

    if (preg_match('#^(https?:)?//#i', $path) || preg_match('#^(data|mailto):#i', $path)) {
        return $path;
    }

    return URLROOT . '/' . ltrim($path, '/');
}

function site_url($path = '') {
    $path = trim((string) $path);

    if ($path === '') {
        return URLROOT;
    }

    return URLROOT . '/' . ltrim($path, '/');
}

/**
 * Escapa strings para su uso seguro en atributos HTML y metadatos SEO.
 */
function esc_attr($string) {
    return htmlspecialchars((string) $string, ENT_QUOTES, 'UTF-8');
}