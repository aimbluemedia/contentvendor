<?php
if ($me = current_user()) redirect(home_path_for($me));
$sent = false;
$errors = [];
$devLink = null;
if (is_post()) {
    csrf_check();
    $email = post('email');
    // Per-session limit: 5 requests per 15 minutes
    $now = time();
    $_SESSION['resets'] = array_values(array_filter($_SESSION['resets'] ?? [], fn($t) => $t > $now - 900));
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Enter the email address you signed up with.';
    } elseif (count($_SESSION['resets']) >= 5) {
        $errors[] = 'Too many reset requests. Please wait a few minutes and try again.';
    } else {
        $_SESSION['resets'][] = $now;
        $link = start_password_reset($email);
        if ($link && config('debug')) $devLink = $link; // local testing only
        $sent = true;
    }
}
render('auth_forgot', ['title' => 'Reset your password', 'sent' => $sent, 'errors' => $errors, 'devLink' => $devLink]);
