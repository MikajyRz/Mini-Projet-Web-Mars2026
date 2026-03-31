<?php require '../config/db.php'; ?>
<?php require '../config/auth.php'; ?>
<?php require_login(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ajouter une catégorie - Le Monde Backoffice">
    <title>Ajouter une catégorie - Le Monde Backoffice</title>
    <style>
        <?php readfile(__DIR__ . '/../public/css/backoffice.css'); ?>
    </style>
</head>

<body>

<div class="bo-layout">
    <aside class="bo-sidebar">
        <div class="bo-logo">
            <h2>Le Monde <span>Admin</span></h2>
        </div>
        <nav class="bo-nav">
            <a href="/dashboard"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg> Dashboard</a>
            <a href="/add"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg> Nouvel Article</a>
            <a href="/categories" class="active"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg> Catégories</a>
            <a href="/" target="_blank"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg> Voir le site</a>
        </nav>
    </aside>

    <main class="bo-main">
        <header class="bo-header">
            <h1>Ajouter une catégorie</h1>
        </header>

        <div class="bo-content">
            <div class="form-card">
                <form action="/categories/save" method="POST">
                    <div class="form-group">
                        <label for="name">Nom de la catégorie</label>
                        <input type="text" id="name" name="name" placeholder="Ex: Politique, Économie, Culture" required>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Ajouter la catégorie</button>
                        <a href="/categories" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

</body>
</html>