<?php
require '../config/db.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM articles WHERE id = :id");
$stmt->execute(['id' => $id]);

header("Location: /?page=dashboard");