<?php
$admin = require_admin('superadmin');
if (is_post()) {
    csrf_check();
    if (post('action') === 'plan' && isset(PLANS[post('plan')])) {
        q('UPDATE users SET plan = ? WHERE id = ?', [post('plan'), (int) post('user_id')]);
        flash('success', 'Plan updated.');
    }
    if (post('action') === 'refresh_websites') {
        try {
            [$sites, $owners] = toutify_refresh_all_websites();
            flash('success', "Refreshed {$sites} website(s) for {$owners} member(s) from Toutify.");
        } catch (Throwable $e) {
            error_log('Toutify websites refresh failed: ' . $e->getMessage());
            flash('error', 'Could not refresh websites from Toutify. Check the client secret and try again.');
        }
    }
    if (post('action') === 'request' && in_array(post('status'), ['new', 'contacted', 'active', 'closed'], true)) {
        q('UPDATE service_requests SET status = ? WHERE id = ?', [post('status'), (int) post('request_id')]);
        flash('success', 'Request updated.');
    }
    $v = (string) ($_GET['view'] ?? '');
    redirect('superadmin' . (in_array($v, ['members', 'requests'], true) ? '?view=' . $v : ''));
}
$users = q(
    "SELECT u.id, u.name, u.email, u.plan, u.role, u.created_at, p.business_name,
            (SELECT COUNT(*) FROM content_items i WHERE i.user_id = u.id) AS items,
            (SELECT COALESCE(SUM(quantity), 0) FROM usage_log l WHERE l.user_id = u.id AND l.created_at >= ?) AS used
     FROM users u LEFT JOIN business_profiles p ON p.user_id = u.id ORDER BY u.created_at DESC LIMIT 500",
    [month_start()]
)->fetchAll();
$requests = q('SELECT * FROM service_requests ORDER BY created_at DESC LIMIT 200')->fetchAll();
$planCounts = array_fill_keys(array_keys(PLANS), 0);
foreach ($users as $u) { $planCounts[$u['plan']] = ($planCounts[$u['plan']] ?? 0) + 1; }
$view = in_array($_GET['view'] ?? '', ['members', 'requests'], true) ? $_GET['view'] : 'overview';
$newCount = count(array_filter($requests, fn($r) => $r['status'] === 'new'));
render('admin', ['tab' => $view, 'newCount' => $newCount, 'title' => ['overview' => 'Super admin', 'members' => 'Members', 'requests' => 'Done-for-you requests'][$view], 'user' => $admin, 'users' => $users, 'requests' => $requests, 'planCounts' => $planCounts]);
