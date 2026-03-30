<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Actualités en direct et en continu : Politique, International, Économie, Culture et plus encore sur votre média de référence.">
    <title><?= isset($pageTitle) ? escape($pageTitle) . ' - Le Monde' : 'Le Monde - Actualités en direct' ?></title>
    <!-- Google Fonts for newspaper feel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Chargement asynchrone des polices (Désactive le blocage de rendu) -->
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Merriweather:wght@300;400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Merriweather:wght@300;400;700&display=swap" media="print" onload="this.media='all'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=Merriweather:wght@300;400;700&display=swap">
    </noscript>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="header-container">
        <div class="site-title">
            <a href="/" style="color: inherit; text-decoration: none;" aria-label="Retour à l'accueil Le Monde">LE MONDE</a>
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
        <a href="/login" class="login-btn" aria-label="Espace personnel / Se connecter">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
                <line x1="12" y1="11" x2="12" y2="11"></line>
                <line x1="19" y1="8" x2="19" y2="14"></line>
                <line x1="16" y1="11" x2="22" y2="11"></line>
            </svg>
            <span>CONNEXION</span>
        </a>
    </div>
</header>

<main class="container">
