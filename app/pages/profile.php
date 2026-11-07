<?php
$user = require_login();
$profile = business_profile((int) $user['id']);
// Name, email, business name and phone come from Toutify (read-only here)
$fields = ['industry', 'services', 'location', 'service_areas', 'website', 'specialties', 'description', 'brand_voice', 'audience'];
$errors = [];
if (is_post()) {
    csrf_check();
    $data = [];
    foreach ($fields as $f) {
        $data[$f] = mb_substr(post($f), 0, $f === 'description' || $f === 'services' || $f === 'service_areas' || $f === 'specialties' ? 4000 : 255);
    }
    if ($data['website'] !== '' && !preg_match('~^https?://~i', $data['website'])) $data['website'] = 'https://' . $data['website'];
    if (!$errors) {
        $set = implode(', ', array_map(fn($f) => "$f = ?", $fields));
        q("UPDATE business_profiles SET $set, updated_at = ? WHERE user_id = ?", [...array_values($data), now(), $user['id']]);
        flash('success', 'Business profile saved. Every ContentVendor tool will use it.');
        redirect(isset($_GET['next']) && $_GET['next'] === 'create' ? 'create' : 'members');
    }
    $profile = array_merge($profile, $data);
}
render('profile', ['title' => 'Business profile', 'user' => $user, 'profile' => $profile, 'errors' => $errors]);
