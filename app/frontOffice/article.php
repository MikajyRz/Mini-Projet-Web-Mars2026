<?php
require '../config/db.php';
require '../config/utils.php';

$slug = $_GET['slug'];

$stmt = $pdo->prepare("
    SELECT a.*, c.name as category_name 
    FROM articles a 
    LEFT JOIN categories c ON a.category_id = c.id 
    WHERE a.slug = :slug
");
$stmt->execute(['slug' => $slug]);

$a = $stmt->fetch();

if (!$a) {
    echo "<h1>Article non trouvé</h1>";
    exit;
}

// Récupérer les articles suggérés de la même catégorie
$suggestedStmt = $pdo->prepare("
    SELECT a.*, c.name as category_name 
    FROM articles a 
    LEFT JOIN categories c ON a.category_id = c.id 
    WHERE a.category_id = :category_id AND a.id != :current_id 
    ORDER BY a.created_at DESC 
    LIMIT 3
");
$suggestedStmt->execute([
    'category_id' => $a['category_id'],
    'current_id' => $a['id']
]);
$suggestedArticles = $suggestedStmt->fetchAll();

// Récupérer les articles récents globaux pour la sidebar (excluant l'article courant)
$recentStmt = $pdo->prepare("
    SELECT a.*, c.name as category_name 
    FROM articles a 
    LEFT JOIN categories c ON a.category_id = c.id 
    WHERE a.id != :current_id 
    ORDER BY a.created_at DESC 
    LIMIT 5
");
$recentStmt->execute(['current_id' => $a['id']]);
$recentArticles = $recentStmt->fetchAll();

$pageTitle = $a['titre'];
require '../frontOffice/header.php';
?>

<div class="article-detail-page">
    <!-- Contenu Principal (À GAUCHE) -->
    <article class="article-detail">
        <header class="article-detail-header">
            <?php if (!empty($a['category_name'])): ?>
                <span class="category-label"><?= escape($a['category_name']) ?></span>
            <?php endif; ?>
            
            <h1 class="article-detail-title"><?= escape($a['titre']) ?></h1>
            
            <div class="article-detail-meta">
                <span>Publié le <?= date('d/m/Y à H:i', strtotime($a['created_at'])) ?></span>
            </div>
        </header>

        <?php if (!empty($a['image_principale'])): ?>
        <img class="article-detail-image" 
             src="/uploads/<?= escape($a['image_principale']) ?>" 
             alt="<?= escape(!empty($a['image_alt']) ? $a['image_alt'] : $a['titre']) ?>"
             fetchpriority="high">
        <?php endif; ?>

        <div class="article-detail-content">
            <?= $a['corps'] ?>
        </div>
    </article>

    <!-- Sidebar (À DROITE) - Suggestions de la même catégorie -->
    <aside class="articles-sidebar">
        <div class="section-title">Dans la même rubrique</div>
        <?php if (count($suggestedArticles) > 0): ?>
            <?php foreach ($suggestedArticles as $suggested): ?>
                <article class="article-card article-sidebar-item">
                    <div class="sidebar-inner">
                        <?php if (!empty($suggested['image_principale'])): ?>
                            <div class="sidebar-image-wrap">
                                <a href="?page=article&slug=<?= $suggested['slug'] ?>" aria-label="Lire l'article : <?= escape($suggested['titre']) ?>" tabindex="-1">
                                    <img class="article-image" 
                                         src="/uploads/<?= escape($suggested['image_principale']) ?>" 
                                         alt="<?= escape(!empty($suggested['image_alt']) ? $suggested['image_alt'] : $suggested['titre']) ?>"
                                         loading="lazy" 
                                         decoding="async">
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="sidebar-text">
                            <h4 class="article-title">
                                <a href="?page=article&slug=<?= $suggested['slug'] ?>">
                                    <?= escape($suggested['titre']) ?>
                                </a>
                            </h4>
                            <p class="article-date">Le <?= date('d/m/Y', strtotime($suggested['created_at'])) ?></p>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="no-articles">Aucun autre article dans cette rubrique.</p>
        <?php endif; ?>
    </aside>
</div>

<?php require '../frontOffice/footer.php'; ?>