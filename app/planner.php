<?php
/**
 * AI Content Plan Creator + daily tasks.
 * A member picks platforms, how much time they have and which days they work;
 * we build 4 weeks of small daily tasks, each linked to the right AI tool.
 */

/** Platforms offered in the plan creator => [label, CHANNELS key used by the Campaign Builder, minutes per task] */
const PLAN_PLATFORMS = [
    'facebook'        => ['Facebook', 'facebook', 10],
    'instagram'       => ['Instagram', 'instagram', 10],
    'google_business' => ['Google Business', 'google_business', 5],
    'tiktok'          => ['TikTok', 'video_script', 15],
    'youtube'         => ['YouTube Shorts', 'video_script', 15],
    'pinterest'       => ['Pinterest', 'pinterest', 5],
    'reddit'          => ['Reddit', 'reddit', 10],
    'article'         => ['Website blog', 'article', 20],
    'email'           => ['Email', 'email', 10],
];

/** Daily time budget => [label, description, tasks per working day] */
const PLAN_EFFORT = [
    5  => ['5 minutes a day', 'One quick post on most days', 1],
    15 => ['15 minutes a day', 'One solid post every working day', 1],
    30 => ['30 minutes a day', 'Two posts a day on your best channels', 2],
    60 => ['An hour a day', 'Three pieces a day, maximum visibility', 3],
];

const WEEKDAYS = [1 => 'Mon', 2 => 'Tue', 3 => 'Wed', 4 => 'Thu', 5 => 'Fri', 6 => 'Sat', 7 => 'Sun'];

function planner_install(): void
{
    static $done = false;
    if ($done) return;
    $done = true;
    $sqlite = db()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite';
    $id = $sqlite ? 'INTEGER PRIMARY KEY AUTOINCREMENT' : 'INT UNSIGNED AUTO_INCREMENT PRIMARY KEY';
    $tail = $sqlite ? '' : ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
    db()->exec("CREATE TABLE IF NOT EXISTS content_plans (
        id $id, user_id INT NOT NULL, platforms VARCHAR(255) NOT NULL, minutes INT NOT NULL,
        days VARCHAR(20) NOT NULL, active TINYINT NOT NULL DEFAULT 1, created_at DATETIME NOT NULL)$tail");
    db()->exec("CREATE TABLE IF NOT EXISTS plan_tasks (
        id $id, plan_id INT NOT NULL, user_id INT NOT NULL, due_date DATE NOT NULL, platform VARCHAR(40) NOT NULL,
        goal VARCHAR(40) NOT NULL, idea TEXT NOT NULL, status VARCHAR(20) NOT NULL DEFAULT 'todo',
        item_id INT NULL, completed_at DATETIME NULL)$tail");
}

function active_plan(int $userId): ?array
{
    planner_install();
    return q('SELECT * FROM content_plans WHERE user_id = ? AND active = 1 ORDER BY id DESC LIMIT 1', [$userId])->fetch() ?: null;
}

function find_task(int $userId, int $taskId): ?array
{
    planner_install();
    return q('SELECT * FROM plan_tasks WHERE id = ? AND user_id = ?', [$taskId, $userId])->fetch() ?: null;
}

function tasks_between(int $userId, string $from, string $to): array
{
    planner_install();
    return q(
        "SELECT t.* FROM plan_tasks t JOIN content_plans p ON p.id = t.plan_id AND p.active = 1
         WHERE t.user_id = ? AND t.due_date >= ? AND t.due_date <= ? ORDER BY t.due_date, t.id",
        [$userId, $from, $to]
    )->fetchAll();
}

function complete_task(int $userId, int $taskId, string $status = 'done', ?int $itemId = null): void
{
    planner_install();
    q('UPDATE plan_tasks SET status = ?, item_id = COALESCE(?, item_id), completed_at = ? WHERE id = ? AND user_id = ?',
        [$status, $itemId, $status === 'todo' ? null : now(), $taskId, $userId]);
}

/** Create (or replace) the member's plan and 4 weeks of tasks. Returns the number of tasks. */
function create_content_plan(array $user, array $profile, array $platforms, int $minutes, array $days): int
{
    planner_install();
    $uid = (int) $user['id'];
    $platforms = array_values(array_intersect(planner_allowed_platforms($user), $platforms));
    $days = array_values(array_intersect(array_keys(WEEKDAYS), array_map('intval', $days)));
    if (!$platforms || !$days || !isset(PLAN_EFFORT[$minutes])) {
        throw new InvalidArgumentException('Choose at least one platform, a time budget and one day.');
    }

    // Retire the old plan and its open tasks
    $old = active_plan($uid);
    if ($old) {
        q("DELETE FROM plan_tasks WHERE plan_id = ? AND status = 'todo' AND due_date >= ?", [$old['id'], date('Y-m-d')]);
        q('UPDATE content_plans SET active = 0 WHERE id = ?', [$old['id']]);
    }

    // Build the schedule: 28 days from today
    $perDay = PLAN_EFFORT[$minutes][2];
    $slots = [];
    $rotation = $platforms;
    $r = 0;
    $weekly = ['article' => [], 'email' => []]; // at most one article and one email per week
    for ($d = 0; $d < 28; $d++) {
        $ts = strtotime("+$d day");
        $dow = (int) date('N', $ts);
        if (!in_array($dow, $days, true)) continue;
        if ($minutes === 5 && count($days) > 3 && $d % 2 === 1) continue; // 5 min/day: roughly every other working day
        $week = (int) floor($d / 7);
        for ($n = 0; $n < $perDay; $n++) {
            for ($tries = 0; $tries < count($rotation); $tries++) {
                $p = $rotation[$r++ % count($rotation)];
                if (isset($weekly[$p]) && in_array($week, $weekly[$p], true)) continue;
                if (isset($weekly[$p])) $weekly[$p][] = $week;
                $slots[] = [date('Y-m-d', $ts), $p];
                break;
            }
        }
    }

    $ideas = plan_ideas($profile, count($slots));
    q('INSERT INTO content_plans (user_id, platforms, minutes, days, active, created_at) VALUES (?, ?, ?, ?, 1, ?)',
        [$uid, implode(',', $platforms), $minutes, implode(',', $days), now()]);
    $planId = (int) db()->lastInsertId();
    foreach ($slots as $i => [$date, $platform]) {
        [$goal, $idea] = $ideas[$i % max(1, count($ideas))];
        q('INSERT INTO plan_tasks (plan_id, user_id, due_date, platform, goal, idea, status) VALUES (?, ?, ?, ?, ?, ?, ?)',
            [$planId, $uid, $date, $platform, $goal, $idea, 'todo']);
    }
    return count($slots);
}

/** Post ideas for the plan: from Claude when configured, otherwise from templates. Returns [[goal, idea], ...] */
function plan_ideas(array $profile, int $count): array
{
    $count = max(1, min($count, 90));
    if (ai_enabled()) {
        try {
            $ideas = claude_plan_ideas($profile, $count);
            if (count($ideas) >= min($count, 10)) return $ideas;
        } catch (Throwable $e) {
            error_log('ContentVendor plan ideas fell back to templates: ' . $e->getMessage());
        }
    }
    return template_plan_ideas($profile, $count);
}

function template_plan_ideas(array $p, int $count): array
{
    $services = array_values(array_filter(array_map('trim', preg_split('/[,\n]+/', (string) $p['services']))));
    if (!$services) $services = ['your services'];
    $area = $p['location'] ?: 'your area';
    $month = date('F');
    $t = [
        ['special', 'Promote a limited-time offer on %s'],
        ['job',     'Share a before-and-after photo of a recent %s job'],
        ['calls',   'Answer a question customers often ask about %s, and invite them to call'],
        ['active',  'Share a quick ' . $month . ' tip about %s'],
        ['service', 'Explain why customers in ' . $area . ' choose you for %s'],
        ['job',     'Introduce a team member and the %s work they do best'],
        ['calls',   'List 3 signs someone needs %s, with a call to action'],
        ['active',  'Bust a common myth about %s'],
        ['special', 'Remind people your %s schedule is filling up, and to book early'],
        ['service', 'Share a happy customer story about %s (with their permission)'],
    ];
    $out = [];
    for ($i = 0; $i < $count; $i++) {
        [$goal, $tpl] = $t[$i % count($t)];
        $out[] = [$goal, sprintf($tpl, lcfirst($services[$i % count($services)]))];
    }
    return $out;
}

function claude_plan_ideas(array $profile, int $count): array
{
    $schema = [
        'type' => 'object',
        'properties' => ['ideas' => ['type' => 'array', 'items' => [
            'type' => 'object',
            'properties' => ['goal' => ['type' => 'string', 'enum' => array_keys(GOALS)], 'idea' => ['type' => 'string']],
            'required' => ['goal', 'idea'], 'additionalProperties' => false,
        ]]],
        'required' => ['ideas'], 'additionalProperties' => false,
    ];
    $user = "<business_profile>\n" . profile_brief($profile) . "</business_profile>\n\n"
        . "Write {$count} short, specific social media post ideas for this business for the next 4 weeks (it is " . date('F Y') . "). "
        . "Mix the goals (special offers, completed jobs, getting calls, new or featured services, staying active with tips). "
        . "Each idea is one sentence a busy owner can act on, under 18 words, with no hashtags and no invented prices or discounts.";
    $res = claude_request([
        'model' => config('anthropic.model', 'claude-opus-5-5'),
        'max_tokens' => 8000,
        'system' => claude_system_prompt(),
        'messages' => [['role' => 'user', 'content' => $user]],
        'output_config' => ['effort' => 'low', 'format' => ['type' => 'json_schema', 'schema' => $schema]],
    ], ['Content-Type: application/json', 'x-api-key: ' . config('anthropic.api_key'), 'anthropic-version: 2026-10-21']);
    if (($res['stop_reason'] ?? '') === 'refusal') return [];
    $text = '';
    foreach ($res['content'] ?? [] as $b) if (($b['type'] ?? '') === 'text') $text .= $b['text'];
    $data = json_decode($text, true);
    $out = [];
    foreach ($data['ideas'] ?? [] as $row) {
        if (isset(GOALS[$row['goal'] ?? '']) && trim((string) ($row['idea'] ?? '')) !== '') {
            $out[] = [$row['goal'], mb_substr(trim($row['idea']), 0, 240)];
        }
    }
    return $out;
}

/** Planner platforms the member may pick: content (blog, Google) + switched-on social platforms */
function planner_allowed_platforms(array $user): array
{
    $allowed = ['google_business', 'article'];
    foreach (enabled_platforms($user) as $p) {
        if (isset(PLAN_PLATFORMS[$p])) $allowed[] = $p;
    }
    return array_values(array_intersect(array_keys(PLAN_PLATFORMS), $allowed));
}

function platform_label(string $key): string
{
    return PLAN_PLATFORMS[$key][0] ?? ucfirst($key);
}

function platform_channel(string $key): string
{
    return PLAN_PLATFORMS[$key][1] ?? 'facebook';
}

/** Dashboard setup steps a member must finish before posting: [key => done?] */
function setup_steps(array $user, ?array $profile = null): array
{
    platforms_install();
    $profile = $profile ?? business_profile((int) $user['id']);
    return [
        'profile'   => profile_is_complete($profile),
        'platforms' => (bool) q('SELECT 1 FROM member_platforms WHERE user_id = ?', [$user['id']])->fetchColumn(),
        'plan'      => active_plan((int) $user['id']) !== null,
    ];
}

function setup_complete(array $user): bool
{
    return !in_array(false, setup_steps($user), true);
}

/** The member's next day with open tasks (today or later): [date, tasks] or null */
function next_task_day(int $userId): ?array
{
    planner_install();
    $date = q("SELECT MIN(due_date) FROM plan_tasks t JOIN content_plans p ON p.id = t.plan_id AND p.active = 1
        WHERE t.user_id = ? AND t.status = 'todo' AND t.due_date >= ?", [$userId, date('Y-m-d')])->fetchColumn();
    if (!$date) return null;
    $tasks = q("SELECT t.* FROM plan_tasks t JOIN content_plans p ON p.id = t.plan_id AND p.active = 1
        WHERE t.user_id = ? AND t.status = 'todo' AND t.due_date = ? ORDER BY t.id", [$userId, $date])->fetchAll();
    return [$date, $tasks];
}

/** Premium monthly planner: open tasks in the next 30 days that don't have a draft yet */
function month_pending_tasks(int $userId): array
{
    planner_install();
    return q("SELECT t.* FROM plan_tasks t JOIN content_plans p ON p.id = t.plan_id AND p.active = 1
        WHERE t.user_id = ? AND t.status = 'todo' AND t.item_id IS NULL AND t.due_date >= ? AND t.due_date <= ?
        ORDER BY t.due_date, t.id", [$userId, date('Y-m-d', strtotime('-3 days')), date('Y-m-d', strtotime('+30 days'))])->fetchAll();
}

/** The campaign that groups this month's planner drafts (created on first use) */
function month_campaign_id(int $userId): int
{
    $label = 'Monthly content plan · ' . date('F Y');
    $id = q("SELECT id FROM campaigns WHERE user_id = ? AND goal = 'plan' AND idea = ? ORDER BY id DESC LIMIT 1", [$userId, $label])->fetchColumn();
    if ($id) return (int) $id;
    q('INSERT INTO campaigns (user_id, goal, idea, created_at) VALUES (?, ?, ?, ?)', [$userId, 'plan', $label, now()]);
    return (int) db()->lastInsertId();
}

/** Write the draft for one planner task and link it. Returns the new item id. */
function write_task_draft(array $user, array $profile, array $task): int
{
    $uid = (int) $user['id'];
    if (generations_left($user) < 1) {
        throw new AiException("You've used this month's AI drafts. They reset on the 1st.");
    }
    $channel = platform_channel($task['platform']);
    if (!in_array($channel, allowed_channels($user), true)) {
        $channel = 'facebook';
    }
    $result = generate_campaign($profile, isset(GOALS[$task['goal']]) ? $task['goal'] : 'active', $task['idea'], [$channel]);
    $draft = $result['items'][0] ?? null;
    if (!$draft) throw new AiException('The AI did not return a draft. Please try again.');
    $itemId = save_item($uid, month_campaign_id($uid), $draft['channel'], $draft['title'], $draft['body'], $result['source']);
    q('UPDATE plan_tasks SET item_id = ? WHERE id = ? AND user_id = ?', [$itemId, $task['id'], $uid]);
    record_usage($uid, 1);
    return $itemId;
}
