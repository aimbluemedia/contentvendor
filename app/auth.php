<?php

function current_user(): ?array
{
    static $user = false;
    if ($user === false) {
        $user = null;
        if (!empty($_SESSION['uid'])) {
            $user = q('SELECT * FROM users WHERE id = ?', [$_SESSION['uid']])->fetch() ?: null;
        }
    }
    return $user;
}

function require_login(): array
{
    $user = current_user();
    if (!$user) {
        flash('info', 'Please log in to continue.');
        redirect('login');
    }
    return $user;
}

function require_admin(): array
{
    $user = require_login();
    if ($user['role'] !== 'admin') {
        not_found();
    }
    return $user;
}

function login_user(int $id): void
{
    session_regenerate_id(true);
    $_SESSION['uid'] = $id;
}

function logout_user(): void
{
    $_SESSION = [];
    session_regenerate_id(true);
}

function register_user(string $name, string $email, string $password): int
{
    $role = strcasecmp($email, (string) config('admin_email', '')) === 0 ? 'admin' : 'member';
    q(
        'INSERT INTO users (name, email, password_hash, role, plan, created_at) VALUES (?, ?, ?, ?, ?, ?)',
        [$name, strtolower($email), password_hash($password, PASSWORD_DEFAULT), $role, 'starter', now()]
    );
    $id = (int) db()->lastInsertId();
    q('INSERT INTO business_profiles (user_id, updated_at) VALUES (?, ?)', [$id, now()]);
    return $id;
}
