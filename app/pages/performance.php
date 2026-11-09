<?php
$user = require_login('performance');
if (is_post()) {
    csrf_check();
    $auto = post('action') === 'auto_recycle';
    $made = 0; $err = null;
    if ($user['plan'] === 'premium' && (!$auto || recycle_due($user))) {
        @set_time_limit(180);
        try { $made = recycle_now($user, 2); } catch (AiException $ex) { $err = $ex->getMessage(); }
    }
    if ($auto) { header('Content-Type: application/json'); echo json_encode(['made' => $made]); exit; }
    if ($err) flash('error', $err);
    elseif ($made) flash('success', "{$made} of your older posts were refreshed into new drafts. Review them below.");
    else flash('info', 'Nothing to recycle yet. Posts become eligible 45 days after you publish them.');
    redirect('performance');
}
$tier = $user['plan'];
render('performance', [
    'title' => 'Performance',
    'user'  => $user,
    'tier'  => $tier,
    's'     => performance_stats($user, $tier === 'premium' ? 12 : 8),
]);
