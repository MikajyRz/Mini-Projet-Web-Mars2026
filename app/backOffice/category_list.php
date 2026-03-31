<?php
require '../config/db.php';
require '../config/utils.php';
require '../config/auth.php';

require_login();

$sql = "SELECT * FROM categories ORDER BY name ASC";
$stmt = $pdo->query($sql);
$categories = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Gestion des catégories - Le Monde Backoffice">
    <title>Catégories - Le Monde Backoffice</title>
    <link rel="stylesheet" href="/css/backoffice.css">
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
            <a href="/?page=categories" class="active"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg> Catégories</a>
            <a href="/?page=home" target="_blank"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg> Voir le site</a>
        </nav>
    </aside>

    <main class="bo-main">
        <header class="bo-header">
            <div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">
                <h1>Gestion des Catégories</h1>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <span style="color: #666; font-size: 14px;"><?= escape($_SESSION['username'] ?? 'Utilisateur') ?></span>
                    <a href="/?page=logout" style="background: #dc3545; color: white; padding: 8px 16px; border-radius: 5px; text-decoration: none; font-size: 14px; border: none; cursor: pointer;">Déconnexion</a>
                </div>
            </div>
        </header>

        <div class="bo-content">
            <div class="bo-actions">
                <a href="/?page=category_add" class="btn btn-primary">Ajouter une catégorie</a>
            </div>

            <div class="table-container">
                <table class="bo-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= escape($category['name']) ?></td>
                        <td class="col-actions">
                            <a href="/?page=category_edit&id=<?= $category['id'] ?>" class="btn-icon" title="Modifier"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>
                            <a href="/?page=category_delete&id=<?= $category['id'] ?>" class="btn-icon text-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')" title="Supprimer"><svg class="svg-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                </table>
            </div>

            <?php if (empty($categories)): ?>
            <div class="empty-state">
                <p>Aucune catégorie pour le moment. <a href="/?page=category_add">Créer une catégorie</a></p>
            </div>
            <?php endif; ?>
        </div>
    </main>
</div>

</body>
</html>