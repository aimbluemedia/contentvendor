<?php
if ($me = current_user()) redirect(home_path_for($me));
$errors = [];
if (is_post()) {
    csrf_check();
    $email = strtolower(post('email'));
    $password = $_POST['password'] ?? '';
    $user = q('SELECT * FROM users WHERE email = ?', [$email])->fetch();
    if ($user && is_string($password) && password_verify($password, $user['password_hash'])) {
        if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
            q('UPDATE users SET password_hash = ? WHERE id = ?', [password_hash($password, PASSWORD_DEFAULT), $user['id']]);
        }
        login_user((int) $user['id']);
        redirect(home_path_for($user));
    }
    usleep(300000);
    $errors[] = 'That email and password don\'t match.';
}
render('auth_login', ['title' => 'Log in', 'errors' => $errors]);
