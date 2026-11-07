<?php
/**
 * Toutify (OpenID Connect) sign-in, back-channel logout and webhooks.
 *
 * Settings come from the environment (TOUTIFY_ISSUER, TOUTIFY_CLIENT_ID,
 * TOUTIFY_CLIENT_SECRET, TOUTIFY_WEBHOOK_SECRET) or, if not set there, from
 * the 'toutify' block in config/config.php. Never from the code.
 */

use Jumbojett\OpenIDConnectClient;

const TOUTIFY_SCOPE = 'openid profile email phone toutify';
const TOUTIFY_BCL_EVENT = 'http://schemas.openid.net/event/backchannel-logout';

function toutify_setting(string $name): string
{
    $env = getenv('TOUTIFY_' . strtoupper($name));
    if ($env !== false && $env !== '') return $env;
    return (string) config('toutify.' . strtolower($name), '');
}

function toutify_issuer(): string { return rtrim(toutify_setting('issuer') ?: 'https://toutify.com', '/'); }
function toutify_client_id(): string { return toutify_setting('client_id') ?: 'contentvendor'; }

/** Site base URL (must match the redirect URIs registered on Toutify) */
function site_url(string $path = ''): string
{
    $base = rtrim((string) config('app_url', ''), '/');
    if ($base === '' || strpos($base, 'example.com') !== false) {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        $base = ($https ? 'https://' : 'http://') . ($_SERVER['HTTP_HOST'] ?? 'localhost') . base_path();
    }
    return $base . '/' . ltrim($path, '/');
}

/* ---------- Tables ---------- */

function toutify_install(): void
{
    static $done = false;
    if ($done) return;
    $done = true;
    $sqlite = db()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite';
    $tail = $sqlite ? '' : ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
    db()->exec("CREATE TABLE IF NOT EXISTS toutify_sessions (
        session_id VARCHAR(128) NOT NULL PRIMARY KEY, sid CHAR(32) NULL, sub CHAR(26) NOT NULL, created_at DATETIME NOT NULL)$tail");
    db()->exec("CREATE TABLE IF NOT EXISTS toutify_events (
        event_id VARCHAR(40) NOT NULL PRIMARY KEY, type VARCHAR(40) NOT NULL, received_at DATETIME NOT NULL)$tail");
    try { db()->exec('CREATE INDEX idx_toutify_sessions_sid ON toutify_sessions (sid)'); } catch (PDOException $e) {}
    try { db()->exec('CREATE INDEX idx_toutify_sessions_sub ON toutify_sessions (sub)'); } catch (PDOException $e) {}
}

/* ---------- Discovery + JWKS (cached on disk for an hour) ---------- */

function toutify_http_get(string $url): array
{
    $ch = curl_init($url);
    curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_TIMEOUT => 10, CURLOPT_CONNECTTIMEOUT => 5,
        CURLOPT_HTTPHEADER => ['Accept: application/json'], CURLOPT_FOLLOWLOCATION => false]);
    $body = curl_exec($ch);
    $code = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch);
    $json = is_string($body) ? json_decode($body, true) : null;
    if ($code !== 200 || !is_array($json)) {
        throw new RuntimeException("Toutify request failed ($code): $url");
    }
    return $json;
}

function toutify_cached(string $key, callable $fetch, int $ttl = 3600): array
{
    $file = sys_get_temp_dir() . '/cv_toutify_' . md5(toutify_issuer() . $key) . '.json';
    if (is_file($file) && filemtime($file) > time() - $ttl) {
        $data = json_decode((string) file_get_contents($file), true);
        if (is_array($data)) return $data;
    }
    $data = $fetch();
    @file_put_contents($file, json_encode($data), LOCK_EX);
    return $data;
}

function toutify_discovery(): array
{
    return toutify_cached('discovery', fn() => toutify_http_get(toutify_issuer() . '/.well-known/openid-configuration'));
}

function toutify_jwks(bool $refresh = false): array
{
    $uri = toutify_discovery()['jwks_uri'] ?? '';
    if ($refresh) @unlink(sys_get_temp_dir() . '/cv_toutify_' . md5(toutify_issuer() . 'jwks') . '.json');
    return toutify_cached('jwks', fn() => toutify_http_get($uri));
}

/* ---------- OIDC client ---------- */

function toutify_client(): OpenIDConnectClient
{
    $secret = toutify_setting('client_secret');
    if ($secret === '') {
        throw new RuntimeException('TOUTIFY_CLIENT_SECRET is not set.');
    }
    $oidc = new OpenIDConnectClient(toutify_issuer(), toutify_client_id(), $secret);
    $oidc->providerConfigParam(toutify_discovery());
    $oidc->setRedirectURL(site_url('auth/toutify/callback'));
    // The library adds 'openid' itself; add the rest so the scope is exactly "openid profile email phone toutify"
    $oidc->addScope(array_values(array_diff(explode(' ', TOUTIFY_SCOPE), ['openid'])));
    $oidc->setCodeChallengeMethod('S256');
    $oidc->setTokenEndpointAuthMethodsSupported(['client_secret_basic']);
    return $oidc;
}

/* ---------- Members ---------- */

/** Map Toutify's tier claim to a ContentVendor plan key, or null to leave the plan unchanged */
function toutify_tier_to_plan(?string $tier): ?string
{
    if ($tier === null || $tier === '') return null;
    $t = strtolower(trim($tier));
    $map = array_change_key_case((array) config('toutify.tier_map', []), CASE_LOWER)
         + ['free' => 'starter', 'starter' => 'starter', 'pro' => 'pro', 'premium' => 'premium'];
    return isset($map[$t]) && isset(PLANS[$map[$t]]) ? $map[$t] : null;
}

function toutify_is_admin_sub(string $sub): bool
{
    return in_array($sub, array_map('strval', (array) config('toutify.admin_subs', [])), true);
}

/**
 * Copy Toutify fields onto the member row (and business name + phone into their profile).
 * Toutify omits empty values, so a missing business_name or phone_number means it was cleared.
 */
function toutify_apply_member(int $userId, array $m, ?int $updatedAt): void
{
    $m += ['business_name' => '', 'phone_number' => ''];
    $fields = ['name' => 'name', 'email' => 'email', 'business_name' => 'business_name', 'phone' => 'phone_number', 'toutify_status' => 'account_status'];
    $set = [];
    $vals = [];
    foreach ($fields as $col => $claim) {
        if (array_key_exists($claim, $m)) {
            $v = $m[$claim];
            if ($col === 'email') $v = strtolower((string) $v);
            $set[] = "$col = ?";
            $vals[] = $v === '' ? null : $v;
        }
    }
    if (($plan = toutify_tier_to_plan($m['tier'] ?? null)) !== null) {
        $set[] = 'plan = ?';
        $vals[] = $plan;
    }
    if ($updatedAt !== null) {
        $set[] = 'toutify_updated_at = ?';
        $vals[] = $updatedAt;
    }
    if ($set) {
        $vals[] = $userId;
        q('UPDATE users SET ' . implode(', ', $set) . ' WHERE id = ?', $vals);
    }
    // Mirror business name and phone into the business profile the AI tools read
    $mirror = [];
    if (array_key_exists('business_name', $m)) $mirror['business_name'] = (string) $m['business_name'];
    if (array_key_exists('phone_number', $m)) $mirror['phone'] = (string) $m['phone_number'];
    if ($mirror) {
        business_profile($userId);
        $cols = implode(', ', array_map(fn($c) => "$c = ?", array_keys($mirror)));
        q("UPDATE business_profiles SET $cols, updated_at = ? WHERE user_id = ?", [...array_values($mirror), now(), $userId]);
    }
}

/** Find the member for a Toutify sub, or create them. Returns the users row. */
function toutify_upsert_member(array $claims): array
{
    $sub = (string) $claims['sub'];
    $user = q('SELECT * FROM users WHERE toutify_sub = ?', [$sub])->fetch();
    if (!$user) {
        q('INSERT INTO users (toutify_sub, name, email, role, plan, toutify_status, toutify_updated_at, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)',
            [$sub, (string) ($claims['name'] ?? ''), strtolower((string) ($claims['email'] ?? '')), 'member', 'starter', 'active', 0, now()]);
        $id = (int) db()->lastInsertId();
        q('INSERT INTO business_profiles (user_id, updated_at) VALUES (?, ?)', [$id, now()]);
    } else {
        $id = (int) $user['id'];
    }
    toutify_apply_member($id, $claims, isset($claims['updated_at']) ? (int) $claims['updated_at'] : null);
    q('UPDATE users SET role = ?, deleted_at = NULL WHERE id = ?', [toutify_is_admin_sub($sub) ? 'admin' : 'member', $id]);
    return q('SELECT * FROM users WHERE id = ?', [$id])->fetch();
}

/* ---------- Sessions ---------- */

function toutify_start_session(array $user, string $idToken, ?string $sid): void
{
    toutify_install();
    login_user((int) $user['id']); // regenerates the session id
    $_SESSION['toutify'] = ['id_token' => $idToken, 'sid' => $sid, 'sub' => $user['toutify_sub']];
    q('DELETE FROM toutify_sessions WHERE session_id = ?', [session_id()]);
    q('INSERT INTO toutify_sessions (session_id, sid, sub, created_at) VALUES (?, ?, ?, ?)', [session_id(), $sid, $user['toutify_sub'], now()]);
}

/** End sessions for a member: those with this sid, or all of them when $sid is null */
function toutify_end_sessions(string $sub, ?string $sid = null): int
{
    toutify_install();
    if ($sid !== null) {
        return q('DELETE FROM toutify_sessions WHERE sub = ? AND sid = ?', [$sub, $sid])->rowCount();
    }
    return q('DELETE FROM toutify_sessions WHERE sub = ?', [$sub])->rowCount();
}

/** Is the current PHP session still a live Toutify session? */
function toutify_session_valid(array $user): bool
{
    toutify_install();
    if (($user['toutify_status'] ?? '') !== 'active' || !empty($user['deleted_at'])) return false;
    $row = q('SELECT sub FROM toutify_sessions WHERE session_id = ?', [session_id()])->fetch();
    return $row && $row['sub'] === $user['toutify_sub'];
}

/* ---------- Back-channel logout ---------- */

/** Verify a logout_token; returns its claims or throws */
function toutify_verify_logout_token(string $jwt): array
{
    \Firebase\JWT\JWT::$leeway = 60;
    $decode = function (bool $refresh) use ($jwt) {
        $keys = \Firebase\JWT\JWK::parseKeySet(toutify_jwks($refresh), 'RS256');
        $headers = new stdClass();
        $claims = \Firebase\JWT\JWT::decode($jwt, $keys, $headers);
        return [$claims, $headers];
    };
    try {
        [$claims, $headers] = $decode(false);
    } catch (\UnexpectedValueException $e) {
        [$claims, $headers] = $decode(true); // key rotation: refetch JWKS once
    }
    $c = json_decode(json_encode($claims), true);
    if (($headers->typ ?? '') !== 'logout+jwt') throw new RuntimeException('Wrong typ');
    if (($c['iss'] ?? '') !== toutify_issuer()) throw new RuntimeException('Wrong issuer');
    $aud = (array) ($c['aud'] ?? []);
    if (!in_array(toutify_client_id(), $aud, true)) throw new RuntimeException('Wrong audience');
    if (!isset($c['iat'])) throw new RuntimeException('Missing iat');
    if (!isset($c['events']) || !is_array($c['events']) || !array_key_exists(TOUTIFY_BCL_EVENT, $c['events'])) throw new RuntimeException('Missing event');
    if (array_key_exists('nonce', $c)) throw new RuntimeException('Nonce not allowed');
    if (empty($c['sub']) && empty($c['sid'])) throw new RuntimeException('Missing sub/sid');
    return $c;
}

/* ---------- Webhooks ---------- */

function toutify_verify_webhook(string $raw, string $header, ?int $now = null): bool
{
    $secret = toutify_setting('webhook_secret');
    if ($secret === '' || $header === '') return false;
    $t = null;
    $sigs = [];
    foreach (explode(',', $header) as $part) {
        [$k, $v] = array_pad(explode('=', trim($part), 2), 2, '');
        if ($k === 't') $t = $v;
        if ($k === 'v1') $sigs[] = $v;
    }
    if ($t === null || !ctype_digit($t) || !$sigs) return false;
    if (abs(($now ?? time()) - (int) $t) > 300) return false;
    $expected = hash_hmac('sha256', $t . '.' . $raw, $secret);
    foreach ($sigs as $sig) {
        if (hash_equals($expected, strtolower($sig))) return true;
    }
    return false;
}

/** Apply a webhook body. Returns HTTP status to reply with. */
function toutify_handle_webhook(array $body): int
{
    toutify_install();
    $id = (string) ($body['id'] ?? '');
    $type = (string) ($body['type'] ?? '');
    if ($id === '' || strlen($id) > 40) return 400;

    q('DELETE FROM toutify_events WHERE received_at < ?', [date('Y-m-d H:i:s', strtotime('-30 days'))]);

    $pdo = db();
    $pdo->beginTransaction();
    try {
        try {
            q('INSERT INTO toutify_events (event_id, type, received_at) VALUES (?, ?, ?)', [$id, substr($type, 0, 40), now()]);
        } catch (PDOException $dup) {
            $pdo->rollBack();
            return 200; // already processed
        }
        $m = is_array($body['member'] ?? null) ? $body['member'] : [];
        $sub = (string) ($m['sub'] ?? '');
        if (in_array($type, ['member.updated', 'member.reactivated', 'member.suspended', 'member.closed'], true) && $sub !== '') {
            $user = q('SELECT * FROM users WHERE toutify_sub = ?', [$sub])->fetch();
            if ($user) {
                $updated = isset($m['updated_at']) ? (int) $m['updated_at'] : 0;
                if ($updated >= (int) $user['toutify_updated_at']) {
                    toutify_apply_member((int) $user['id'], $m, $updated);
                }
                if (in_array($type, ['member.suspended', 'member.closed'], true)) {
                    toutify_end_sessions($sub);
                }
            }
        } elseif ($type === 'member.deleted' && $sub !== '') {
            toutify_end_sessions($sub);
            q("UPDATE users SET toutify_status = 'deleted', deleted_at = ? WHERE toutify_sub = ?", [now(), $sub]);
        }
        $pdo->commit();
        return 200;
    } catch (Throwable $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        error_log('ContentVendor Toutify webhook failed: ' . $e->getMessage());
        return 500;
    }
}
