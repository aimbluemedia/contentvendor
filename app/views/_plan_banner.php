<?php
/** Members dashboard: welcome + plan journey banner (Free → Pro → Premium → Done For You) */
$firstName = trim(strtok((string) $user['name'], ' ')) ?: 'there';
$steps = [
    'starter' => ['Free', '$0/month'],
    'pro'     => ['Pro', '$19/month'],
    'premium' => ['Premium', '$49/month'],
    'dfy'     => ['Done For You', 'From $299/month'],
];
$order = array_keys($steps);
$currentIdx = array_search($user['plan'], $order, true);
if ($currentIdx === false) $currentIdx = 0;
$toolsByPlan = ['starter' => 7, 'pro' => 12, 'premium' => 15];
$toolsActive = $toolsByPlan[$user['plan']] ?? 7;
$upgradeUrl = config('upgrade_url') ?: url('pricing');
$cur = plan_of($user);
?>
<section class="pb" aria-label="Your ContentVendor plan">
  <div class="pb-glow" aria-hidden="true"></div>
  <div class="pb-top">
    <div>
      <span class="pb-kicker">Welcome back</span>
      <h1><?= e($firstName) ?>, here's your ContentVendor plan</h1>
      <p><?= e($profile['business_name'] !== '' ? $profile['business_name'] : 'Your business marketing workspace') ?></p>
    </div>
    <div class="pb-current">
      <span class="pb-kicker"><i></i> Current plan</span>
      <b><?= e($cur['name'] === 'Starter' ? 'Free' : $cur['name']) ?></b>
      <span>$<?= (int) $cur['price'] ?> <small>/month</small></span>
    </div>
  </div>

  <ol class="pb-steps" style="--pb-fill:<?= round(75 * $currentIdx / 3, 2) ?>%">
    <?php foreach ($order as $i => $k): [$label, $price] = $steps[$k];
        $state = $i < $currentIdx ? 'done' : ($i === $currentIdx ? 'current' : 'next'); ?>
      <li class="pb-step is-<?= $state ?>">
        <span class="pb-dot" aria-hidden="true"><?= $state === 'next' ? '' : '✓' ?></span>
        <b><?= e($label) ?></b>
        <small><?= e($price) ?></small>
        <?php if ($state === 'current'): ?>
          <span class="pb-here">You're here</span>
        <?php elseif ($state === 'done'): ?>
          <span class="pb-incl">Included</span>
        <?php else: ?>
          <a class="pb-up" href="<?= e($k === 'dfy' ? url('done-for-you') : $upgradeUrl) ?>">Upgrade <span aria-hidden="true">→</span></a>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
  </ol>

  <div class="pb-foot">
    <span><b><?= (int) $toolsActive ?> of 15</b> tools active on your account</span>
    <a class="pb-compare" href="<?= e(url('pricing')) ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="6" width="18" height="13" rx="2"/><path d="M3 10h18M7 15h4"/></svg> Compare plans</a>
  </div>
</section>
