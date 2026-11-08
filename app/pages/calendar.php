<?php
$user = require_login();
$m = (string) ($_GET['m'] ?? date('Y-m'));
if (!preg_match('/^\d{4}-\d{2}$/', $m)) $m = date('Y-m');
$first = strtotime($m . '-01');
$next = strtotime('+1 month', $first);
$items = q(
    'SELECT * FROM content_items WHERE user_id = ? AND scheduled_at IS NOT NULL AND scheduled_at >= ? AND scheduled_at < ? ORDER BY scheduled_at',
    [$user['id'], date('Y-m-d 00:00:00', $first), date('Y-m-d 00:00:00', $next)]
)->fetchAll();
$byDay = [];
foreach ($items as $it) {
    $byDay[(int) date('j', strtotime($it['scheduled_at']))][] = $it;
}
// Planned posts from the member's content plan
$tasksByDay = [];
$activePlan = active_plan((int) $user['id']);
if ($activePlan) {
    $tasks = q('SELECT * FROM plan_tasks WHERE plan_id = ? AND due_date >= ? AND due_date < ? ORDER BY due_date, id',
        [$activePlan['id'], date('Y-m-d', $first), date('Y-m-d', $next)])->fetchAll();
    foreach ($tasks as $t) $tasksByDay[(int) date('j', strtotime($t['due_date']))][] = $t;
}
render('calendar', ['title' => 'Content calendar', 'user' => $user, 'first' => $first, 'byDay' => $byDay, 'tasksByDay' => $tasksByDay, 'plan' => plan_of($user)]);
