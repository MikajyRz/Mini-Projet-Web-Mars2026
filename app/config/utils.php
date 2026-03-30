<?php
function slugify($text) {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text)));
}

function escape($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Convertit et redimensionne une image en WebP pour la performance optimale
 */
function convert_and_resize_to_webp($source_file, $destination_file, $max_width = 1200, $quality = 80) {
    $info = getimagesize($source_file);
    if (!$info) return false;

    $width = $info[0];
    $height = $info[1];
    $image_type = $info[2];

    // Calcul des nouvelles dimensions
    if ($width > $max_width) {
        $new_width = $max_width;
        $new_height = floor($height * ($max_width / $width));
    } else {
        $new_width = $width;
        $new_height = $height;
    }

    $image_p = imagecreatetruecolor($new_width, $new_height);
    
    // Gérer la transparence pour PNG et GIF
    if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF || $image_type == IMAGETYPE_WEBP) {
        imagealphablending($image_p, false);
        imagesavealpha($image_p, true);
        $transparent = imagecolorallocatealpha($image_p, 255, 255, 255, 127);
        imagefilledrectangle($image_p, 0, 0, $new_width, $new_height, $transparent);
    }

    $image = false;
    switch ($image_type) {
        case IMAGETYPE_JPEG:
            $image = @imagecreatefromjpeg($source_file);
            break;
        case IMAGETYPE_PNG:
            $image = @imagecreatefrompng($source_file);
            break;
        case IMAGETYPE_GIF:
            $image = @imagecreatefromgif($source_file);
            break;
        case IMAGETYPE_WEBP:
            $image = @imagecreatefromwebp($source_file);
            break;
    }

    if (!$image) return false;

    // Redimensionnement propre
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
    
    // Sauvegarder en WebP (la magie opère ici)
    $success = imagewebp($image_p, $destination_file, $quality);
    
    imagedestroy($image_p);
    imagedestroy($image);
    
    return $success;
}