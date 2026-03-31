<?php
require '../config/db.php';
require '../config/utils.php';
require '../config/auth.php';

require_login();

// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_POST['id'] ?? null;
$titre = $_POST['titre'] ?? null;
$chapeau = $_POST['chapeau'] ?? null;
$corps = $_POST['corps'] ?? null;
$image_alt = $_POST['image_alt'] ?? null;
$category_id = $_POST['category_id'] ?? 1;
$meta_title = $_POST['meta_title'] ?? null;

// Vérifier que les champs requis sont remplis
if (!$titre || !$chapeau || !$corps) {
    die("Erreur : Tous les champs obligatoires doivent être remplis. Titre, Chapeau et Corps sont requis.");
}

$image_principale = null;

// Traitement de l'upload d'image
if (isset($_FILES['image_principale']) && $_FILES['image_principale']['size'] > 0) {
    $upload_dir = '../public/uploads/';
    
    // Créer le dossier s'il n'existe pas
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    $file = $_FILES['image_principale'];
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    
    // Validation
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'webp', 'gif');
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    
    if (!in_array($file_ext, $allowed_extensions)) {
        die("Format de fichier non autorisé. Utilisez: JPG, PNG, WebP ou GIF");
    }
    
    if ($file_size > 5242880) { // 5MB
        die("Le fichier est trop volumineux (Max 5MB)");
    }
    
    if ($file_error === UPLOAD_ERR_OK) {
        // Générer un nom unique
        $new_file_name_base = uniqid() . '_' . time();
        $new_file_name_webp = $new_file_name_base . '.webp';
        $file_path_webp = $upload_dir . $new_file_name_webp;
        
        // Tenter la conversion WebP (max 800px largeur, qualité 70 pour Mobile Performance 100/100)
        if (convert_and_resize_to_webp($file_tmp, $file_path_webp, 800, 70)) {
            $image_principale = $new_file_name_webp;
        } else {
            // Fallback (ex: format non supporté par GD)
            $new_file_name = $new_file_name_base . '.' . $file_ext;
            $file_path = $upload_dir . $new_file_name;
            if (move_uploaded_file($file_tmp, $file_path)) {
                $image_principale = $new_file_name;
            } else {
                die("Erreur lors du upload du fichier");
            }
        }
    }
}

$slug = slugify($titre);

try {
    if ($id) {
        // UPDATE
        $sql = "UPDATE articles SET
                titre = :titre,
                slug = :slug,
                chapeau = :chapeau,
                corps = :corps,
                image_principale = COALESCE(:image_principale, image_principale),
                image_alt = :image_alt,
                category_id = :category_id,
                meta_title = :meta_title,
                updated_at = CURRENT_TIMESTAMP
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'titre' => $titre,
            'slug' => $slug,
            'chapeau' => $chapeau,
            'corps' => $corps,
            'image_principale' => $image_principale,
            'image_alt' => $image_alt,
            'category_id' => $category_id,
            'meta_title' => $meta_title,
            'id' => $id
        ]);
        
        if (!$result) {
            die("Erreur lors de la modification : " . json_encode($stmt->errorInfo()));
        }
    } else {
        // INSERT
        $sql = "INSERT INTO articles (titre, slug, chapeau, corps, image_principale, image_alt, category_id, meta_title)
                VALUES (:titre, :slug, :chapeau, :corps, :image_principale, :image_alt, :category_id, :meta_title)";

        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            'titre' => $titre,
            'slug' => $slug,
            'chapeau' => $chapeau,
            'corps' => $corps,
            'image_principale' => $image_principale,
            'image_alt' => $image_alt,
            'category_id' => $category_id,
            'meta_title' => $meta_title
        ]);
        
        if (!$result) {
            die("Erreur lors de l'insertion : " . json_encode($stmt->errorInfo()));
        }
    }
    
    header("Location: /?page=dashboard");
    exit;
} catch (Exception $e) {
    die("Exception : " . $e->getMessage());
}