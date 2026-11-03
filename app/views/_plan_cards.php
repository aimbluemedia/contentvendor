<?php
$planPoints = [
    'starter' => ['5 AI content pieces / month', 'Campaigns for up to 3 channels', 'Copy & download everything'],
    'pro'     => ['40 AI content pieces / month', 'All 8 channels', 'Schedule 30 posts / month', 'Turn articles into posts'],
    'premium' => ['150 AI content pieces / month', 'Schedule 150 posts / month', 'AI monthly content planner', 'Automatic content recycling'],
];
?>
<div class="m-plans">
  <?php foreach (PLANS as $key => $p): $hero = $key === 'premium'; ?>
    <div class="m-plan<?= $hero ? ' hero' : '' ?>">
      <?php if ($hero): ?><span class="m-plan-badge">Most time saved</span><?php endif; ?>
      <h3><?= e($p['name']) ?></h3>
      <p class="m-plan-tag"><?= e($p['tagline']) ?></p>
      <div class="m-price">$<?= (int) $p['price'] ?><small>/month</small></div>
      <a class="m-btn <?= $hero ? 'm-btn-primary' : 'm-btn-light' ?> m-btn-block" href="<?= e(url('register')) ?>"><?= $p['price'] ? 'Choose ' . e($p['name']) : 'Start free' ?></a>
      <ul><?php foreach ($planPoints[$key] as $pt): ?><li><?= e($pt) ?></li><?php endforeach; ?></ul>
    </div>
  <?php endforeach; ?>
</div>
