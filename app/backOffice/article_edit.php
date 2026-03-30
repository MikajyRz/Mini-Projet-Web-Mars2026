<?php
require '../config/db.php';
require '../config/utils.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
$stmt->execute(['id' => $id]);
$article = $stmt->fetch();
$tinymceKey = getenv('TINYMCE_API_KEY');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier l'article</title>
    <style>
        form { max-width: 800px; margin: 20px auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="file"], select, textarea { width: 100%; padding: 8px; border: 1px solid #ddd; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
    </style>

    <script src="https://cdn.tiny.cloud/1/<?= $tinymceKey ?>/tinymce/6/tinymce.min.js"></script>
</head>

<body>

<h1>Modifier l'article</h1>

<form id="articleForm" action="/?page=save" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $article['id'] ?>">

    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" value="<?= escape($article['titre']) ?>" required>
    </div>

    <div class="form-group">
        <label for="chapeau">Résumé (Chapeau)</label>
        <textarea id="chapeau" name="chapeau" rows="3" required><?= escape($article['chapeau']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="corps">Contenu</label>
        <textarea id="corps" name="corps"><?= escape($article['corps']) ?></textarea>
    </div>

    <div class="form-group">
        <label for="image_principale">Image principale</label>
        <input type="file" id="image_principale" name="image_principale" accept="image/*">
        <small>Formats acceptés: JPG, PNG, WebP (Max 5MB)</small>
    </div>

    <div class="form-group">
        <label for="image_alt">Texte alternatif (Alt)</label>
        <input type="text" id="image_alt" name="image_alt" value="<?= escape($article['image_alt']) ?>">
    </div>

    <div class="form-group">
        <label for="category_id">Catégorie</label>
        <select id="category_id" name="category_id" required>
            <option value="1" <?= $article['category_id'] == 1 ? 'selected' : '' ?>>International</option>
            <option value="2" <?= $article['category_id'] == 2 ? 'selected' : '' ?>>Politique</option>
            <option value="3" <?= $article['category_id'] == 3 ? 'selected' : '' ?>>Économie</option>
            <option value="4" <?= $article['category_id'] == 4 ? 'selected' : '' ?>>Culture</option>
            <option value="5" <?= $article['category_id'] == 5 ? 'selected' : '' ?>>Sports</option>
        </select>
    </div>

    <div class="form-group">
        <label for="meta_title">Meta titre (SEO)</label>
        <input type="text" id="meta_title" name="meta_title" value="<?= escape($article['meta_title']) ?>">
    </div>

    <button type="submit">Modifier l'article</button>
</form>

<script>
tinymce.init({
    selector: 'textarea#corps',
    height: 400,
    plugins: 'image link lists',
    images_upload_url: '/?page=upload',
    automatic_uploads: true,
    file_picker_types: 'image',
    setup: function(editor) {
        // Synchroniser avant soumission
        document.getElementById('articleForm').addEventListener('submit', function(e) {
            const activeEditor = tinymce.get('corps');
            const plainText = (activeEditor ? activeEditor.getContent({ format: 'text' }) : '').trim();
            if (!plainText) {
                e.preventDefault();
                alert('Le contenu de l\'article est obligatoire.');
                if (activeEditor) {
                    activeEditor.focus();
                }
                return;
            }
            tinymce.triggerSave();
        });
    }
});
</script>

</body>
</html>