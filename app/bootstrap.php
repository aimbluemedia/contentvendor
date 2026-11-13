<?php
declare(strict_types=1);

define('ROOT', dirname(__DIR__));

$configFile = ROOT . '/config/config.php';
if (!is_file($configFile)) {
    http_response_code(500);
    exit('ContentVendor is not configured yet. Copy config/config.sample.php to config/config.php and fill in your database details.');
}
$GLOBALS['config'] = require $configFile;

if (!empty($GLOBALS['config']['debug'])) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', '0');
}
date_default_timezone_set($GLOBALS['config']['timezone'] ?? 'America/New_York');

// Sign-in (state, nonce, PKCE verifier) must survive a slow Toutify sign-up: keep sessions for 2 hours
ini_set('session.gc_maxlifetime', '7200');

session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'httponly' => true,
    'samesite' => 'Lax',
]);
session_name('cv_session');
session_start();

require ROOT . '/vendor/autoload.php';
require ROOT . '/app/helpers.php';
require ROOT . '/app/plans.php';
require ROOT . '/app/auth.php';
require ROOT . '/app/content.php';
require ROOT . '/app/ai.php';
require ROOT . '/app/planner.php';
require ROOT . '/app/guide.php';
require ROOT . '/app/prompts.php';
require ROOT . '/app/performance.php';
require ROOT . '/app/legal.php';
require ROOT . '/app/toutify.php';
