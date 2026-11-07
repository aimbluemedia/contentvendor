<?php
$token = (string) ($_POST['token'] ?? $_GET['token'] ?? '');
$reset = find_password_reset($token);
$errors = [];
if ($reset && is_post()) {
    csrf_check();
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['password_confirm'] ?? '';
    if (!is_string($password) || strlen($password) < 8) {
        $errors[] = 'Use a password with at least 8 characters.';
    } elseif ($password !== $confirm) {
        $errors[] = 'The two passwords don\'t match.';
    } else {
        $uid = finish_password_reset($reset, $password);
        login_user($uid);
        $user = q('SELECT * FROM users WHERE id = ?', [$uid])->fetch();
        flash('success', 'Your password has been updated and you\'re signed in.');
        redirect(home_path_for($user));
    }
}
render('auth_reset', ['title' => 'Choose a new password', 'token' => $token, 'valid' => (bool) $reset, 'errors' => $errors]);
