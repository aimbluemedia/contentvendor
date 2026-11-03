<?php
$user = require_login();
render('account', [
    'title' => 'My plan', 'user' => $user, 'plan' => plan_of($user),
    'used' => generations_used((int) $user['id']),
    'scheduled' => scheduled_this_month((int) $user['id']),
]);
