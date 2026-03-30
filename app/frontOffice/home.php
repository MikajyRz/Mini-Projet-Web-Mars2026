<?php
require '../config/db.php';
require '../config/utils.php';

$articles = $pdo->query("
    SELECT a.*, c.name as category_name 
    FROM articles a 
    LEFT JOIN categories c ON a.category_id = c.id 
    ORDER BY a.created_at DESC
")->fetchAll();

$pageTitle = 'Actualités en direct';
require '../frontOffice/header.php';
?>

<div class="section-title">Actualités en Continu</div>

<?php if (count($articles) > 0): ?>
    <div class="articles-grid">
        <!-- Articles principaux (Les 2 premiers) -->
        <div class="hero-container">
            <?php for ($i = 0; $i < min(2, count($articles)); $i++): $hero = $articles[$i]; ?>
                <article class="article-hero">
                    <?php if (!empty($hero['image_principale'])): ?>
                        <a href="?page=article&slug=<?= $hero['slug'] ?>">
                            <img class="article-image" src="/uploads/<?= escape($hero['image_principale']) ?>" alt="<?= escape($hero['image_alt'] ?? $hero['titre']) ?>">
                        </a>
                    <?php endif; ?>
                    
                    <div class="article-header-meta" style="margin-top: 1rem; margin-bottom: 0.5rem;">
                        <?php if (!empty($hero['category_name'])): ?>
                            <span class="category-label"><?= escape($hero['category_name']) ?></span>
                        <?php endif; ?>
                        <span class="article-date" style="display: block; font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; font-weight: 700; margin-top: 0.3rem;">Publié le <?= date('d/m/Y', strtotime($hero['created_at'])) ?></span>
                    </div>
                    
                    <h2 class="article-title">
                        <a href="?page=article&slug=<?= $hero['slug'] ?>">
                            <?= escape($hero['titre']) ?>
                        </a>
                    </h2>
                    <div class="article-excerpt">
                        <?= mb_strimwidth(strip_tags($hero['corps']), 0, 400, "...") ?>
                    </div>
                </article>
            <?php endfor; ?>
        </div>

        <!-- Sidebar des articles suivants (À DROITE) -->
        <div class="articles-sidebar">
            <div class="section-title" style="font-size: 0.9rem; border-top: 2px solid #000; padding-top: 0.2rem; margin-bottom: 1.5rem;">ACTUALITÉS RÉCENTES</div>
            <?php for ($i = 2; $i < count($articles); $i++): $a = $articles[$i]; ?>
                <article class="article-card article-sidebar-item">
                    <?php if (!empty($a['image_principale'])): ?>
                        <a href="?page=article&slug=<?= $a['slug'] ?>">
                            <img class="article-image" src="/uploads/<?= escape($a['image_principale']) ?>" alt="<?= escape($a['image_alt'] ?? $a['titre']) ?>">
                        </a>
                    <?php endif; ?>
                    
                    <div class="article-header-meta" style="margin-top: 0.5rem;">
                        <?php if (!empty($a['category_name'])): ?>
                            <span class="category-label" style="font-size: 0.7rem;"><?= escape($a['category_name']) ?></span>
                        <?php endif; ?>
                        <span class="article-date" style="font-size: 0.7rem; color: var(--text-muted); display: block;">Publié le <?= date('d/m/Y', strtotime($a['created_at'])) ?></span>
                    </div>

                    <h3 class="article-title" style="font-size: 1.2rem; margin-top: 0.3rem;">
                        <a href="?page=article&slug=<?= $a['slug'] ?>">
                            <?= escape($a['titre']) ?>
                        </a>
                    </h3>
                    
                    <p class="article-excerpt" style="font-size: 0.85rem; color: #444;"><?= mb_strimwidth(strip_tags($a['corps']), 0, 150, "...") ?></p>
                </article>
            <?php endfor; ?>
        </div>
    </div>
<?php else: ?>
    <p>Aucun article disponible pour le moment.</p>
<?php endif; ?>

<?php require '../frontOffice/footer.php'; ?>