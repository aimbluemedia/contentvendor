<?php
$admin = require_admin();
if (is_post()) {
    csrf_check();
    if (post('action') === 'plan' && isset(PLANS[post('plan')])) {
        q('UPDATE users SET plan = ? WHERE id = ?', [post('plan'), (int) post('user_id')]);
        flash('success', 'Plan updated.');
    }
    if (post('action') === 'request' && in_array(post('status'), ['new', 'contacted', 'active', 'closed'], true)) {
        q('UPDATE service_requests SET status = ? WHERE id = ?', [post('status'), (int) post('request_id')]);
        flash('success', 'Request updated.');
    }
    redirect('superadmin');
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
render('admin', ['title' => 'Super admin', 'user' => $admin, 'users' => $users, 'requests' => $requests, 'planCounts' => $planCounts]);
