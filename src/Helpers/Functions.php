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
    return $d->format('d/m/Y à H:i');
}

function truncate($text, $length = 150) {
    if (strlen($text) > $length) {
        return substr($text, 0, $length) . '...';
    }
    return $text;
}

function compressAndResizeImage($sourcePath, $destinationPath, $maxWidth = 1200, $maxHeight = 800, $quality = 80) {
    $info = getimagesize($sourcePath);
    if ($info === false) return false;

    $mime = $info['mime'];
    $width = $info[0];
    $height = $info[1];

    // Calcul des nouvelles dimensions en gardant le ratio
    $ratio = $width / $height;
    $newWidth = $width;
    $newHeight = $height;

    if ($width > $maxWidth || $height > $maxHeight) {
        if ($maxWidth / $maxHeight > $ratio) {
            $newWidth = $maxHeight * $ratio;
            $newHeight = $maxHeight;
        } else {
            $newHeight = $maxWidth / $ratio;
            $newWidth = $maxWidth;
        }
    }

    $imageResized = imagecreatetruecolor((int)$newWidth, (int)$newHeight);

    // Gérer la transparence pour PNG
    if ($mime == 'image/png') {
        imagealphablending($imageResized, false);
        imagesavealpha($imageResized, true);
        $transparent = imagecolorallocatealpha($imageResized, 255, 255, 255, 127);
        imagefilledrectangle($imageResized, 0, 0, (int)$newWidth, (int)$newHeight, $transparent);
    }

    // Créer l'image source à partir du fichier selon le type MIME
    switch ($mime) {
        case 'image/jpeg':
            $imageSource = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $imageSource = imagecreatefrompng($sourcePath);
            break;
        case 'image/gif':
            $imageSource = imagecreatefromgif($sourcePath);
            break;
        default:
            return false;
    }

    imagecopyresampled($imageResized, $imageSource, 0, 0, 0, 0, (int)$newWidth, (int)$newHeight, $width, $height);

    // Sauvegarder l'image optimisée
    $success = false;
    switch ($mime) {
        case 'image/jpeg':
            $success = imagejpeg($imageResized, $destinationPath, $quality); // 0-100
            break;
        case 'image/png':
            // PNG quality est de 0 (pas de compression) à 9
            $pngQuality = round((100 - $quality) / 10);
            $success = imagepng($imageResized, $destinationPath, $pngQuality);
            break;
        case 'image/gif':
            $success = imagegif($imageResized, $destinationPath);
            break;
    }

    imagedestroy($imageSource);
    imagedestroy($imageResized);

    return $success;
}

function handleImageUploads($files, $uploadDir) {
    $uploadedImages = [];
    if (!empty($files['name'][0])) {
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($files['tmp_name'] as $key => $tmpName) {
            if ($files['error'][$key] === UPLOAD_ERR_OK) {
                $originalName = $files['name'][$key];
                $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                $newName = uniqid() . '_' . time() . '.' . $extension;
                $destinationPath = $uploadDir . $newName;
                
                // On compresse et redimensionne (max 1200x800px, qualité 80%)
                if (function_exists('imagecreatefromjpeg') && compressAndResizeImage($tmpName, $destinationPath, 1200, 800, 80)) {
                    $uploadedImages[] = $newName;
                } elseif (move_uploaded_file($tmpName, $destinationPath)) {
                    // Fallback si l'extension GD n'est pas disponible ou qu'elle échoue
                    $uploadedImages[] = $newName;
                }
            }
        }
    }
    return $uploadedImages;
}
