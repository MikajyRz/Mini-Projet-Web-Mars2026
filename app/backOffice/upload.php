<?php
// Endpoint pour l'upload d'images TinyMCE

require '../config/utils.php';
require '../config/auth.php';

require_login();

$upload_dir = '../public/uploads/';
$public_base_url = '/uploads/';

// Créer le dossier s'il n'existe pas
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    header('Content-Type: application/json; charset=utf-8');
    $file = $_FILES['file'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    
    // Validation
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'webp', 'gif');
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    if (!in_array($file_ext, $allowed_extensions)) {
        http_response_code(422);
        echo json_encode(['error' => 'Format non autorisé']);
        exit;
    }
    
    if ($file_size > 5242880) { // 5MB
        http_response_code(413);
        echo json_encode(['error' => 'Fichier trop volumineux']);
        exit;
    }
    
    if ($file_error !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['error' => 'Erreur lors du upload']);
        exit;
    }
    
    // Générer un nom unique
    $new_file_name_base = uniqid() . '_' . time();
    $new_file_name_webp = $new_file_name_base . '.webp';
    $file_path_webp = $upload_dir . $new_file_name_webp;
    
    // Tenter la conversion WebP (max 800px et qualité 70)
    if (convert_and_resize_to_webp($file_tmp, $file_path_webp, 800, 70)) {
        echo json_encode([
            'location' => $public_base_url . $new_file_name_webp
        ]);
        exit;
    } else {
        // Fallback: upload normal
        $new_file_name = $new_file_name_base . '.' . $file_ext;
        $file_path = $upload_dir . $new_file_name;
        
        if (move_uploaded_file($file_tmp, $file_path)) {
            echo json_encode([
                'location' => $public_base_url . $new_file_name
            ]);
            exit;
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Erreur serveur']);
            exit;
        }
    }
} else {
    http_response_code(400);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(['error' => 'Pas de fichier']);
    exit;
}
?>
