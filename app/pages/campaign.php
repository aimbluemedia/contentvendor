<?php
$user = require_login();
$id = (int) ($_GET['id'] ?? 0);
$campaign = q('SELECT * FROM campaigns WHERE id = ? AND user_id = ?', [$id, $user['id']])->fetch();
if (!$campaign) not_found();

if (is_post()) {
    csrf_check();
    if (post('action') === 'approve_all') {
        q("UPDATE content_items SET status = 'approved', updated_at = ? WHERE campaign_id = ? AND user_id = ? AND status = 'draft'", [now(), $id, $user['id']]);
        flash('success', 'All drafts approved. Schedule or copy them from the library.');
    }
    redirect('campaign?id=' . $id);
}

$items = q('SELECT * FROM content_items WHERE campaign_id = ? AND user_id = ? ORDER BY id', [$id, $user['id']])->fetchAll();
render('campaign', ['title' => 'Campaign', 'user' => $user, 'campaign' => $campaign, 'items' => $items]);
