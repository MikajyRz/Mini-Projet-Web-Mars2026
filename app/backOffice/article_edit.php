<?php
require '../config/db.php';
require '../config/utils.php';
require '../config/auth.php';

require_login();

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM articles WHERE id = :id");
$stmt->execute(['id' => $id]);
$article = $stmt->fetch();
$tinymceKey = getenv('TINYMCE_API_KEY');

// Charger les catégories depuis la base de données
$stmt = $pdo->query("SELECT id, name FROM categories ORDER BY name");
$categories = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'article - Le Monde Backoffice</title>
    <link rel="stylesheet" href="/css/backoffice.css">
    <script src="https://cdn.tiny.cloud/1/<?= $tinymceKey ?>/tinymce/6/tinymce.min.js"></script>
</head>

<body>

<div class="bo-layout">
    <aside class="bo-sidebar">
        <div class="bo-logo">
            <h2>Le Monde <span>Admin</span></h2>
        </div>
        <nav class="bo-nav">
            <a href="/?page=dashboard"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg> Dashboard</a>
            <a href="/?page=add"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg> Nouvel Article</a>
            <a href="/?page=categories"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg> Catégories</a>
            <a href="/?page=home" target="_blank"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg> Voir le site</a>
        </nav>
    </aside>

    <main class="bo-main">
        <header class="bo-header">
            <h1>Modifier l'article</h1>
        </header>

        <div class="bo-content">
            <div class="form-card">
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
            <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= $article['category_id'] == $cat['id'] ? 'selected' : '' ?>><?= escape($cat['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="meta_title">Meta titre (SEO)</label>
        <input type="text" id="meta_title" name="meta_title" value="<?= escape($article['meta_title']) ?>">
    </div>

    <div class="form-group">
        <label for="corps">Contenu</label>
        <textarea id="corps" name="corps"><?= escape($article['corps']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Modifier l'article</button>
                </form>
            </div>
        </div>
    </main>
</div>

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