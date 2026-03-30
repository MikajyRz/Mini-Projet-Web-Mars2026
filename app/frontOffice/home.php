<?php
require '../config/db.php';
require '../config/utils.php';

$articles = $pdo->query("SELECT * FROM articles ORDER BY created_at DESC")->fetchAll();
?>

<h1>Actualités</h1>

<?php foreach ($articles as $a): ?>
    <h2>
        <a href="?page=article&slug=<?= $a['slug'] ?>">
            <?= escape($a['titre']) ?>
        </a>
    </h2>
<?php endforeach; ?>