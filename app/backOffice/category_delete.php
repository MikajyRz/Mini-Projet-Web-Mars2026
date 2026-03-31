<?php
require '../config/db.php';
require '../config/auth.php';

require_login();

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: /categories");
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM categories WHERE id = :id");
    $stmt->execute(['id' => $id]);
} catch (PDOException $e) {
    // Si erreur de contrainte étrangère, afficher un message
    if (strpos($e->getMessage(), 'foreign key') !== false) {
        die("Erreur : Vous ne pouvez pas supprimer cette catégorie car elle contient des articles. Supprimez d'abord les articles associés.");
    }
    die("Erreur base de données : " . $e->getMessage());
}

header("Location: /categories");
exit;
