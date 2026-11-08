<?php
$user = require_login('posting-guide');
$plan = active_plan((int) $user['id']);
render('guide', [
    'title' => 'Posting guide',
    'user'  => $user,
    'mine'  => $plan ? array_filter(explode(',', (string) $plan['platforms'])) : [],
]);
