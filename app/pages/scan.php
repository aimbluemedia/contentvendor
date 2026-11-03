<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
if (!is_post()) {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method not allowed']);
    exit;
}
$token = $_POST['_csrf'] ?? '';
if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
    http_response_code(419);
    echo json_encode(['ok' => false, 'error' => 'Your session expired. Refresh the page and try again.']);
    exit;
}

// Simple per-session rate limit: 12 checks per hour
$now = time();
$_SESSION['scans'] = array_values(array_filter($_SESSION['scans'] ?? [], fn($t) => $t > $now - 3600));
if (count($_SESSION['scans']) >= 12) {
    http_response_code(429);
    echo json_encode(['ok' => false, 'error' => 'You\'ve checked a lot of sites. Please try again later.']);
    exit;
}
$_SESSION['scans'][] = $now;

require_once ROOT . '/app/scan.php';
try {
    $url = scan_normalize_url(post('website'));
    $_SESSION['signup_website'] = $url;
    $page = scan_fetch($url);
    echo json_encode(['ok' => true, 'site' => scan_analyze($page['url'], $page['html'])]);
} catch (ScanException $ex) {
    // Still let the calculator show a plan, just without site findings
    $domain = isset($url) ? preg_replace('/^www\./', '', (string) parse_url($url, PHP_URL_HOST)) : '';
    echo json_encode(['ok' => $domain !== '', 'site' => $domain !== '' ? ['domain' => $domain, 'unreachable' => true] : null, 'error' => $ex->getMessage()]);
}
