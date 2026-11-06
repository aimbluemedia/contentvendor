<?php
/**
 * ContentVendor front controller. Every request that isn't a real file
 * (see .htaccess) is routed here.
 */
require __DIR__ . '/app/bootstrap.php';

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$base = base_path();
if ($base !== '' && strpos($path, $base) === 0) {
    $path = substr($path, strlen($base));
}
$path = trim($path, '/');
if ($path === 'index.php') {
    $path = '';
}

$routes = [
    ''             => 'home',
    'pricing'      => 'pricing',
    'done-for-you' => 'done_for_you',
    'register'     => 'register',
    'login'        => 'login',
    'logout'       => 'logout',
    'members'      => 'dashboard',
    'planner'      => 'planner',
    'platforms'    => 'platforms',
    'profile'      => 'profile',
    'create'       => 'create',
    'campaign'     => 'campaign',
    'library'      => 'library',
    'item'         => 'item',
    'calendar'     => 'calendar',
    'account'      => 'account',
    'superadmin'   => 'admin',
    'scan'         => 'scan',
];

// Old addresses keep working
$legacy = ['dashboard' => 'members', 'admin' => 'superadmin'];
if (isset($legacy[$path])) {
    header('Location: ' . url($legacy[$path]), true, 301);
    exit;
}

if (!isset($routes[$path])) {
    not_found();
}

try {
    require ROOT . '/app/pages/' . $routes[$path] . '.php';
} catch (PDOException $ex) {
    error_log('ContentVendor DB error: ' . $ex->getMessage());
    http_response_code(500);
    exit(config('debug') ? 'Database error: ' . e($ex->getMessage()) : 'Something went wrong. Please try again shortly.');
}
