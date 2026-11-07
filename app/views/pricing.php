<?php
$cell = function ($v) {
    if ($v === true) return '<span class="m-yes" aria-label="Included">✓</span>';
    if ($v === false) return '<span class="m-no" aria-label="Not included">–</span>';
    return e($v);
};
$billingFaqs = [
    ['Do I pay separately for ContentVendor?', 'No. The $0, $19 and $49.99 plans are part of your main Toutify subscription.'],
    ['What counts as one AI content piece?', 'One requested item, such as one Facebook post or one article. A campaign for 4 channels uses 4. Fair-use limits apply to length and revisions.'],
    ['What happens when I reach my monthly limit?', 'Your library, calendar and downloads keep working. New AI content resets on the 1st, or you can upgrade any time.'],
    ['Can I change or cancel my plan?', 'Yes. Plans are month to month, and everything you created stays in your library.'],
];
?>
<section class="m-hero m-hero-center">
  <div class="container">
    <span class="m-eyebrow">Pricing</span>
    <h1>Simple plans. <span class="m-hl">Start free.</span></h1>
    <p class="m-lead">Included with your Toutify membership. Create content free, or upgrade to schedule and automate it.</p>
  </div>
</section>

<section class="m-section m-pt0">
  <div class="container">
    <?php require ROOT . '/app/views/_plan_cards.php'; ?>
    <p class="m-center m-muted m-small">Limits are per business per month. Images, auto-publishing, the planner and recycling are rolling out in phases.</p>
  </div>
</section>

<section class="m-section m-alt">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">Compare plans</span>
      <h2>Every feature, side by side.</h2>
    </div>
    <div class="m-table-wrap">
      <table class="m-table">
        <thead><tr><th>Feature</th><?php foreach (PLANS as $key => $p): ?><th class="<?= $key === 'premium' ? 'hl' : '' ?>"><?= e($p['name']) ?><small><?= e(money($p['price'])) ?>/mo</small></th><?php endforeach; ?></tr></thead>
        <tbody>
          <?php foreach (PLAN_FEATURES as $row): ?>
            <tr><td><?= e($row[0]) ?></td><td><?= $cell($row[1]) ?></td><td><?= $cell($row[2]) ?></td><td class="hl"><?= $cell($row[3]) ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="m-section">
  <div class="container">
    <div class="m-banner">
      <div>
        <span class="m-eyebrow">Done-for-you</span>
        <h2>No time? Our team can handle it.</h2>
        <p>We plan, write, schedule and report on your content. Premium is included.</p>
      </div>
      <div class="m-banner-prices">
        <?php foreach (PACKAGES as $key => $pkg): ?>
          <a href="<?= e(url('done-for-you?package=' . $key)) ?>#request"><span><?= e($pkg['name']) ?></span><b>$<?= number_format($pkg['price']) ?>/mo</b></a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<section class="m-section m-alt">
  <div class="container m-faq">
    <div class="m-head left"><span class="m-eyebrow">FAQ</span><h2>Billing questions.</h2></div>
    <div class="m-faq-list">
      <?php foreach ($billingFaqs as $i => [$q, $a]): ?>
        <details<?= $i === 0 ? ' open' : '' ?>><summary><?= e($q) ?></summary><p><?= e($a) ?></p></details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="m-section">
  <div class="container">
    <div class="m-final">
      <h2>Start free today.</h2>
      <p>No credit card. Your first campaign takes about a minute.</p>
      <a class="m-btn m-btn-primary" href="<?= e(url('signup')) ?>">Create my free account</a>
    </div>
  </div>
</section>
