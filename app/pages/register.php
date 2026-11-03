<?php
if (current_user()) redirect('dashboard');
$errors = [];
if (is_post()) {
    csrf_check();
    $name = post('name');
    $email = strtolower(post('email'));
    $password = $_POST['password'] ?? '';
    if ($name === '') $errors[] = 'Enter your name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (!is_string($password) || strlen($password) < 8) $errors[] = 'Use a password with at least 8 characters.';
    if (!$errors && q('SELECT id FROM users WHERE email = ?', [$email])->fetch()) {
        $errors[] = 'An account with that email already exists. Try logging in.';
    }
    if (!$errors) {
        $id = register_user($name, $email, $password);
        login_user($id);
        flash('success', 'Welcome to ContentVendor! Start by filling in your business profile — every tool uses it.');
        redirect('profile');
    }
}
render('auth_register', ['title' => 'Create your free account', 'errors' => $errors]);
