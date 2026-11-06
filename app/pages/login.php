<?php
if ($me = current_user()) redirect(home_path_for($me));
$errors = [];
if (is_post()) {
    csrf_check();
    $user = attempt_login(post('email'), $_POST['password'] ?? '');
    if ($user) {
        login_user((int) $user['id']);
        redirect(home_path_for($user));
    }
    $errors[] = 'That email and password don\'t match.';
}
render('auth_login', ['title' => 'Log in', 'errors' => $errors]);
