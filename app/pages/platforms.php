<?php
$user = require_login();
if (is_post()) {
    csrf_check();
    try {
        save_platforms($user, (array) ($_POST['platforms'] ?? []));
        flash('success', 'Your platforms are saved. Your tools now create content for them.');
        if (!setup_complete($user)) redirect('members'); // back to the setup cards for the next step
    } catch (InvalidArgumentException $ex) {
        flash('error', $ex->getMessage());
    }
    redirect('platforms');
}
render('platforms', ['title' => 'My platforms', 'user' => $user, 'enabled' => enabled_platforms($user), 'limit' => platform_limit($user)]);
