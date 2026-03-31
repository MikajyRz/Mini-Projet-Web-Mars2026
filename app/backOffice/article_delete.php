<?php
require '../config/db.php';
require '../config/auth.php';

require_login();

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM articles WHERE id = :id");
$stmt->execute(['id' => $id]);

header("Location: /dashboard");
exit;