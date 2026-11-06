<?php

function business_profile(int $userId): array
{
    $p = q('SELECT * FROM business_profiles WHERE user_id = ?', [$userId])->fetch();
    if (!$p) {
        q('INSERT INTO business_profiles (user_id, updated_at) VALUES (?, ?)', [$userId, now()]);
        $p = q('SELECT * FROM business_profiles WHERE user_id = ?', [$userId])->fetch();
    }
    return $p;
}

function profile_is_complete(array $p): bool
{
    return $p['business_name'] !== '' && trim((string) $p['services']) !== '' && $p['location'] !== '';
}

function generations_used(int $userId): int
{
    return (int) q(
        "SELECT COALESCE(SUM(quantity), 0) FROM usage_log WHERE user_id = ? AND kind = 'generation' AND created_at >= ?",
        [$userId, month_start()]
    )->fetchColumn();
}

function generations_left(array $user): int
{
    return max(0, plan_of($user)['generations'] - generations_used((int) $user['id']));
}

function record_usage(int $userId, int $quantity, string $kind = 'generation'): void
{
    q('INSERT INTO usage_log (user_id, kind, quantity, created_at) VALUES (?, ?, ?, ?)', [$userId, $kind, $quantity, now()]);
}

function scheduled_this_month(int $userId): int
{
    return (int) q(
        "SELECT COUNT(*) FROM content_items WHERE user_id = ? AND scheduled_at IS NOT NULL AND scheduled_at >= ? AND scheduled_at < ?",
        [$userId, month_start(), date('Y-m-01 00:00:00', strtotime('first day of next month'))]
    )->fetchColumn();
}

function status_counts(int $userId): array
{
    $counts = ['draft' => 0, 'approved' => 0, 'scheduled' => 0, 'published' => 0];
    foreach (q('SELECT status, COUNT(*) AS n FROM content_items WHERE user_id = ? GROUP BY status', [$userId]) as $row) {
        $counts[$row['status']] = (int) $row['n'];
    }
    return $counts;
}

function find_item(int $userId, int $id): ?array
{
    return q('SELECT * FROM content_items WHERE id = ? AND user_id = ?', [$id, $userId])->fetch() ?: null;
}

function save_item(int $userId, ?int $campaignId, string $channel, string $title, string $body, string $source): int
{
    q(
        'INSERT INTO content_items (user_id, campaign_id, channel, title, body, status, source, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [$userId, $campaignId, $channel, mb_substr($title, 0, 255), $body, 'draft', $source, now(), now()]
    );
    return (int) db()->lastInsertId();
}

function channel_label(string $channel): string
{
    return CHANNELS[$channel]['label'] ?? ucfirst(str_replace('_', ' ', $channel));
}

function channel_icon(string $channel): string
{
    return CHANNELS[$channel]['icon'] ?? '•';
}

const STATUS_LABELS = [
    'draft' => 'Draft', 'approved' => 'Approved', 'scheduled' => 'Scheduled', 'published' => 'Published',
];

/* ---------- Member platform switches ---------- */

function platforms_install(): void
{
    static $done = false;
    if ($done) return;
    $done = true;
    $tail = db()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite' ? '' : ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
    db()->exec("CREATE TABLE IF NOT EXISTS member_platforms (user_id INT NOT NULL PRIMARY KEY, platforms VARCHAR(255) NOT NULL, updated_at DATETIME NOT NULL)$tail");
}

/** How many social platforms the member's plan allows */
function platform_limit(array $user): int
{
    return (int) (plan_of($user)['social_platforms'] ?? 1);
}

/** Social platforms the member has switched on (trimmed to their plan's limit) */
function enabled_platforms(array $user): array
{
    platforms_install();
    $limit = platform_limit($user);
    $row = q('SELECT platforms FROM member_platforms WHERE user_id = ?', [$user['id']])->fetch();
    if ($row) {
        $list = array_values(array_intersect(explode(',', (string) $row['platforms']), array_keys(SOCIAL_PLATFORMS)));
    } else {
        $list = $limit >= count(SOCIAL_PLATFORMS) ? array_keys(SOCIAL_PLATFORMS) : array_slice(['facebook', 'instagram', 'tiktok'], 0, $limit);
    }
    return array_slice($list, 0, $limit);
}

function save_platforms(array $user, array $platforms): void
{
    platforms_install();
    $platforms = array_values(array_intersect(array_keys(SOCIAL_PLATFORMS), $platforms));
    if (count($platforms) > platform_limit($user)) {
        throw new InvalidArgumentException('Your plan allows ' . platform_limit($user) . ' social platform' . (platform_limit($user) === 1 ? '' : 's') . '. Upgrade to switch on more.');
    }
    $exists = q('SELECT user_id FROM member_platforms WHERE user_id = ?', [$user['id']])->fetch();
    if ($exists) {
        q('UPDATE member_platforms SET platforms = ?, updated_at = ? WHERE user_id = ?', [implode(',', $platforms), now(), $user['id']]);
    } else {
        q('INSERT INTO member_platforms (user_id, platforms, updated_at) VALUES (?, ?, ?)', [$user['id'], implode(',', $platforms), now()]);
    }
}

/** Campaign Builder channels the member can use: content posts + their switched-on social platforms */
function allowed_channels(array $user): array
{
    $allowed = CONTENT_CHANNELS;
    foreach (enabled_platforms($user) as $p) {
        $allowed[] = SOCIAL_PLATFORMS[$p][4];
    }
    return array_values(array_intersect(array_keys(CHANNELS), array_unique($allowed)));
}
