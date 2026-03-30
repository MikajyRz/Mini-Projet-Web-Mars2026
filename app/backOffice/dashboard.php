<?php
require '../config/db.php';
require '../config/utils.php';

$sql = "SELECT * FROM articles ORDER BY date_publication DESC";
$stmt = $pdo->query($sql);
$articles = $stmt->fetchAll();
?>

<h1>Dashboard - Gestion des Articles</h1>

<a href="/?page=add" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-bottom: 20px;">+ Ajouter un article</a>

<table border="1" style="width: 100%; border-collapse: collapse;">
<tr>
    <th>Titre</th>
    <th>Catégorie</th>
    <th>Date</th>
    <th>Actions</th>
</tr>

<?php foreach ($articles as $a): ?>
<tr>
    <td><?= escape($a['titre']) ?></td>
    <td><?= $a['category_id'] ?></td>
    <td><?= date('d/m/Y H:i', strtotime($a['date_publication'])) ?></td>
    <td>
        <a href="/?page=edit&id=<?= $a['id'] ?>">✏️ Modifier</a>
        <a href="/?page=delete&id=<?= $a['id'] ?>" onclick="return confirm('Êtes-vous sûr ?')">🗑️ Supprimer</a>
    </td>
</tr>
<?php endforeach; ?>

</table>

<?php if (empty($articles)): ?>
<p style="text-align: center; margin-top: 20px; color: #666;">Aucun article pour le moment. <a href="/?page=add">Créer un article</a></p>
<?php endif; ?>