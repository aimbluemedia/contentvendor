<?php
$me = current_user();
$current = trim(substr(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', strlen(base_path())), '/');
$nav = function (string $path, string $label) use ($current) {
    $active = $current === $path ? ' class="active"' : '';
    return '<a href="' . e(url($path)) . '"' . $active . '>' . e($label) . '</a>';
};
$appRoutes = ['members', 'planner', 'platforms', 'create', 'campaign', 'library', 'item', 'calendar', 'profile', 'account', 'superadmin', 'posting-guide', 'performance'];
$isApp = $me && in_array($current, $appRoutes, true);
$isSuper = $isApp && $current === 'superadmin';
$view = (string) ($_GET['view'] ?? '');
$ic = [
    'plan2'    => '<path d="M9 5h10M9 12h10M9 19h10"/><path d="M4 5l1 1 2-2M4 12l1 1 2-2M4 19l1 1 2-2"/>',
    'toggle'   => '<rect x="2" y="7" width="20" height="10" rx="5"/><circle cx="16" cy="12" r="3"/>',
    'home'     => '<path d="M3 11l9-7 9 7"/><path d="M5 10v10h14V10"/><path d="M10 20v-6h4v6"/>',
    'create'   => '<path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/><circle cx="12" cy="12" r="3"/>',
    'library'  => '<path d="M4 4h5v16H4zM10 4h5v16h-5z"/><path d="M16 5l4 1-3 14-4-1"/>',
    'guide'    => '<path d="M4 5a2 2 0 0 1 2-2h13v16H6a2 2 0 0 0-2 2z"/><path d="M4 19V5M8 7h7M8 11h5"/>',
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
      <?= $side(url('posting-guide'), 'guide', 'Posting guide', $current === 'posting-guide') ?>
      <?= $side(url('calendar'), 'calendar', 'Calendar', $current === 'calendar') ?>
      <?= $side(url('library'), 'library', 'Content library', in_array($current, ['library', 'item', 'campaign'], true)) ?>
      <?= $side(url('performance'), 'chart', 'Performance', $current === 'performance') ?>
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
    <a class="sb-logout" href="<?= e(url('auth/toutify/logout')) ?>" title="Log out" aria-label="Log out"><?= $svg('logout') ?></a>
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
        <a href="<?= e(url('auth/toutify/logout')) ?>">Log out</a>
        <a class="btn btn-primary btn-sm" href="<?= e(url(home_path_for($me))) ?>">Go to dashboard</a>
      <?php else: ?>
        <?= $nav('', 'How it works') ?>
        <?= $nav('pricing', 'Pricing') ?>
        <?= $nav('done-for-you', 'Done-for-you') ?>
        <?= $nav('auth/toutify/login', 'Log in') ?>
        <a class="btn btn-primary btn-sm" href="<?= e(url('signup')) ?>">Start free</a>
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
<?php
$ftTools = [
    ['ContentVendor', 'Posts and articles written for you, on autopilot.', '<path d="M4 20h4L19 9l-4-4L4 16z"/>', true],
    ['SearchMonster', 'Show up when customers ask AI who to hire.', '<path fill-rule="evenodd" d="M10.5 3a7.5 7.5 0 0 1 6 12l4.3 4.3-1.5 1.5-4.3-4.3A7.5 7.5 0 1 1 10.5 3zm0 2.2a5.3 5.3 0 1 0 0 10.6 5.3 5.3 0 0 0 0-10.6z"/>', false],
    ['MonsterList', 'Get listed in directories across the web. Free.', '<path fill-rule="evenodd" d="M5 2h14v20H5zm3 5v2h8V7zm0 4v2h8v-2zm0 4v2h5v-2z"/>', false],
    ['PromoMonster', 'Win more 5-star reviews and protect your reputation.', '<path d="M12 2.5l2.9 6 6.6.8-4.9 4.6 1.3 6.6L12 17.3l-5.9 3.2 1.3-6.6-4.9-4.6 6.6-.8z"/>', false],
    ['LeadCrazy', 'Turn visitors into quote requests with the Million Dollar Lead Form.', '<path d="M13 2 4.5 13.5H11L10 22l8.5-11.5H12z"/>', false],
    ['Official Directories', 'Claim your free spot in official state directories.', '<path d="M12 2 2 7v2h20V7zM4 11v7h3v-7zm6.5 0v7h3v-7zM17 11v7h3v-7zM2 20h20v2H2z"/>', false],
];
$ftLoggedIn = (bool) $me;
$ftPrivacy = (string) (config('privacy_url') ?: url('privacy'));
$ftTerms = (string) (config('terms_url') ?: url('terms'));
?>
<section class="ft-member" aria-labelledby="ft-member-title">
  <div class="container">
    <div class="ft-top">
      <div class="ft-copy">
        <span class="ft-kicker"><i></i> Toutify membership</span>
        <h2 id="ft-member-title">One free account. <span>Your whole growth toolkit.</span></h2>
        <p>Join Toutify once and ContentVendor comes with it, plus the tools that get you found, reviewed and talked about. No credit card, no trial clock, no catch.</p>
        <ul class="ft-chips">
          <li>Free forever</li><li>No credit card</li><li>Every tool included</li><li>One login, every site</li>
        </ul>
      </div>
      <div class="ft-cta">
        <?php if ($ftLoggedIn): ?>
          <a class="ft-btn" href="<?= e(url(home_path_for($me))) ?>">Go to my dashboard <span aria-hidden="true">→</span></a>
        <?php else: ?>
          <a class="ft-btn" href="<?= e(url('signup')) ?>">Start free, takes a minute <span aria-hidden="true">→</span></a>
          <a class="ft-login" href="<?= e(url('auth/toutify/login')) ?>">Already a member? Log in</a>
        <?php endif; ?>
      </div>
    </div>
    <p class="ft-label">Included with your free membership</p>
    <ul class="ft-tools">
      <?php foreach ($ftTools as [$name, $desc, $icon, $here]): ?>
        <li class="<?= $here ? 'is-here' : '' ?>">
          <span class="ft-ic" aria-hidden="true"><svg viewBox="0 0 24 24"><?= $icon ?></svg></span>
          <div><b><?= e($name) ?></b><small><?= e($desc) ?></small></div>
          <?php if ($here): ?><em>You are here</em><?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</section>
<footer class="site-footer ft">
  <div class="container ft-grid" style="--ft-cols:<?= ($ftPrivacy || $ftTerms) ? 4 : 3 ?>">
    <div class="ft-brand">
      <a class="ft-logo" href="<?= e(url('')) ?>"><span class="ft-mark">CV</span><span>Content<b>Vendor</b><small>by Toutify</small></span></a>
      <p>AI content and social media for small businesses: plan it, write it and post it everywhere your customers look.</p>
    </div>
    <nav aria-label="ContentVendor">
      <h3>ContentVendor</h3>
      <a href="<?= e(url('')) ?>">Home</a>
      <a href="<?= e(url('')) ?>#tools">Free AI tools</a>
      <a href="<?= e(url('pricing')) ?>">Pricing</a>
      <a href="<?= e(url('done-for-you')) ?>">Done-for-you content</a>
    </nav>
    <nav aria-label="Features">
      <h3>Features</h3>
      <a href="<?= e(url('')) ?>#tools">AI Campaign Builder</a>
      <a href="<?= e(url('')) ?>#tools">Daily content plan</a>
      <a href="<?= e(url('')) ?>#tools">Image &amp; video prompts</a>
      <a href="<?= e(url('')) ?>#tools">Performance dashboard</a>
    </nav>
    <nav aria-label="Account">
      <h3>Account</h3>
      <?php if ($ftLoggedIn): ?>
        <a href="<?= e(url(home_path_for($me))) ?>">Members dashboard</a>
        <a href="<?= e(url('auth/toutify/logout')) ?>">Log out</a>
      <?php else: ?>
        <a href="<?= e(url('signup')) ?>">Create a free account</a>
        <a href="<?= e(url('auth/toutify/login')) ?>">Log in</a>
        <a href="<?= e(url('members')) ?>">Members dashboard</a>
      <?php endif; ?>
    </nav>
    <?php if ($ftPrivacy || $ftTerms): ?>
      <nav aria-label="Legal">
        <h3>Legal</h3>
        <?php if ($ftPrivacy): ?><a href="<?= e($ftPrivacy) ?>">Privacy</a><?php endif; ?>
        <?php if ($ftTerms): ?><a href="<?= e($ftTerms) ?>">Terms</a><?php endif; ?>
      </nav>
    <?php endif; ?>
  </div>
  <div class="container ft-bottom">
    <span>© <?= date('Y') ?> ContentVendor by Toutify. All rights reserved.</span>
    <span>Content you create stays in your library.</span>
  </div>
</footer>
<?php endif; ?>
<script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
