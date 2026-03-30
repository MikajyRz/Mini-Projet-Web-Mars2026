<?php

function ensure_session_started() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function is_logged_in(): bool {
    ensure_session_started();
    return !empty($_SESSION['user_id']);
}

function require_login(): void {
    if (!is_logged_in()) {
        $next = $_SERVER['REQUEST_URI'] ?? '/?page=dashboard';
        header('Location: /?page=login&next=' . urlencode($next));
        exit;
    }
}

function login_user(array $user): void {
    ensure_session_started();
    $_SESSION['user_id'] = $user['id'] ?? null;
    $_SESSION['username'] = $user['username'] ?? null;
}

function logout_user(): void {
    ensure_session_started();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
