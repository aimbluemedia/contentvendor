<?php
$user = require_login();
$profile = business_profile((int) $user['id']);
$recent = q('SELECT * FROM content_items WHERE user_id = ? ORDER BY updated_at DESC LIMIT 6', [$user['id']])->fetchAll();
$upcoming = q("SELECT * FROM content_items WHERE user_id = ? AND status = 'scheduled' AND scheduled_at >= ? ORDER BY scheduled_at ASC LIMIT 5", [$user['id'], now()])->fetchAll();
render('dashboard', [
    'title'    => 'Dashboard',
    'user'     => $user,
    'profile'  => $profile,
    'counts'   => status_counts((int) $user['id']),
    'used'     => generations_used((int) $user['id']),
    'recent'   => $recent,
    'upcoming' => $upcoming,
]);
