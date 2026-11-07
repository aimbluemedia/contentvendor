<?php
/** /auth/toutify/{login|callback|initiate|logout|backchannel-logout|webhook} — $action is set by index.php */

function toutify_fail(string $message, int $code = 400): void
{
    http_response_code($code);
    render('auth_error', ['title' => 'Sign-in problem', 'message' => $message]);
    exit;
}

switch ($action) {
    case 'login':
        // PKCE S256 + state + nonce are kept in the PHP session (lifetime raised to 2 h in bootstrap.php)
        try {
            $oidc = toutify_client();
            if (!empty($_GET['signup'])) {
                $oidc->addAuthParam(['prompt' => 'create']);
            }
            $_SESSION['toutify_login_started'] = time();
            $oidc->authenticate(); // redirects to Toutify and exits
        } catch (Throwable $e) {
            error_log('Toutify login start failed: ' . $e->getMessage());
            toutify_fail('We couldn\'t reach Toutify to sign you in. Please try again in a minute.', 502);
        }
        break;

    case 'callback':
        if (isset($_GET['error'])) {
            toutify_fail('Sign-in was cancelled or refused by Toutify.');
        }
        $expected = (string) ($_SESSION['openid_connect_state'] ?? '');
        if ($expected === '' || !hash_equals($expected, (string) ($_GET['state'] ?? '')) || empty($_GET['code'])) {
            toutify_fail('Your sign-in link has expired or was already used. Please log in again.');
        }
        try {
            $oidc = toutify_client();
            $oidc->authenticate(); // code exchange with PKCE verifier; checks state, nonce, signature, iss, aud, exp
            $claims = json_decode(json_encode($oidc->getVerifiedClaims()), true);
            $info = json_decode(json_encode($oidc->requestUserInfo()), true);
        } catch (Throwable $e) {
            error_log('Toutify callback failed: ' . $e->getMessage());
            toutify_fail('We couldn\'t complete your sign-in with Toutify. Please try again.');
        }
        if (empty($claims['sub']) || ($info['sub'] ?? null) !== $claims['sub']) {
            toutify_fail('Toutify returned mismatched account details. Please try again.');
        }
        $member = array_merge($claims, $info);
        if (($member['account_status'] ?? '') !== 'active') {
            toutify_fail('Your Toutify account is ' . ($member['account_status'] ?? 'not active') . '. Please contact Toutify support.', 403);
        }
        try {
            $user = toutify_upsert_member($member);
            toutify_start_session($user, (string) $oidc->getIdToken(), isset($claims['sid']) ? (string) $claims['sid'] : null);
        } catch (Throwable $e) {
            error_log('Toutify member save failed: ' . $e->getMessage());
            toutify_fail('We signed you in on Toutify but couldn\'t open your ContentVendor account. Please try again.', 500);
        }
        unset($_SESSION['toutify_login_started']);
        redirect(home_path_for($user));

    case 'initiate':
        if ((string) ($_GET['iss'] ?? '') !== toutify_issuer()) {
            http_response_code(400);
            exit('Bad request');
        }
        redirect('auth/toutify/login');

    case 'logout':
        $idToken = $_SESSION['toutify']['id_token'] ?? null;
        toutify_install();
        q('DELETE FROM toutify_sessions WHERE session_id = ?', [session_id()]);
        logout_user();
        session_destroy();
        try {
            $end = toutify_discovery()['end_session_endpoint'] ?? '';
        } catch (Throwable $e) {
            $end = '';
        }
        if ($end === '') {
            redirect('');
        }
        $params = ['post_logout_redirect_uri' => site_url(''), 'state' => bin2hex(random_bytes(16))];
        if ($idToken) {
            $params['id_token_hint'] = $idToken;
        } else {
            $params['client_id'] = toutify_client_id();
        }
        header('Location: ' . $end . (strpos($end, '?') === false ? '?' : '&') . http_build_query($params));
        exit;

    case 'backchannel-logout':
        header('Cache-Control: no-store');
        if (!is_post()) { http_response_code(405); exit; }
        try {
            $c = toutify_verify_logout_token((string) ($_POST['logout_token'] ?? ''));
        } catch (Throwable $e) {
            error_log('Toutify back-channel logout rejected: ' . $e->getMessage());
            http_response_code(400);
            exit;
        }
        $sub = (string) ($c['sub'] ?? '');
        $sid = isset($c['sid']) ? (string) $c['sid'] : null;
        if ($sub === '' && $sid !== null) {
            toutify_install();
            q('DELETE FROM toutify_sessions WHERE sid = ?', [$sid]);
        } elseif ($sub !== '') {
            toutify_end_sessions($sub, $sid);
        }
        http_response_code(200);
        exit;

    case 'webhook':
        header('Content-Type: application/json');
        if (!is_post()) { http_response_code(405); exit('{}'); }
        $raw = (string) file_get_contents('php://input');
        if (!toutify_verify_webhook($raw, (string) ($_SERVER['HTTP_TOUTIFY_SIGNATURE'] ?? ''))) {
            http_response_code(400);
            exit('{"error":"invalid signature"}');
        }
        $body = json_decode($raw, true);
        if (!is_array($body)) {
            http_response_code(400);
            exit('{"error":"invalid body"}');
        }
        $status = toutify_handle_webhook($body);
        http_response_code($status);
        exit($status === 200 ? '{"ok":true}' : '{"error":"failed"}');

    default:
        not_found();
}
