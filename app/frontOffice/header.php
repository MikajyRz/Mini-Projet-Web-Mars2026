<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? escape($pageTitle) . ' - Le Monde' : 'Le Monde - Actualités en direct' ?></title>
    <!-- Google Fonts for newspaper feel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Merriweather:wght@300;400;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="header-container">
        <div class="site-title">
            <a href="/">Le Monde</a>
        </div>
        <nav class="main-nav">
            <a href="/">À la une</a>
            <?php 
            // Récupérer les catégories réelles pour le menu
            require_once '../config/db.php';
            $categories_nav = $pdo->query("SELECT * FROM categories ORDER BY name ASC")->fetchAll();
            foreach ($categories_nav as $cat): 
            ?>
                <a href="/?category=<?= urlencode(strtolower($cat['name'])) ?>"><?= escape($cat['name']) ?></a>
            <?php endforeach; ?>
        </nav>
        <a href="/login" class="login-btn" title="Connexion / Inscription">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                <line x1="19" y1="3" x2="19" y2="7"/>
                <line x1="17" y1="5" x2="21" y2="5"/>
            </svg>
            Connexion
        </a>
    </div>
</header>

<main class="container">
