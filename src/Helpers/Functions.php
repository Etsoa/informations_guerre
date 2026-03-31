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
    if (function_exists('transliterator_transliterate')) {
        $text = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $text);
    } else {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
    
    $text = str_replace(["'", "`", "^", "~", '"'], '', $text);
    
    $text = strtolower(trim($text));
    
    $stopWords = ['le', 'la', 'les', 'l', 'un', 'une', 'des', 'du', 'de', 'd', 'et', 'ou', 'mais', 'en', 'pour', 'dans', 'sur', 'a', 'au', 'aux', 'ce', 'cet', 'cette', 'ces'];
    
    $words = preg_split('/[^a-z0-9]+/i', $text, -1, PREG_SPLIT_NO_EMPTY);
    
    $filteredWords = array_filter($words, function($w) use ($stopWords) {
        return !in_array($w, $stopWords);
    });
    
    return implode('+', $filteredWords);
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