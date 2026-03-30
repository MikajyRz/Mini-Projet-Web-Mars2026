<?php
require '../config/db.php';
require '../config/utils.php';

$slug = $_GET['slug'];

$stmt = $pdo->prepare("SELECT * FROM articles WHERE slug = :slug");
$stmt->execute(['slug' => $slug]);

$a = $stmt->fetch();
?>

<h1><?= escape($a['titre']) ?></h1>

<?php if (!empty($a['image_principale'])): ?>
<img src="/uploads/<?= escape($a['image_principale']) ?>" alt="<?= escape($a['image_alt'] ?? $a['titre']) ?>">
<?php endif; ?>

<div>
    <?= $a['corps'] ?>
</div>