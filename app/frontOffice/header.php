<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? escape($pageTitle) . ' - Le Monde' : 'Le Monde - Actualités en direct' ?></title>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* Skip link for keyboard accessibility */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 0;
            background: #1a1a1a;
            color: white;
            padding: 8px 16px;
            z-index: 100;
            text-decoration: none;
            font-weight: 600;
        }
        .skip-link:focus {
            top: 0;
        }
    </style>
</head>
<body>

<!-- Skip to main content link -->
<a href="#main-content" class="skip-link">Aller au contenu principal</a>

<header class="site-header">
    <div class="header-container">
        <div class="site-title">
            <a href="/">Le Monde</a>
        </div>
        <nav class="main-nav" aria-label="Navigation principale">
            <a href="/">À la une</a>
            <a href="#">International</a>
            <a href="#">Politique</a>
            <a href="#">Économie</a>
            <a href="#">Culture</a>
        </nav>
        <a href="/login" class="login-btn" title="Connexion / Inscription" aria-label="Accéder à la page de connexion">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="8" r="4"/>
                <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                <line x1="19" y1="3" x2="19" y2="7"/>
                <line x1="17" y1="5" x2="21" y2="5"/>
            </svg>
            Connexion
        </a>
    </div>
</header>

<main id="main-content" class="container">
