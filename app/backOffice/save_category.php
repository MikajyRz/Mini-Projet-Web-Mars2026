<?php
require '../config/db.php';
require '../config/auth.php';
require '../config/utils.php';

require_login();

$id = $_POST['id'] ?? null;
$name = trim($_POST['name'] ?? '');

if (!$name) {
    die("Erreur : Le nom de la catégorie est requis.");
}

try {
    if ($id) {
        // Modification
        $stmt = $pdo->prepare("UPDATE categories SET name = :name WHERE id = :id");
        $stmt->execute(['name' => $name, 'id' => $id]);
    } else {
        // Création
        $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (:name)");
        $stmt->execute(['name' => $name]);
    }
    
    header("Location: /?page=categories");
    exit;
} catch (PDOException $e) {
    if (strpos($e->getMessage(), 'unique') !== false) {
        die("Erreur : Une catégorie avec ce nom existe déjà.");
    }
    die("Erreur base de données : " . $e->getMessage());
}
