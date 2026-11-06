<?php
$user = require_login();
$uid = (int) $user['id'];
$profile = business_profile($uid);
$plan = active_plan($uid);
$errors = [];

if (is_post()) {
    csrf_check();
    $action = post('action');
    if ($action === 'create') {
        try {
            $n = create_content_plan($user, $profile, (array) ($_POST['platforms'] ?? []), (int) post('minutes'), (array) ($_POST['days'] ?? []));
            flash('success', "Your content plan is ready: {$n} simple tasks over the next 4 weeks. Start with today's tasks below.");
            redirect('planner');
        } catch (InvalidArgumentException $ex) {
            $errors[] = $ex->getMessage();
        }
    } elseif ($action === 'task') {
        $task = find_task($uid, (int) post('task_id'));
        if ($task && in_array(post('status'), ['done', 'skipped', 'todo'], true)) {
            complete_task($uid, (int) $task['id'], post('status'));
            if (post('status') === 'done') flash('success', 'Nice work. Task done!');
        }
        redirect(post('back') === 'members' ? 'members' : 'planner');
    }
}

$editing = !$plan || isset($_GET['edit']) || $errors;
$today = date('Y-m-d');
$weekStart = date('Y-m-d', strtotime('monday this week'));
$weekEnd = date('Y-m-d', strtotime('sunday this week'));
$data = ['title' => 'My content plan', 'user' => $user, 'profile' => $profile, 'plan' => $plan, 'errors' => $errors, 'editing' => $editing];
if (!$editing) {
    $week = tasks_between($uid, $weekStart, $weekEnd);
    $data['weekDone'] = count(array_filter($week, fn($t) => $t['status'] === 'done'));
    $data['weekTotal'] = count($week);
    $data['todayTasks'] = array_values(array_filter(tasks_between($uid, $today, $today), fn($t) => true));
    $data['overdue'] = array_values(array_filter(tasks_between($uid, date('Y-m-d', strtotime('-3 days')), date('Y-m-d', strtotime('-1 day'))), fn($t) => $t['status'] === 'todo'));
    $data['upcoming'] = tasks_between($uid, date('Y-m-d', strtotime('+1 day')), date('Y-m-d', strtotime('+7 days')));
    $data['monthTasks'] = count(tasks_between($uid, $today, date('Y-m-d', strtotime('+27 days'))));
}
render('planner', $data);
