<?php
$user = require_login();
$uid = (int) $user['id'];
$plan = plan_of($user);
$profile = business_profile($uid);
$errors = [];

$goal = $_POST['goal'] ?? $_GET['goal'] ?? 'special';
$idea = is_post() ? post('idea') : trim((string) ($_GET['idea'] ?? ''));
$selected = is_post() ? (array) ($_POST['channels'] ?? []) : ($plan['campaign_channels'] >= 8 ? array_keys(CHANNELS) : ['facebook', 'instagram', 'google_business']);
$selected = array_values(array_intersect(array_keys(CHANNELS), array_map('strval', $selected)));

if (is_post()) {
    csrf_check();
    if (!profile_is_complete($profile)) {
        $errors[] = 'Add your business name, services and location to your profile first.';
    }
    if (!isset(GOALS[$goal])) $errors[] = 'Choose a goal.';
    if (mb_strlen($idea) < 8) $errors[] = 'Tell us a little more about what you want to promote.';
    if (mb_strlen($idea) > 2000) $errors[] = 'Keep your idea under 2,000 characters.';
    if (!$selected) $errors[] = 'Choose at least one destination.';
    if (count($selected) > $plan['campaign_channels']) {
        $errors[] = "Your {$plan['name']} plan builds campaigns for up to {$plan['campaign_channels']} destinations at a time. Upgrade to Pro for all 8.";
    }
    $left = generations_left($user);
    if (count($selected) > $left) {
        $errors[] = $left === 0
            ? "You've used all {$plan['generations']} AI generations for this month. They reset on the 1st, or upgrade for more."
            : "You have {$left} AI generation(s) left this month; each destination uses one. Choose fewer destinations or upgrade.";
    }

    if (!$errors) {
        try {
            $result = generate_campaign($profile, $goal, $idea, $selected);
            $pdo = db();
            $pdo->beginTransaction();
            q('INSERT INTO campaigns (user_id, goal, idea, created_at) VALUES (?, ?, ?, ?)', [$uid, $goal, $idea, now()]);
            $campaignId = (int) $pdo->lastInsertId();
            foreach ($result['items'] as $item) {
                save_item($uid, $campaignId, $item['channel'], $item['title'], $item['body'], $result['source']);
            }
            record_usage($uid, count($result['items']));
            $pdo->commit();
            if ($result['source'] === 'demo') {
                flash('info', 'Demo mode: these are template drafts. Add a Claude API key in config/config.php for fully written AI content.');
            }
            redirect('campaign?id=' . $campaignId);
        } catch (AiException $ex) {
            if (db()->inTransaction()) db()->rollBack();
            $errors[] = $ex->getMessage();
        }
    }
}

render('create', [
    'title' => 'Create a campaign', 'user' => $user, 'plan' => $plan, 'profile' => $profile,
    'errors' => $errors, 'goal' => $goal, 'idea' => $idea, 'selected' => $selected,
    'left' => generations_left($user),
]);
