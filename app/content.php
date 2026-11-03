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
