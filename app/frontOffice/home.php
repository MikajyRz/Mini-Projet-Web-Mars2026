<?php
require '../config/db.php';
require '../config/utils.php';

$categoryFilter = $_GET['category'] ?? null;
$params = [];

$sql = "
    SELECT a.*, c.name as category_name 
    FROM articles a 
    LEFT JOIN categories c ON a.category_id = c.id
";

if ($categoryFilter) {
    $sql .= " WHERE LOWER(c.name) = :category";
    $params['category'] = mb_strtolower($categoryFilter, 'UTF-8');
}

$sql .= " ORDER BY a.created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$articles = $stmt->fetchAll();

$pageTitle = $categoryFilter ? 'Rubrique ' . ucfirst($categoryFilter) : 'Actualités en direct';
require '../frontOffice/header.php';
?>

<h1 class="section-title"><?= $categoryFilter ? 'Rubrique : ' . escape(ucfirst($categoryFilter)) : 'Actualités en Continu' ?></h1>

<?php if (count($articles) > 0): ?>
    <?php 
    // On divise les articles en sections pour garder l'équilibre
    $heroArticles = array_slice($articles, 0, 2);
    $sidebarArticles = array_slice($articles, 2, 4); // Max 4 dans la sidebar pour pas dépasser
    $remainingArticles = array_slice($articles, 6); // Tous les autres vont en bas
    ?>

    <div class="articles-grid">
        <!-- Articles principaux (Les 2 grands) -->
        <div class="hero-container">
            <?php foreach ($heroArticles as $hero): ?>
                <article class="article-hero">
                    <?php if (!empty($hero['image_principale'])): ?>
                        <a href="?page=article&slug=<?= $hero['slug'] ?>" aria-label="Lire l'article : <?= escape($hero['titre']) ?>" tabindex="-1">
                            <img class="article-image" 
                                 src="/uploads/<?= escape($hero['image_principale']) ?>" 
                                 alt="<?= escape(!empty($hero['image_alt']) ? $hero['image_alt'] : $hero['titre']) ?>"
                                 fetchpriority="high">
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
            <?php endforeach; ?>
        </div>

        <!-- Sidebar (Max 4 pour équilibre) -->
        <div class="articles-sidebar">
            <div class="section-title" style="font-size: 0.9rem; border-top: 2px solid #000; padding-top: 0.2rem; margin-bottom: 1.5rem;">À LIRE AUSSI</div>
            <?php foreach ($sidebarArticles as $a): ?>
                <article class="article-card article-sidebar-item">
                    <?php if (!empty($a['image_principale'])): ?>
                        <a href="?page=article&slug=<?= $a['slug'] ?>" aria-label="Lire l'article : <?= escape($a['titre']) ?>" tabindex="-1">
                            <img class="article-image" 
                                 src="/uploads/<?= escape($a['image_principale']) ?>" 
                                 alt="<?= escape(!empty($a['image_alt']) ? $a['image_alt'] : $a['titre']) ?>"
                                 loading="lazy" 
                                 decoding="async">
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
                </article>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- NOUVELLE SECTION : Grille de remplissage pour le reste des articles -->
    <?php if (count($remainingArticles) > 0): ?>
        <div class="section-title" style="margin-top: 4rem;">Toute l'Actualité</div>
        <div class="articles-bottom-grid">
            <?php foreach ($remainingArticles as $a): ?>
                <article class="article-card bottom-grid-item">
                    <?php if (!empty($a['image_principale'])): ?>
                        <div class="image-frame">
                            <a href="?page=article&slug=<?= $a['slug'] ?>" aria-label="Lire l'article : <?= escape($a['titre']) ?>" tabindex="-1">
                                <img class="article-image" 
                                     src="/uploads/<?= escape($a['image_principale']) ?>" 
                                     alt="<?= escape(!empty($a['image_alt']) ? $a['image_alt'] : $a['titre']) ?>"
                                     loading="lazy"
                                     decoding="async">
                            </a>
                        </div>
                    <?php endif; ?>
                    
                    <div class="article-text-content">
                        <span class="article-date">Le <?= date('d/m/Y', strtotime($a['created_at'])) ?></span>
                        
                        <h4 class="article-title">
                            <a href="?page=article&slug=<?= $a['slug'] ?>">
                                <?= escape($a['titre']) ?>
                            </a>
                        </h4>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php else: ?>
    <p>Aucun article disponible pour le moment.</p>
<?php endif; ?>

<?php require '../frontOffice/footer.php'; ?>