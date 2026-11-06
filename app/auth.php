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

/** Where a signed-in user lands: the main admin goes to /superadmin, everyone else to /members */
function home_path_for(array $user): string
{
    return $user['role'] === 'admin' ? 'superadmin' : 'members';
}

/** Check an email and password; returns the user on success (and upgrades old hashes) */
function attempt_login(string $email, $password): ?array
{
    $user = q('SELECT * FROM users WHERE email = ?', [strtolower(trim($email))])->fetch();
    if ($user && is_string($password) && password_verify($password, $user['password_hash'])) {
        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            q('UPDATE users SET password_hash = ? WHERE id = ?', [password_hash($password, PASSWORD_DEFAULT), $user['id']]);
        }
        return $user;
    }
    usleep(300000); // slow down password guessing
    return null;
}

/**
 * Show a login form in place on $here (e.g. /members) instead of redirecting
 * to /login. After a successful login the visitor stays on $here; a non-admin
 * signing in on an admin-only page is sent to /members.
 */
function login_gate(string $here, bool $adminOnly = false): void
{
    $errors = [];
    if (is_post() && post('_gate') === 'login') {
        csrf_check();
        $user = attempt_login(post('email'), $_POST['password'] ?? '');
        if ($user) {
            login_user((int) $user['id']);
            redirect($adminOnly && $user['role'] !== 'admin' ? 'members' : $here);
        }
        $errors[] = 'That email and password don\'t match.';
    }
    render('auth_login', [
        'title'   => $adminOnly ? 'Super admin login' : 'Member login',
        'heading' => $adminOnly ? 'Super admin login' : 'Member login',
        'intro'   => $adminOnly ? 'Sign in with the ContentVendor admin account.' : 'Sign in to your ContentVendor workspace.',
        'action'  => url($here),
        'gate'    => true,
        'signup'  => !$adminOnly,
        'errors'  => $errors,
    ]);
    exit;
}

/** Require a signed-in user. With $here, show the login form on that page instead of redirecting. */
function require_login(?string $here = null): array
{
    $user = current_user();
    if (!$user) {
        if ($here !== null) {
            login_gate($here);
        }
        flash('info', 'Please log in to continue.');
        redirect('login');
    }
    return $user;
}

function require_admin(?string $here = null): array
{
    $user = current_user();
    if (!$user && $here !== null) {
        login_gate($here, true);
    }
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
