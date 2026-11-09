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
    } elseif ($action === 'write_one' || $action === 'write_month') {
        // Premium: AI monthly planner writes drafts for upcoming tasks
        $ajax = $action === 'write_one';
        $fail = function (string $msg) use ($ajax) {
            if ($ajax) { header('Content-Type: application/json'); echo json_encode(['ok' => false, 'error' => $msg]); exit; }
            flash('error', $msg); redirect('planner');
        };
        if ($user['plan'] !== 'premium') $fail('The AI monthly planner is included with Premium.');
        if (!profile_is_complete($profile)) $fail('Finish your business profile first so the AI can write about your business.');
        @set_time_limit(300);
        $pending = month_pending_tasks($uid);
        $batch = $ajax ? array_slice($pending, 0, 1) : array_slice($pending, 0, 3);
        $written = 0;
        try {
            foreach ($batch as $t) { write_task_draft($user, $profile, $t); $written++; }
        } catch (AiException $ex) {
            $fail($ex->getMessage());
        }
        $left = count($pending) - $written;
        if ($ajax) { header('Content-Type: application/json'); echo json_encode(['ok' => true, 'written' => $written, 'left' => $left]); exit; }
        flash('success', $left ? "{$written} drafts written. {$left} to go." : 'Your month is written. Review and approve your drafts.');
        redirect('planner');
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
    $data['monthTasks'] = count(tasks_between($uid, $today, date('Y-m-d', strtotime('+27 days'))));
    $data['monthPending'] = count(month_pending_tasks($uid));
    $data['monthCampaign'] = q("SELECT id FROM campaigns WHERE user_id = ? AND goal = 'plan' ORDER BY id DESC LIMIT 1", [$uid])->fetchColumn() ?: null;
}
render('planner', $data);
