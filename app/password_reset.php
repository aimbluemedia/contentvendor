<?php
/**
 * Password reset: single-use, hashed tokens that expire after 1 hour,
 * emailed with PHP mail() (works on Hostinger when mail_from is an address
 * on your own domain).
 */

function resets_install(): void
{
    static $done = false;
    if ($done) return;
    $done = true;
    $sqlite = db()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite';
    $id = $sqlite ? 'INTEGER PRIMARY KEY AUTOINCREMENT' : 'INT UNSIGNED AUTO_INCREMENT PRIMARY KEY';
    $tail = $sqlite ? '' : ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
    db()->exec("CREATE TABLE IF NOT EXISTS password_resets (
        id $id, user_id INT NOT NULL, token_hash CHAR(64) NOT NULL, expires_at DATETIME NOT NULL,
        used_at DATETIME NULL, created_at DATETIME NOT NULL)$tail");
}

/** Absolute site URL for links in emails */
function absolute_url(string $path): string
{
    $base = rtrim((string) config('app_url', ''), '/');
    if ($base === '' || strpos($base, 'example.com') !== false) {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        $base = ($https ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . base_path();
    }
    return $base . '/' . ltrim($path, '/');
}

function send_mail(string $to, string $subject, string $body): bool
{
    $from = (string) config('mail_from', '');
    if ($from === '') {
        $host = preg_replace('/^www\./', '', (string) parse_url(absolute_url(''), PHP_URL_HOST));
        $from = 'no-reply@' . ($host ?: 'localhost');
    }
    $name = (string) config('mail_from_name', 'ContentVendor');
    $headers = [
        'From: ' . mb_encode_mimeheader($name) . ' <' . $from . '>',
        'Reply-To: ' . $from,
        'MIME-Version: 1.0',
        'Content-Type: text/plain; charset=UTF-8',
        'Content-Transfer-Encoding: 8bit',
    ];
    $ok = @mail($to, mb_encode_mimeheader($subject), $body, implode("\r\n", $headers), '-f' . $from);
    if (!$ok) {
        error_log('ContentVendor: could not send email to ' . $to . ' (' . $subject . ')');
    }
    return $ok;
}

/** Create a reset link for an email address (silently does nothing if no account). Returns the link or null. */
function start_password_reset(string $email): ?string
{
    resets_install();
    $user = q('SELECT * FROM users WHERE email = ?', [strtolower(trim($email))])->fetch();
    if (!$user) {
        usleep(250000);
        return null;
    }
    // Only the newest link works
    q('UPDATE password_resets SET used_at = ? WHERE user_id = ? AND used_at IS NULL', [now(), $user['id']]);
    $token = bin2hex(random_bytes(32));
    q('INSERT INTO password_resets (user_id, token_hash, expires_at, created_at) VALUES (?, ?, ?, ?)',
        [$user['id'], hash('sha256', $token), date('Y-m-d H:i:s', time() + 3600), now()]);
    $link = absolute_url('reset?token=' . $token);
    $first = trim(strtok((string) $user['name'], ' ')) ?: 'there';
    send_mail($user['email'], 'Reset your ContentVendor password', "Hi {$first},\n\n"
        . "We received a request to reset your ContentVendor password. Use this link to choose a new one:\n\n{$link}\n\n"
        . "The link works once and expires in 1 hour. If you didn't ask for this, you can ignore this email and your password stays the same.\n\n"
        . "— The ContentVendor team");
    return $link;
}

/** Find a valid (unused, unexpired) reset row for a token */
function find_password_reset(string $token): ?array
{
    resets_install();
    if (!preg_match('/^[a-f0-9]{64}$/', $token)) return null;
    $row = q('SELECT * FROM password_resets WHERE token_hash = ? AND used_at IS NULL AND expires_at > ?', [hash('sha256', $token), now()])->fetch();
    return $row ?: null;
}

function finish_password_reset(array $reset, string $password): int
{
    q('UPDATE users SET password_hash = ? WHERE id = ?', [password_hash($password, PASSWORD_DEFAULT), $reset['user_id']]);
    q('UPDATE password_resets SET used_at = ? WHERE user_id = ? AND used_at IS NULL', [now(), $reset['user_id']]);
    return (int) $reset['user_id'];
}
