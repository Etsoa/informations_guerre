<?php
// Fonctions utilitaires

function redirect($url) {
    header('Location: ' . $url);
    exit;
}

function sanitize($data) {
    if ($data === null) return '';
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Génère un slug à partir d'un texte (supporte les accents français)
 */
function slugify($text) {
    // Translitérer les caractères accentués
    $text = transliterator_transliterate('Any-Latin; Latin-ASCII; Lower()', $text);
    if ($text === false) {
        // Fallback si intl n'est pas disponible
        $text = strtolower($text);
        $text = strtr($text, [
            'à'=>'a','â'=>'a','ä'=>'a','é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
            'î'=>'i','ï'=>'i','ô'=>'o','ö'=>'o','ù'=>'u','û'=>'u','ü'=>'u',
            'ÿ'=>'y','ç'=>'c','œ'=>'oe','æ'=>'ae'
        ]);
    }
    // Remplacer tout ce qui n'est pas alphanumérique par un tiret
    $text = preg_replace('/[^a-z0-9]+/', '-', $text);
    return trim($text, '-');
}

function formatDate($date) {
    if (!$date) return '';
    $d = new DateTime($date);
    setlocale(LC_TIME, 'fr_FR.UTF-8', 'fr_FR', 'french');
    $months = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
    $day = $d->format('d');
    $month = $months[(int)$d->format('m') - 1];
    $year = $d->format('Y');
    $time = $d->format('H\hi');
    return "$day $month $year à $time";
}

function formatDateShort($date) {
    if (!$date) return '';
    $d = new DateTime($date);
    return $d->format('d/m/Y');
}

function truncate($text, $length = 150) {
    if ($text === null) return '';
    if (mb_strlen($text) > $length) {
        return mb_substr($text, 0, $length) . '...';
    }
    return $text;
}

/**
 * Retourne le temps écoulé depuis une date (il y a X minutes/heures/jours)
 */
function timeAgo($date) {
    if (!$date) return '';
    $now = new DateTime();
    $ago = new DateTime($date);
    $diff = $now->diff($ago);
    
    if ($diff->y > 0) return 'il y a ' . $diff->y . ' an' . ($diff->y > 1 ? 's' : '');
    if ($diff->m > 0) return 'il y a ' . $diff->m . ' mois';
    if ($diff->d > 0) return 'il y a ' . $diff->d . ' jour' . ($diff->d > 1 ? 's' : '');
    if ($diff->h > 0) return 'il y a ' . $diff->h . ' heure' . ($diff->h > 1 ? 's' : '');
    if ($diff->i > 0) return 'il y a ' . $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
    return 'à l\'instant';
}

/**
 * Génère une URL propre pour un article
 */
function articleUrl($article) {
    if (!isset($article['id'])) {
        return BASE_URL;
    }

    $slug = !empty($article['titre']) ? slugify($article['titre']) : '';
    return BASE_URL . 'article/' . (int) $article['id'] . ($slug !== '' ? '-' . $slug : '');
}

/**
 * Génère une URL propre pour une catégorie
 */
function categoryUrl($category) {
    if (!isset($category['id'])) {
        return BASE_URL;
    }

    $slug = !empty($category['nom']) ? slugify($category['nom']) : '';
    return BASE_URL . 'category/' . (int) $category['id'] . ($slug !== '' ? '-' . $slug : '');
}

/**
 * Retourne l'URL d'image avec fallback local.
 */
function imageUrl(?string $imageName): string {
    if (!empty($imageName)) {
        return UPLOADS_URL . sanitize($imageName);
    }
    return BASE_URL . 'assets/images/placeholder-news.svg';
}
