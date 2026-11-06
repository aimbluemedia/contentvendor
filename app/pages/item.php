<?php
$user = require_login();
$uid = (int) $user['id'];
$plan = plan_of($user);
$item = find_item($uid, (int) ($_GET['id'] ?? 0));
if (!$item) not_found();
$id = (int) $item['id'];

// Free tier: every draft is downloadable
if (isset($_GET['download'])) {
    $name = preg_replace('/[^a-z0-9]+/i', '-', strtolower($item['title'] ?: channel_label($item['channel']))) ?: 'content';
    header('Content-Type: text/plain; charset=utf-8');
    header('Content-Disposition: attachment; filename="' . trim($name, '-') . '.txt"');
    echo ($item['title'] !== '' ? $item['title'] . "\r\n\r\n" : '') . str_replace("\n", "\r\n", $item['body']);
    exit;
}

$errors = [];
if (is_post()) {
    csrf_check();
    $action = post('action');
    switch ($action) {
        case 'save':
            $body = post('body');
            if ($body === '') { $errors[] = 'The content can\'t be empty.'; break; }
            q('UPDATE content_items SET title = ?, body = ?, updated_at = ? WHERE id = ? AND user_id = ?', [mb_substr(post('title'), 0, 255), $body, now(), $id, $uid]);
            flash('success', 'Changes saved.');
            redirect('item?id=' . $id);
        case 'approve':
            q("UPDATE content_items SET status = 'approved', updated_at = ? WHERE id = ? AND user_id = ?", [now(), $id, $uid]);
            flash('success', 'Approved.');
            redirect('item?id=' . $id);
        case 'draft':
            q("UPDATE content_items SET status = 'draft', scheduled_at = NULL, updated_at = ? WHERE id = ? AND user_id = ?", [now(), $id, $uid]);
            flash('info', 'Moved back to drafts.');
            redirect('item?id=' . $id);
        case 'published':
            q("UPDATE content_items SET status = 'published', updated_at = ? WHERE id = ? AND user_id = ?", [now(), $id, $uid]);
            flash('success', 'Marked as published. Nice work staying active!');
            redirect('item?id=' . $id);
        case 'schedule':
            if (!$plan['scheduling']) { $errors[] = 'Scheduling is included with Pro and Premium.'; break; }
            $when = strtotime(post('scheduled_at'));
            if (!$when || $when < time() - 60) { $errors[] = 'Pick a date and time in the future.'; break; }
            $alreadyThisMonth = $item['scheduled_at'] !== null;
            if (!$alreadyThisMonth && scheduled_this_month($uid) >= $plan['scheduled_posts']) {
                $errors[] = "You've reached your {$plan['scheduled_posts']} scheduled posts for this month.";
                break;
            }
            q("UPDATE content_items SET status = 'scheduled', scheduled_at = ?, updated_at = ? WHERE id = ? AND user_id = ?", [date('Y-m-d H:i:s', $when), now(), $id, $uid]);
            flash('success', 'Scheduled for ' . date('D M j, g:ia', $when) . '. It appears on your calendar.');
            redirect('item?id=' . $id);
        case 'repurpose':
            if (!$plan['scheduling']) { $errors[] = 'Turning content into social posts is included with Pro and Premium.'; break; }
            $channels = array_values(array_intersect(allowed_channels($user), (array) ($_POST['channels'] ?? [])));
            $channels = array_values(array_diff($channels, [$item['channel']]));
            if (!$channels) { $errors[] = 'Choose at least one destination.'; break; }
            if (count($channels) > generations_left($user)) { $errors[] = 'Not enough AI generations left this month for that many destinations.'; break; }
            try {
                $profile = business_profile($uid);
                $result = generate_campaign($profile, 'active', $item['title'] . "\n\n" . $item['body'], $channels, true);
                foreach ($result['items'] as $new) {
                    save_item($uid, $item['campaign_id'] !== null ? (int) $item['campaign_id'] : null, $new['channel'], $new['title'], $new['body'], $result['source']);
                }
                record_usage($uid, count($result['items']));
                flash('success', count($result['items']) . ' new draft(s) created from this content.');
                redirect($item['campaign_id'] ? 'campaign?id=' . $item['campaign_id'] : 'library');
            } catch (AiException $ex) {
                $errors[] = $ex->getMessage();
            }
            break;
        case 'delete':
            q('DELETE FROM content_items WHERE id = ? AND user_id = ?', [$id, $uid]);
            flash('info', 'Deleted.');
            redirect('library');
    }
    $item = find_item($uid, $id);
}
render('item', ['title' => channel_label($item['channel']), 'user' => $user, 'plan' => $plan, 'item' => $item, 'errors' => $errors]);
