<?php
require '../config/db.php';
require '../config/utils.php';
require '../config/auth.php';

ensure_session_started();

if (is_logged_in()) {
    $next = $_GET['next'] ?? '/?page=dashboard';
    header('Location: ' . $next);
    exit;
}

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $next = $_POST['next'] ?? '/?page=dashboard';

    if ($username === '' || $password === '') {
        $error = "Nom d'utilisateur et mot de passe requis.";
    } else {
        $stmt = $pdo->prepare('SELECT id, username, password FROM users WHERE username = :username LIMIT 1');
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            login_user($user);
            header('Location: ' . $next);
            exit;
        }

        $error = "Identifiants invalides.";
    }
}

$next = $_GET['next'] ?? '/?page=dashboard';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connexion au backoffice - Le Monde">
    <title>Connexion - Backoffice</title>
    <link rel="stylesheet" href="/css/backoffice.css">
    <style>
        /* Skip link for accessibility */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 0;
            background: #1a1a1a;
            color: white;
            padding: 8px;
            z-index: 100;
            text-decoration: none;
        }
        .skip-link:focus {
            top: 0;
        }
    </style>
</head>
<body>

<!-- Skip to main content link for accessibility -->
<a href="#main-content" class="skip-link">Aller au contenu principal</a>

<main id="main-content">
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <header class="login-header">
                <h1 class="logo-title">Le Monde</h1>
                <span class="logo-subtitle">Administration</span>
            </header>

            <!-- Error Message -->
            <?php if ($error): ?>
                <div class="login-error" role="alert" aria-live="polite">
                    <?= escape($error) ?>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" action="/?page=login" class="login-form">
                <input type="hidden" name="next" value="<?= escape($next) ?>">

                <div class="login-form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        value="admin"
                        required 
                        autofocus
                        autocomplete="username"
                        aria-label="Nom d'utilisateur"
                    >
                </div>

                <div class="login-form-group">
                    <label for="password">Mot de passe</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        value="admin123"
                        required
                        autocomplete="current-password"
                        aria-label="Mot de passe"
                    >
                </div>

                <button type="submit" class="login-submit">Se connecter</button>
            </form>
        </div>
    </div>
</main>

</body>
</html>
