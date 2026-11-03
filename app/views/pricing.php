<?php
$cell = function ($v) {
    if ($v === true) return '<span class="cmp-yes" aria-label="Included">✓</span>';
    if ($v === false) return '<span class="cmp-no" aria-label="Not included">—</span>';
    return e($v);
};
$billingFaqs = [
    ['Do I pay separately for ContentVendor?', 'No. The $0, $19 and $49 plans are part of your main Toutify subscription, so you are not charged again just to use ContentVendor.'],
    ['What counts as one AI generation?', 'One requested content item, such as one Facebook post, one article or one video script. A campaign for 4 channels uses 4 generations. Fair-use limits apply to length and revisions.'],
    ['What happens when I hit my monthly limit?', 'Your content library, calendar and downloads keep working. New AI generations reset on the 1st of each month, or you can upgrade any time.'],
    ['Can I switch plans later?', 'Yes. Plans are month to month, so you can upgrade, downgrade or cancel whenever you like. Everything you created stays in your library.'],
    ['Why is Premium the best value?', 'Not because it has more AI generations. Premium prepares and schedules weeks of business-specific content for you to approve, which is the part that saves the most time.'],
];
?>

<!-- HERO -->
<section class="pg-hero">
  <div class="container">
    <p class="hx-eyebrow">Pricing · Included with your Toutify membership</p>
    <h1 class="hx-display"><span class="ink">Free to create.</span><span class="light">Cheap to automate.</span></h1>
    <p class="hx-lead">Start with a free plan that's actually useful. Upgrade when you want your content scheduled and your month planned for you, or hand it all to our team.</p>
    <div class="pg-switch" role="list">
      <a role="listitem" href="#plans" class="on">Memberships $0–$49</a>
      <a role="listitem" href="<?= e(url('done-for-you')) ?>">Done-for-you $299+</a>
    </div>
  </div>
</section>

<!-- PLANS -->
<section class="hx-mint pg-plans" id="plans">
  <div class="container">
    <div class="plan3">
      <?php foreach (PLANS as $key => $p):
          $hero = $key === 'premium'; ?>
        <div class="plan3-card<?= $hero ? ' hero' : ($key === 'pro' ? ' mid' : '') ?>">
          <?php if ($hero): ?><span class="ribbon">Most time saved</span><?php endif; ?>
          <span class="plan3-step"><?= e($p['verb']) ?> it</span>
          <h2><?= e($p['name']) ?></h2>
          <div class="pc-price">$<?= (int) $p['price'] ?><small>/month</small></div>
          <p class="plan3-tag"><?= e($p['tagline']) ?></p>
          <a class="pill <?= $hero ? 'pill-lime' : 'pill-dark' ?> pill-block" href="<?= e(url('register')) ?>"><?= $p['price'] ? 'Choose ' . e($p['name']) : 'Start free' ?> →</a>
          <ul class="plan3-list">
            <li><b><?= (int) $p['generations'] ?></b> AI content generations / month</li>
            <li><?= $p['campaign_channels'] >= 8 ? '<b>All 8</b> campaign channels' : 'Campaigns for up to <b>' . (int) $p['campaign_channels'] . '</b> channels' ?></li>
            <?php if ($key === 'starter'): ?>
              <li>Article, caption, offer &amp; video script writers</li>
              <li>Content library: copy &amp; download everything</li>
              <li>Basic calendar &amp; performance view</li>
              <li>Manual directory sharing</li>
            <?php elseif ($key === 'pro'): ?>
              <li><b>30</b> scheduled posts / month</li>
              <li><b>3</b> connected social accounts</li>
              <li><b>10</b> business-branded images / month</li>
              <li>Turn articles into social posts</li>
              <li>Full content calendar</li>
            <?php else: ?>
              <li><b>150</b> scheduled posts / month</li>
              <li><b>7</b> connected social accounts</li>
              <li><b>40</b> business-branded images / month</li>
              <li>AI monthly content planner</li>
              <li>Automatic content recycling</li>
              <li>Advanced directory distribution</li>
            <?php endif; ?>
          </ul>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="pg-note">Limits are per business per month. Images, social connections, auto-publishing, the monthly planner and recycling are rolling out in phases; publishing depends on each network's API and permissions.</p>
  </div>
</section>

<!-- VALUE -->
<section class="hx-dark">
  <div class="container">
    <div class="hx-split-head">
      <div>
        <p class="hx-eyebrow light">Why upgrade</p>
        <h2 class="hx-display md"><span class="white">Don't pay for words.</span><span class="lime">Pay for time back.</span></h2>
      </div>
      <p class="hx-side">Writing a post takes AI seconds. What eats your week is planning, adapting and posting it everywhere. That's what Pro and Premium handle.</p>
    </div>
    <div class="value-grid">
      <div class="value-card"><span class="value-num">01</span><h3>Free: create it</h3><p>A handyman who needs a few Facebook posts a month gets real, downloadable content every month and never has to upgrade.</p><b class="value-stat">5 pieces / mo</b></div>
      <div class="value-card"><span class="value-num">02</span><h3>Pro: schedule it</h3><p>Write a campaign once, then schedule it across your channels. Turn one article into a week of social posts.</p><b class="value-stat">≈ 10 hrs saved / mo</b></div>
      <div class="value-card hl"><span class="value-num">03</span><h3>Premium: automate it</h3><p>Get a month of campaigns planned around your season and services, ready to approve. Your evergreen posts come back automatically.</p><b class="value-stat">≈ 30+ hrs saved / mo</b></div>
    </div>
    <p class="pg-note light">Hours saved are estimates based on about 20 minutes to write and post each piece by hand. <a href="<?= e(url('')) ?>#calculator">Try the content calculator →</a></p>
  </div>
</section>

<!-- COMPARE -->
<section class="hx-mint">
  <div class="container">
    <div class="hx-split-head">
      <div>
        <p class="hx-eyebrow">Compare plans</p>
        <h2 class="hx-display md"><span class="ink">Every feature,</span><span class="green">side by side.</span></h2>
      </div>
      <p class="hx-side dark">Every plan includes the shared Toutify business profile, the Campaign Builder and your content library.</p>
    </div>
    <div class="cmp-wrap">
      <table class="cmp">
        <thead>
          <tr><th>Feature</th>
            <?php foreach (PLANS as $key => $p): ?><th class="<?= $key === 'premium' ? 'hl' : '' ?>"><?= e($p['name']) ?><small>$<?= (int) $p['price'] ?>/mo</small></th><?php endforeach; ?>
          </tr>
        </thead>
        <tbody>
          <?php foreach (PLAN_FEATURES as $row): ?>
            <tr><td><?= e($row[0]) ?></td><td><?= $cell($row[1]) ?></td><td><?= $cell($row[2]) ?></td><td class="hl"><?= $cell($row[3]) ?></td></tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- DFY TEASER -->
<section class="hx-free-wrap pg-dfy-wrap">
  <div class="container">
    <div class="hx-free pg-dfy">
      <div>
        <p class="hx-eyebrow light"><span class="hx-tag">Done-for-you</span></p>
        <h2 class="hx-display md"><span class="white">No time at all?</span><span class="lime">We'll handle it.</span></h2>
        <p class="hx-side">Our content team plans, writes, schedules and reports on your marketing, and the $49 Premium membership is included.</p>
      </div>
      <div class="pg-dfy-prices">
        <?php foreach (PACKAGES as $key => $pkg): ?>
          <a href="<?= e(url('done-for-you?package=' . $key)) ?>#request" class="pg-dfy-row<?= !empty($pkg['featured']) ? ' on' : '' ?>">
            <span><b><?= e($pkg['name']) ?></b><small><?= e($pkg['includes'][0]) ?></small></span>
            <strong>$<?= number_format($pkg['price']) ?><small>/mo</small></strong>
          </a>
        <?php endforeach; ?>
        <a class="pill pill-lime pill-block" href="<?= e(url('done-for-you')) ?>">See done-for-you packages →</a>
      </div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="hx-faq">
  <div class="container hx-faq-grid">
    <div>
      <p class="hx-eyebrow">Billing questions</p>
      <h2 class="hx-display sm"><span class="ink">Simple,</span><span class="green">honest pricing.</span></h2>
    </div>
    <div class="faq-list">
      <?php foreach ($billingFaqs as $i => [$q, $a]): ?>
        <details<?= $i === 0 ? ' open' : '' ?>><summary><?= e($q) ?></summary><p><?= e($a) ?></p></details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="hx-final">
  <div class="container">
    <div class="hx-final-card">
      <div>
        <h2 class="hx-display sm"><span class="ink">Start free today.</span><span class="white">Upgrade when it pays off.</span></h2>
        <p>No credit card. Your first campaign takes about a minute.</p>
      </div>
      <a class="pill pill-dark" href="<?= e(url('register')) ?>">Create my free account →</a>
    </div>
  </div>
</section>
