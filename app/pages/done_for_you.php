<?php
$errors = [];
$user = current_user();
if (is_post()) {
    csrf_check();
    $package = post('package');
    $name = post('name');
    $email = post('email');
    if (!isset(PACKAGES[$package])) $errors[] = 'Choose a package.';
    if ($name === '') $errors[] = 'Enter your name.';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Enter a valid email address.';
    if (!$errors) {
        q(
            'INSERT INTO service_requests (user_id, package, name, email, phone, business, message, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
            [$user['id'] ?? null, $package, $name, $email, post('phone'), post('business'), post('message'), 'new', now()]
        );
        flash('success', 'Thanks! Your free trial is reserved. A content strategist will contact you within one business day to get started.');
        redirect('done-for-you');
    }
}
render('done_for_you', ['title' => 'Done-for-You Content', 'errors' => $errors, 'user' => $user, 'selected' => $_GET['package'] ?? 'growth']);
