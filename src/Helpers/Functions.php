<?php
// Fonction utilitaires

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function sanitize($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

function slugify($text) {
    $text = preg_replace('/[^a-z0-9]+/i', '-', $text);
    return strtolower(trim($text, '-'));
}

function formatDate($date) {
    $d = new DateTime($date);
    return $d->format('d/m/Y ?? H:i');
}

function truncate($text, $length = 150) {
    if (strlen($text) > $length) {
        return substr($text, 0, $length) . '...';
    }
    return $text;
}

// Extrait le premier src d'une balise <img> dans un contenu HTML
function firstImageSrc($html) {
    if (empty($html)) return null;
    if (preg_match('/<img[^>]+src=[\"\']([^\"\']+)/i', $html, $matches)) {
        return $matches[1];
    }
    return null;
}

// Extrait toutes les sources d'images d'un contenu HTML (unique, ordre d'apparition)
function allImageSrc($html) {
    if (empty($html)) return [];
    preg_match_all('/<img[^>]+src=[\"\']([^\"\']+)/i', $html, $matches);
    if (empty($matches[1])) return [];
    // Supprime les doublons en conservant l'ordre
    $seen = [];
    $result = [];
    foreach ($matches[1] as $src) {
        if (!isset($seen[$src])) {
            $seen[$src] = true;
            $result[] = $src;
        }
    }
    return $result;
}
