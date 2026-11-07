<?php
$me = current_user();
$current = trim(substr(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', strlen(base_path())), '/');
$nav = function (string $path, string $label) use ($current) {
    $active = $current === $path ? ' class="active"' : '';
    return '<a href="' . e(url($path)) . '"' . $active . '>' . e($label) . '</a>';
};
$appRoutes = ['members', 'planner', 'platforms', 'create', 'campaign', 'library', 'item', 'calendar', 'profile', 'account', 'superadmin'];
$isApp = $me && in_array($current, $appRoutes, true);
$isSuper = $isApp && $current === 'superadmin';
$view = (string) ($_GET['view'] ?? '');
$ic = [
    'plan2'    => '<path d="M9 5h10M9 12h10M9 19h10"/><path d="M4 5l1 1 2-2M4 12l1 1 2-2M4 19l1 1 2-2"/>',
    'toggle'   => '<rect x="2" y="7" width="20" height="10" rx="5"/><circle cx="16" cy="12" r="3"/>',
    'home'     => '<path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/><path d="M10 20v-6h4v6"/>',
    'create'   => '<path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/><circle cx="12" cy="12" r="3"/>',
    'library'  => '<path d="M4 4h5v16H4zM10 4h5v16h-5z"/><path d="M16 5l4 1-3 14-4-1"/>',
    'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>',
    'profile'  => '<path d="M4 20V9l8-5 8 5v11"/><path d="M9 20v-6h6v6"/>',
    'plan'     => '<rect x="3" y="6" width="18" height="13" rx="2"/><path d="M3 10h18M7 15h4"/>',
    'shield'   => '<path d="M12 3l8 3v6c0 5-3.5 8-8 9-4.5-1-8-4-8-9V6z"/><path d="M9 12l2 2 4-4"/>',
    'chart'    => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>',
    'users'    => '<circle cx="9" cy="8" r="4"/><path d="M2 21c.8-3.5 3.6-5.5 7-5.5s6.2 2 7 5.5M16 3.5a4 4 0 0 1 0 7.5M22 21c-.5-2.6-2-4.3-4-5"/>',
    'inbox'    => '<path d="M3 13l3-8h12l3 8v6H3z"/><path d="M3 13h5l1 3h6l1-3h5"/>',
    'site'     => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c3 3.5 3 14.5 0 18M12 3c-3 3.5-3 14.5 0 18"/>',
    'back'     => '<path d="M15 6l-6 6 6 6"/>',
    'logout'   => '<path d="M15 4h4v16h-4M10 8l-4 4 4 4M6 12h11"/>',
];
$svg = fn($k) => '<svg viewBox="0 0 24 24" aria-hidden="true">' . $ic[$k] . '</svg>';
$side = function (string $href, string $icon, string $label, bool $active, string $badge = '') use ($svg) {
    return '<a class="sb-link' . ($active ? ' on' : '') . '" href="' . e($href) . '"' . ($active ? ' aria-current="page"' : '') . '>'
        . $svg($icon) . '<span>' . e($label) . '</span>' . ($badge !== '' ? '<em>' . e($badge) . '</em>' : '') . '</a>';
};
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(($title ?? '') !== '' ? $title . ' · ContentVendor' : 'ContentVendor') ?></title>
<meta name="description" content="ContentVendor by Toutify turns one business idea into articles, social posts, promotions and directory updates for local small businesses.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
</head>
<body class="<?= $me ? 'is-app' : 'is-public' ?><?= in_array($current, ['', 'pricing', 'done-for-you'], true) ? ' is-home' : '' ?><?= $isApp ? ' has-sidebar' : '' ?>">
<?php if ($isApp): ?>
<?php
    $plan = plan_of($me);
    $used = generations_used((int) $me['id']);
    $pct = $plan['generations'] ? min(100, (int) round($used / $plan['generations'] * 100)) : 0;
    $newRequests = $me['role'] === 'admin' ? (int) q("SELECT COUNT(*) FROM service_requests WHERE status = 'new'")->fetchColumn() : 0;
?>
<div class="sb-backdrop" data-sb-close></div>
<aside class="sb" id="sidebar" aria-label="<?= $isSuper ? 'Super admin' : 'Workspace' ?> navigation">
  <div class="sb-top">
    <a class="brand" href="<?= e(url($isSuper ? 'superadmin' : 'members')) ?>">
      <span class="brand-mark">CV</span>
      <span class="brand-text">ContentVendor<small><?= $isSuper ? 'Super admin' : 'by Toutify' ?></small></span>
    </a>
    <button class="sb-close" type="button" aria-label="Close menu" data-sb-close>✕</button>
  </div>

  <?php if ($isSuper): ?>
    <nav class="sb-nav">
      <span class="sb-label">Admin</span>
      <?= $side(url('superadmin'), 'chart', 'Overview', $view === '' || $view === 'overview') ?>
      <?= $side(url('superadmin?view=members'), 'users', 'Members', $view === 'members') ?>
      <?= $side(url('superadmin?view=requests'), 'inbox', 'Done-for-you requests', $view === 'requests', $newRequests ? (string) $newRequests : '') ?>
      <span class="sb-label">Switch</span>
      <?= $side(url('members'), 'back', 'Member workspace', false) ?>
      <?= $side(url(''), 'site', 'View website', false) ?>
    </nav>
  <?php else: ?>
    <a class="sb-cta" href="<?= e(url('create')) ?>"><?= $svg('create') ?> Create a campaign</a>
    <nav class="sb-nav">
      <span class="sb-label">Workspace</span>
      <?= $side(url('members'), 'home', 'Dashboard', $current === 'members') ?>
      <?php $todayTodo = 0; if (active_plan((int) $me['id'])) { $todayTodo = count(array_filter(tasks_between((int) $me['id'], date('Y-m-d'), date('Y-m-d')), fn($t) => $t['status'] === 'todo')); } ?>
      <?= $side(url('planner'), 'plan2', 'My content plan', $current === 'planner', $todayTodo ? (string) $todayTodo : '') ?>
      <?= $side(url('platforms'), 'toggle', 'My platforms', $current === 'platforms', count(enabled_platforms($me)) . '/' . platform_limit($me)) ?>
      <?= $side(url('library'), 'library', 'Content library', in_array($current, ['library', 'item', 'campaign'], true)) ?>
      <?= $side(url('calendar'), 'calendar', 'Calendar', $current === 'calendar') ?>
      <span class="sb-label">Account</span>
      <?= $side(url('profile'), 'profile', 'Business profile', $current === 'profile') ?>
      <?= $side(url('account'), 'plan', 'My plan', $current === 'account') ?>
      <?php if ($me['role'] === 'admin'): ?>
        <span class="sb-label">Admin</span>
        <?= $side(url('superadmin'), 'shield', 'Super admin', false, $newRequests ? (string) $newRequests : '') ?>
      <?php endif; ?>
    </nav>
    <div class="sb-usage">
      <div class="sb-usage-top"><span><?= e($plan['name']) ?> plan</span><b><?= (int) $used ?>/<?= (int) $plan['generations'] ?></b></div>
      <div class="sb-meter"><i style="width:<?= $pct ?>%"></i></div>
      <small>AI generations this month</small>
      <?php if ($me['plan'] !== 'premium'): ?><a href="<?= e(url('account')) ?>">Upgrade for more →</a><?php endif; ?>
    </div>
  <?php endif; ?>

  <div class="sb-user">
    <span class="sb-avatar"><?= e(mb_strtoupper(mb_substr($me['name'], 0, 1))) ?></span>
    <div><b><?= e($me['name']) ?></b><small><?= e($me['email']) ?></small></div>
    <form method="post" action="<?= e(url('logout')) ?>">
      <?= csrf_field() ?><button class="sb-logout" type="submit" title="Log out" aria-label="Log out"><?= $svg('logout') ?></button>
    </form>
  </div>
</aside>
<div class="sb-main">
  <header class="sb-topbar">
    <button class="sb-open" type="button" aria-label="Open menu" aria-controls="sidebar" aria-expanded="false" data-sb-open>☰</button>
    <a class="brand" href="<?= e(url($isSuper ? 'superadmin' : 'members')) ?>"><span class="brand-mark">CV</span><span class="brand-text">ContentVendor</span></a>
  </header>
<?php else: ?>
<header class="site-header">
  <div class="container nav">
    <a class="brand" href="<?= e(url($me ? 'members' : '')) ?>">
      <span class="brand-mark">CV</span>
      <span class="brand-text">ContentVendor<small>by Toutify</small></span>
    </a>
    <button class="nav-toggle" type="button" aria-label="Menu" aria-expanded="false" data-nav-toggle>☰</button>
    <nav class="menu" data-nav>
      <?php if ($me): ?>
        <?= $nav('pricing', 'Pricing') ?>
        <?= $nav('done-for-you', 'Done-for-you') ?>
        <form method="post" action="<?= e(url('logout')) ?>" class="inline">
          <?= csrf_field() ?><button class="link-button" type="submit">Log out</button>
        </form>
        <a class="btn btn-primary btn-sm" href="<?= e(url(home_path_for($me))) ?>">Go to dashboard</a>
      <?php else: ?>
        <?= $nav('', 'How it works') ?>
        <?= $nav('pricing', 'Pricing') ?>
        <?= $nav('done-for-you', 'Done-for-you') ?>
        <?= $nav('members', 'Log in') ?>
        <a class="btn btn-primary btn-sm" href="<?= e(url('register')) ?>">Start free</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<?php endif; ?>

<main>
  <?php $flashes = take_flashes(); if ($flashes): ?>
    <div class="container flashes">
      <?php foreach ($flashes as $f): ?>
        <div class="flash flash-<?= e($f['type']) ?>"><?= e($f['message']) ?></div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
  <?= $content ?>
</main>

<?php if ($isApp): ?>
</div>
<?php else: ?>
<footer class="site-footer">
  <div class="container footer-grid">
    <div>
      <strong>ContentVendor</strong>
      <p>Create once. Promote everywhere. Part of the Toutify network with SearchMonster, MonsterList, PromoMonster and LeadCrazy.</p>
    </div>
    <div class="footer-links">
      <a href="<?= e(url('pricing')) ?>">Pricing</a>
      <a href="<?= e(url('done-for-you')) ?>">Done-for-you packages</a>
      <a href="<?= e(url($me ? home_path_for($me) : 'register')) ?>"><?= $me ? 'Dashboard' : 'Create a free account' ?></a>
    </div>
  </div>
  <div class="container small muted">© <?= date('Y') ?> Toutify. Publishing availability depends on each network's API and permissions.</div>
</footer>
<?php endif; ?>
<script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
