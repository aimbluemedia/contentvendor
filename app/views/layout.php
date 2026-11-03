<?php
$me = current_user();
$current = trim(substr(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/', strlen(base_path())), '/');
$nav = function (string $path, string $label) use ($current) {
    $active = $current === $path ? ' class="active"' : '';
    return '<a href="' . e(url($path)) . '"' . $active . '>' . e($label) . '</a>';
};
?><!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e(($title ?? '') !== '' ? $title . ' · ContentVendor' : 'ContentVendor') ?></title>
<meta name="description" content="ContentVendor by Toutify turns one business idea into articles, social posts, promotions and directory updates for local small businesses.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap">
<link rel="stylesheet" href="<?= e(asset('css/style.css')) ?>">
</head>
<body class="<?= $me ? 'is-app' : 'is-public' ?>">
<header class="site-header">
  <div class="container nav">
    <a class="brand" href="<?= e(url($me ? 'dashboard' : '')) ?>">
      <span class="brand-mark">CV</span>
      <span class="brand-text">ContentVendor<small>by Toutify</small></span>
    </a>
    <button class="nav-toggle" type="button" aria-label="Menu" aria-expanded="false" data-nav-toggle>☰</button>
    <nav class="menu" data-nav>
      <?php if ($me): ?>
        <?= $nav('dashboard', 'Dashboard') ?>
        <?= $nav('create', 'Create') ?>
        <?= $nav('library', 'Library') ?>
        <?= $nav('calendar', 'Calendar') ?>
        <?= $nav('profile', 'Business profile') ?>
        <?= $nav('account', 'My plan') ?>
        <?php if ($me['role'] === 'admin'): ?><?= $nav('admin', 'Team') ?><?php endif; ?>
        <form method="post" action="<?= e(url('logout')) ?>" class="inline">
          <?= csrf_field() ?><button class="link-button" type="submit">Log out</button>
        </form>
      <?php else: ?>
        <?= $nav('', 'How it works') ?>
        <?= $nav('pricing', 'Pricing') ?>
        <?= $nav('done-for-you', 'Done-for-you') ?>
        <?= $nav('login', 'Log in') ?>
        <a class="btn btn-primary btn-sm" href="<?= e(url('register')) ?>">Start free</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

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

<footer class="site-footer">
  <div class="container footer-grid">
    <div>
      <strong>ContentVendor</strong>
      <p>Create once. Promote everywhere. Part of the Toutify network with SearchMonster, MonsterList, PromoMonster and LeadCrazy.</p>
    </div>
    <div class="footer-links">
      <a href="<?= e(url('pricing')) ?>">Pricing</a>
      <a href="<?= e(url('done-for-you')) ?>">Done-for-you packages</a>
      <a href="<?= e(url($me ? 'dashboard' : 'register')) ?>"><?= $me ? 'Dashboard' : 'Create a free account' ?></a>
    </div>
  </div>
  <div class="container small muted">© <?= date('Y') ?> Toutify. Publishing availability depends on each network's API and permissions.</div>
</footer>
<script src="<?= e(asset('js/app.js')) ?>"></script>
</body>
</html>
