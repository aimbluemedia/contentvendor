<section class="section-sm">
  <div class="container">
    <h1>My plan</h1>
    <div class="stats">
      <div class="stat"><b><?= e($plan['name']) ?></b><span>Current plan · $<?= (int) $plan['price'] ?>/month</span></div>
      <div class="stat"><b><?= (int) $used ?><small>/<?= (int) $plan['generations'] ?></small></b><span>AI generations used this month</span></div>
      <div class="stat"><b><?= (int) $scheduled ?><small>/<?= (int) $plan['scheduled_posts'] ?></small></b><span>Scheduled posts this month</span></div>
      <div class="stat"><b><?= e(date('M 1', strtotime('first day of next month'))) ?></b><span>Limits reset</span></div>
    </div>
    <div class="meter" role="progressbar" aria-valuemin="0" aria-valuemax="<?= (int) $plan['generations'] ?>" aria-valuenow="<?= (int) $used ?>"><span style="width: <?= min(100, $plan['generations'] ? round($used / $plan['generations'] * 100) : 0) ?>%"></span></div>

    <h2>Plans</h2>
    <p class="muted">ContentVendor plans are part of your Toutify membership. To change plans, update your Toutify subscription<?= config('upgrade_url') ? '' : ' or contact our team' ?>.</p>
    <div class="plans">
      <?php foreach (PLANS as $key => $p): ?>
        <div class="plan<?= $key === $user['plan'] ? ' current' : ($key === 'premium' ? ' featured' : '') ?>">
          <p class="kicker"><?= e($p['name']) ?> · <?= e($p['verb']) ?></p>
          <div class="price">$<?= (int) $p['price'] ?><small>/month</small></div>
          <p><?= e($p['tagline']) ?></p>
          <?php if ($key === $user['plan']): ?>
            <span class="btn btn-ghost btn-block disabled">Your plan</span>
          <?php else: ?>
            <a class="btn btn-primary btn-block" href="<?= e(config('upgrade_url') ?: url('done-for-you')) ?>"><?= PLANS[$user['plan']]['price'] < $p['price'] ? 'Upgrade' : 'Switch' ?> to <?= e($p['name']) ?></a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
    <p><a href="<?= e(url('pricing')) ?>">See the full feature comparison →</a> · <a href="<?= e(url('done-for-you')) ?>">Prefer we do it for you?</a></p>
  </div>
</section>
