<?php
/**
 * Members sign in with Toutify (see app/toutify.php). ContentVendor never
 * stores or asks for passwords. A PHP session counts as signed in only while
 * its toutify_sessions row exists and the member is active on Toutify, so
 * back-channel logouts and suspensions take effect on the next request.
 */

function current_user(): ?array
{
    static $user = false;
    if ($user === false) {
        $user = null;
        if (!empty($_SESSION['uid'])) {
            $row = q('SELECT * FROM users WHERE id = ?', [$_SESSION['uid']])->fetch() ?: null;
            if ($row && toutify_session_valid($row)) {
                $user = $row;
            } else {
                logout_user();
            }
        }
    }
    return $user;
}

/** Where a signed-in member lands: the main admin goes to /superadmin, everyone else to /members */
function home_path_for(array $user): string
{
    return $user['role'] === 'admin' ? 'superadmin' : 'members';
}

/** Logged-out visitors on /members or /superadmin see a "Log in with Toutify" card on that page */
function login_card(bool $adminOnly = false): void
{
    render('auth_login', [
        'title'   => $adminOnly ? 'Super admin login' : 'Member login',
        'heading' => $adminOnly ? 'Super admin login' : 'Member login',
        'intro'   => $adminOnly ? 'Sign in with the Toutify account set as ContentVendor admin.' : 'Sign in with your Toutify account to open your ContentVendor workspace.',
        'signup'  => !$adminOnly,
    ]);
    exit;
}

/** Require a signed-in member. With $here, show the login card on that page instead of redirecting. */
function require_login(?string $here = null): array
{
    $user = current_user();
    if (!$user) {
        if ($here !== null) {
            login_card();
        }
        flash('info', 'Please log in to continue.');
        redirect('members');
    }
    return $user;
}

function require_admin(?string $here = null): array
{
    if (!current_user() && $here !== null) {
        login_card(true);
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
