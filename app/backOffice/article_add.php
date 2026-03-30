<?php require '../config/db.php'; ?>
<?php require '../config/auth.php'; ?>
<?php require_login(); ?>
<?php $tinymceKey = getenv('TINYMCE_API_KEY'); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter article - Le Monde Backoffice</title>
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
            <a href="/?page=add" class="active"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg> Nouvel Article</a>
            <a href="/?page=home" target="_blank"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg> Voir le site</a>
        </nav>
    </aside>

    <main class="bo-main">
        <header class="bo-header">
            <h1>Ajouter un article</h1>
        </header>

        <div class="bo-content">
            <div class="form-card">
                <form id="articleForm" action="/?page=save" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="titre">Titre</label>
        <input type="text" id="titre" name="titre" placeholder="Titre de l'article" required>
    </div>

    <div class="form-group">
        <label for="chapeau">Résumé (Chapeau)</label>
        <textarea id="chapeau" name="chapeau" rows="3" placeholder="Résumé de l'article pour meta description" required></textarea>
    </div>

    <div class="form-group">
        <label for="image_principale">Image principale</label>
        <input type="file" id="image_principale" name="image_principale" accept="image/*">
        <small>Formats acceptés: JPG, PNG, WebP (Max 5MB)</small>
    </div>

    <div class="form-group">
        <label for="image_alt">Texte alternatif (Alt) pour l'image</label>
        <input type="text" id="image_alt" name="image_alt" placeholder="Description de l'image">
    </div>

    <div class="form-group">
        <label for="category_id">Catégorie</label>
        <select id="category_id" name="category_id" required>
            <option value="1">International</option>
            <option value="2">Politique</option>
            <option value="3">Économie</option>
            <option value="4">Culture</option>
            <option value="5">Sports</option>
        </select>
    </div>

    <div class="form-group">
        <label for="meta_title">Meta titre (SEO)</label>
        <input type="text" id="meta_title" name="meta_title" placeholder="Titre pour les moteurs de recherche">
    </div>

    <div class="form-group">
        <label for="corps">Contenu</label>
        <textarea id="corps" name="corps"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Publier l'article</button>
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