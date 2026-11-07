<?php
$user = require_login('members');
$profile = business_profile((int) $user['id']);
render('dashboard', [
    'title'   => 'Dashboard',
    'user'    => $user,
    'profile' => $profile,
    'steps'   => setup_steps($user, $profile),
]);
