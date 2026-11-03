<?php
$cell = function ($v) {
    if ($v === true) return '<span class="yes" aria-label="Included">✓</span>';
    if ($v === false) return '<span class="no" aria-label="Not included">—</span>';
    return e($v);
};
?>
<section class="section">
  <div class="container">
    <div class="section-head center">
      <p class="kicker">Included with your Toutify membership</p>
      <h1>Simple plans that grow with you</h1>
      <p class="muted">Free means functional, not a trial. Upgrade when you want scheduling and automation that saves you hours every month.</p>
    </div>
    <div class="plans">
      <?php foreach (PLANS as $key => $p): ?>
        <div class="plan<?= $key === 'premium' ? ' featured' : '' ?>">
          <?php if ($key === 'premium'): ?><span class="badge">Most time saved</span><?php endif; ?>
          <p class="kicker"><?= e($p['name']) ?> · <?= e($p['verb']) ?></p>
          <div class="price">$<?= (int) $p['price'] ?><small>/month</small></div>
          <p><?= e($p['tagline']) ?></p>
          <ul class="ticks">
            <li><?= (int) $p['generations'] ?> AI content generations / month</li>
            <li><?= $p['campaign_channels'] >= 8 ? 'Full 8-channel campaigns' : 'Campaigns for up to ' . (int) $p['campaign_channels'] . ' channels' ?></li>
            <li><?= $p['scheduling'] ? (int) $p['scheduled_posts'] . ' scheduled posts / month' : 'Copy & download every draft' ?></li>
            <?php if ($key === 'premium'): ?><li>AI monthly planner & content recycling</li><?php endif; ?>
          </ul>
          <a class="btn <?= $key === 'premium' ? 'btn-primary' : 'btn-ghost' ?> btn-block" href="<?= e(url('register')) ?>"><?= $p['price'] ? 'Choose ' . e($p['name']) : 'Start free' ?></a>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="table-wrap">
      <table class="compare">
        <thead><tr><th>Feature</th><th>Free $0</th><th>Pro $19</th><th>Premium $49</th></tr></thead>
        <tbody>
          <?php foreach (PLAN_FEATURES as $row): ?>
            <tr><td><?= e($row[0]) ?></td><td><?= $cell($row[1]) ?></td><td><?= $cell($row[2]) ?></td><td><?= $cell($row[3]) ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="small muted">Limits are per business per month. One generation is one requested content item, with fair-use limits on length and revisions. Images, social connections, auto-publishing, the monthly planner and recycling are rolling out in phases; publishing availability depends on each social network's API and permissions.</p>
  </div>
</section>

<section class="section alt">
  <div class="container">
    <div class="section-head center">
      <h2>Rather have us do it?</h2>
      <p class="muted">Done-for-you packages include the $49 Premium membership.</p>
    </div>
    <?php require ROOT . '/app/views/_packages.php'; ?>
  </div>
</section>
