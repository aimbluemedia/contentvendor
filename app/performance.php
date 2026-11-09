<?php
/** Performance dashboard numbers and Premium content recycling (no outside services). */

function recycle_install(): void
{
    static $done = false;
    if ($done) return;
    $done = true;
    $sqlite = db()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite';
    $id = $sqlite ? 'INTEGER PRIMARY KEY AUTOINCREMENT' : 'INT UNSIGNED AUTO_INCREMENT PRIMARY KEY';
    $tail = $sqlite ? '' : ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
    db()->exec("CREATE TABLE IF NOT EXISTS recycle_log (id $id, user_id INT NOT NULL, item_id INT NOT NULL, new_item_id INT NOT NULL, created_at DATETIME NOT NULL)$tail");
}

/** Published posts at least 45 days old that haven't been recycled in the last 90 days */
function recycle_candidates(array $user, int $limit = 5): array
{
    recycle_install();
    $uid = (int) $user['id'];
    $rows = q("SELECT c.* FROM content_items c WHERE c.user_id = ? AND c.status = 'published' AND c.updated_at <= ?
        AND NOT EXISTS (SELECT 1 FROM recycle_log r WHERE r.item_id = c.id AND r.created_at >= ?)
        ORDER BY c.updated_at ASC LIMIT 50", [$uid, date('Y-m-d H:i:s', strtotime('-45 days')), date('Y-m-d H:i:s', strtotime('-90 days'))])->fetchAll();
    $allowed = allowed_channels($user);
    return array_slice(array_values(array_filter($rows, fn($r) => in_array($r['channel'], $allowed, true))), 0, $limit);
}

function last_recycle_at(int $userId): ?string
{
    recycle_install();
    return q('SELECT MAX(created_at) FROM recycle_log WHERE user_id = ?', [$userId])->fetchColumn() ?: null;
}

function recycled_count(int $userId, string $since): int
{
    recycle_install();
    return (int) q('SELECT COUNT(*) FROM recycle_log WHERE user_id = ? AND created_at >= ?', [$userId, $since])->fetchColumn();
}

/** Refresh up to $max old posts into new drafts. Returns how many were created. */
function recycle_now(array $user, int $max = 2): int
{
    if ($user['plan'] !== 'premium') return 0;
    $uid = (int) $user['id'];
    $profile = business_profile($uid);
    $made = 0;
    foreach (recycle_candidates($user, $max) as $old) {
        if (generations_left($user) < 1) break;
        $idea = "Refresh this post we published before. Keep the same facts and offer, but write a new hook and new wording so it doesn't look copied:\n\n"
            . $old['title'] . "\n\n" . $old['body'];
        $res = generate_campaign($profile, 'active', $idea, [$old['channel']], true);
        $new = $res['items'][0] ?? null;
        if (!$new) continue;
        $cid = q("SELECT id FROM campaigns WHERE user_id = ? AND goal = 'recycle' ORDER BY id DESC LIMIT 1", [$uid])->fetchColumn();
        if (!$cid) {
            q('INSERT INTO campaigns (user_id, goal, idea, created_at) VALUES (?, ?, ?, ?)', [$uid, 'recycle', 'Recycled content: your best posts, refreshed', now()]);
            $cid = db()->lastInsertId();
        }
        $newId = save_item($uid, (int) $cid, $new['channel'], $new['title'], $new['body'], $res['source']);
        q('INSERT INTO recycle_log (user_id, item_id, new_item_id, created_at) VALUES (?, ?, ?, ?)', [$uid, $old['id'], $newId, now()]);
        record_usage($uid, 1);
        $made++;
    }
    return $made;
}

/** Automatic recycling: runs at most once a week per Premium member. */
function recycle_due(array $user): bool
{
    if ($user['plan'] !== 'premium') return false;
    $last = last_recycle_at((int) $user['id']);
    return (!$last || strtotime($last) < strtotime('-7 days')) && recycle_candidates($user, 1);
}

/** Numbers for the performance dashboard */
function performance_stats(array $user, int $weeks = 8): array
{
    $uid = (int) $user['id'];
    planner_install();
    $monthStart = date('Y-m-01 00:00:00');
    $s = [];
    $s['published_month'] = (int) q("SELECT COUNT(*) FROM content_items WHERE user_id = ? AND status = 'published' AND updated_at >= ?", [$uid, $monthStart])->fetchColumn();
    $s['published_total'] = (int) q("SELECT COUNT(*) FROM content_items WHERE user_id = ? AND status = 'published'", [$uid])->fetchColumn();
    $s['created_month'] = (int) q('SELECT COUNT(*) FROM content_items WHERE user_id = ? AND created_at >= ?', [$uid, $monthStart])->fetchColumn();
    $s['scheduled'] = (int) q("SELECT COUNT(*) FROM content_items WHERE user_id = ? AND status = 'scheduled' AND scheduled_at >= ?", [$uid, now()])->fetchColumn();
    $s['ready'] = (int) q("SELECT COUNT(*) FROM content_items WHERE user_id = ? AND status IN ('draft','approved')", [$uid])->fetchColumn();

    // Plan consistency over the last 28 days (done / due)
    $from = date('Y-m-d', strtotime('-27 days'));
    $due = q("SELECT status, COUNT(*) n FROM plan_tasks WHERE user_id = ? AND due_date BETWEEN ? AND ? GROUP BY status", [$uid, $from, date('Y-m-d')])->fetchAll();
    $byStatus = array_column($due, 'n', 'status');
    $s['tasks_due'] = (int) array_sum($byStatus);
    $s['tasks_done'] = (int) ($byStatus['done'] ?? 0);
    $s['consistency'] = $s['tasks_due'] ? (int) round($s['tasks_done'] / $s['tasks_due'] * 100) : null;

    // Streak: consecutive days (back from today/yesterday) with a done task or a published post
    $days = [];
    foreach (q("SELECT completed_at d FROM plan_tasks WHERE user_id = ? AND status = 'done' AND completed_at >= ?", [$uid, date('Y-m-d', strtotime('-120 days'))])->fetchAll() as $r) $days[substr($r['d'], 0, 10)] = true;
    foreach (q("SELECT updated_at d FROM content_items WHERE user_id = ? AND status = 'published' AND updated_at >= ?", [$uid, date('Y-m-d', strtotime('-120 days'))])->fetchAll() as $r) $days[substr($r['d'], 0, 10)] = true;
    $streak = 0;
    $d = isset($days[date('Y-m-d')]) ? time() : strtotime('-1 day');
    while (isset($days[date('Y-m-d', $d)])) { $streak++; $d = strtotime('-1 day', $d); }
    $s['streak'] = $streak;

    // Weekly activity (published posts + finished tasks), oldest first
    $s['weeks'] = [];
    $start = strtotime('monday this week', strtotime('-' . ($weeks - 1) . ' weeks'));
    for ($i = 0; $i < $weeks; $i++) {
        $a = date('Y-m-d 00:00:00', strtotime("+$i weeks", $start));
        $b = date('Y-m-d 00:00:00', strtotime('+' . ($i + 1) . ' weeks', $start));
        $pub = (int) q("SELECT COUNT(*) FROM content_items WHERE user_id = ? AND status = 'published' AND updated_at >= ? AND updated_at < ?", [$uid, $a, $b])->fetchColumn();
        $done = (int) q("SELECT COUNT(*) FROM plan_tasks WHERE user_id = ? AND status = 'done' AND completed_at >= ? AND completed_at < ?", [$uid, $a, $b])->fetchColumn();
        $s['weeks'][] = ['label' => date('M j', strtotime($a)), 'n' => max($pub, $done)];
    }

    // Channel mix (last 90 days, published)
    $s['channels'] = q("SELECT channel, COUNT(*) n, MAX(updated_at) last FROM content_items WHERE user_id = ? AND status = 'published' AND updated_at >= ? GROUP BY channel ORDER BY n DESC",
        [$uid, date('Y-m-d H:i:s', strtotime('-90 days'))])->fetchAll();

    // Best weekday for finished tasks / published posts
    $dow = array_fill(1, 7, 0);
    foreach (array_keys($days) as $day) $dow[(int) date('N', strtotime($day))]++;
    arsort($dow);
    $s['best_day'] = reset($dow) > 0 ? WEEKDAYS[key($dow)] : null;
    return $s;
}

/** Plain-language tips for Premium */
function performance_tips(array $user, array $s): array
{
    $tips = [];
    if ($s['consistency'] !== null && $s['consistency'] < 60) $tips[] = 'You finished ' . $s['consistency'] . '% of your plan tasks in the last 4 weeks. Try a smaller daily time in your plan so it\'s easier to keep up.';
    if ($s['ready'] >= 5) $tips[] = 'You have ' . $s['ready'] . ' drafts waiting. Approve and post them before writing new ones.';
    $active = array_column($s['channels'], 'last', 'channel');
    foreach (enabled_platforms($user) as $p) {
        $ch = SOCIAL_PLATFORMS[$p][4];
        if (!isset($active[$ch]) || strtotime($active[$ch]) < strtotime('-14 days')) {
            $tips[] = 'You haven\'t posted on ' . SOCIAL_PLATFORMS[$p][0] . ' in over two weeks. A quick post keeps that profile active.';
            break;
        }
    }
    if ($s['best_day']) $tips[] = $s['best_day'] . ' is your most active day. Plan your most important posts for it.';
    if (!$tips) $tips[] = 'Great consistency. Keep following your daily plan and your visibility will keep building.';
    return array_slice($tips, 0, 4);
}
