<?php
$dfyFaqs = [
    ['What is a "social campaign"?', 'One original idea, like this month\'s offer or a finished job, adapted into platform-specific posts for each of your networks. It is not a separate custom concept for every network.'],
    ['What do you need from me?', 'Your business information, any offers you want to run, and photos of your work if you have them. We handle planning, writing, scheduling and reporting.'],
    ['Do I get to approve everything?', 'Yes. Drafts arrive in your ContentVendor library. Approve or edit them yourself, or tell your strategist what to change. If you prefer, you can let us publish without review.'],
    ['Is video production or photography included?', 'No. Original video production and on-site photography are not included. We write video scripts and work with the photos you provide.'],
    ['Do I also get the software?', 'Yes. Every package includes the $49 Premium membership, so you can log in, create your own content and see everything we do.'],
    ['Is there a contract?', 'Packages are month to month. You can change packages or drop back to a self-serve plan at any time.'],
];
$steps = [
    ['01', 'Tell us about your business', 'A short onboarding call, and we set up your Toutify business profile: services, areas, voice and offers.'],
    ['02', 'We plan your month', 'Your content team builds a campaign calendar around your seasons, specials and goals.'],
    ['03', 'You approve in one click', 'Drafts land in your ContentVendor library. Approve or edit them from any device.'],
    ['04', 'We publish & report', 'Posts go out on schedule across your networks and the Toutify directories. Every month you get a report.'],
];
?>

<!-- HERO -->
<section class="pg-hero">
  <div class="container pg-hero-grid">
    <div>
      <p class="hx-eyebrow">Done-for-you content · From $299/mo</p>
      <h1 class="hx-display"><span class="ink">We write it.</span><span class="light">You approve it.</span></h1>
      <p class="hx-lead">For business owners who don't have time for marketing. Our team creates, schedules and reports on your content using ContentVendor, the same platform you can log into any time.</p>
      <div class="hx-actions">
        <a class="pill pill-dark" href="#request">Request a package →</a>
        <a class="pill pill-outline" href="#packages">See packages</a>
      </div>
      <ul class="hx-checks"><li>Premium membership included</li><li>Month to month</li><li>Monthly report</li></ul>
    </div>
    <div class="queue" aria-hidden="true">
      <div class="queue-head"><b>Approval queue</b><span class="chip-premium">3 ready</span></div>
      <div class="queue-item"><span class="q-ic">👍</span><div><b>Spring cleanup special</b><small>Facebook · Instagram · Google</small></div><em>Approve</em></div>
      <div class="queue-item"><span class="q-ic">📝</span><div><b>5 signs your sprinklers need repair</b><small>Website article · 620 words</small></div><em>Approve</em></div>
      <div class="queue-item done"><span class="q-ic">🎬</span><div><b>Before &amp; after: Mesa backyard</b><small>Reel script · scheduled Thu</small></div><em>✓ Done</em></div>
      <div class="queue-report">
        <span class="hx-label">This month</span>
        <div class="queue-stats"><div><b>32</b><small>posts</small></div><div><b>4</b><small>articles</small></div><div><b>6</b><small>networks</small></div></div>
      </div>
    </div>
  </div>
</section>

<!-- PACKAGES -->
<section class="hx-mint" id="packages">
  <div class="container">
    <div class="hx-split-head">
      <div>
        <p class="hx-eyebrow">Packages</p>
        <h2 class="hx-display md"><span class="ink">Pick your pace.</span><span class="green">We do the rest.</span></h2>
      </div>
      <p class="hx-side dark">Every package includes the $49 Premium membership, so you get the whole software suite alongside our team.</p>
    </div>
    <div class="plan3">
      <?php foreach (PACKAGES as $key => $pkg):
          $hero = !empty($pkg['featured']); ?>
        <div class="plan3-card<?= $hero ? ' hero' : '' ?>">
          <?php if ($hero): ?><span class="ribbon">Most popular</span><?php endif; ?>
          <span class="plan3-step"><?= e(['starter' => 'Get started', 'growth' => 'Weekly visibility', 'dominator' => 'Maximum presence'][$key] ?? '') ?></span>
          <h2><?= e($pkg['name']) ?></h2>
          <div class="pc-price">$<?= number_format($pkg['price']) ?><small>/month</small></div>
          <p class="plan3-tag"><?= e($pkg['for']) ?></p>
          <a class="pill <?= $hero ? 'pill-lime' : 'pill-dark' ?> pill-block" href="<?= e(url('done-for-you?package=' . $key)) ?>#request">Choose <?= e($pkg['name']) ?> →</a>
          <ul class="plan3-list"><?php foreach ($pkg['includes'] as $inc): ?><li><?= e($inc) ?></li><?php endforeach; ?></ul>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="pg-note">One social campaign is one original concept adapted into platform-specific posts. All packages require customer-provided business information and assets; original video production and on-site photography are excluded. Elite niche directories are available separately at $99/month, subject to approval.</p>
  </div>
</section>

<!-- PROCESS -->
<section class="hx-dark">
  <div class="container">
    <div class="hx-split-head">
      <div>
        <p class="hx-eyebrow light">How it works</p>
        <h2 class="hx-display md"><span class="white">Four steps.</span><span class="lime">Zero marketing homework.</span></h2>
      </div>
      <p class="hx-side">You stay in control of what goes out. We handle everything else.</p>
    </div>
    <div class="value-grid four">
      <?php foreach ($steps as [$n, $t, $d]): ?>
        <div class="value-card"><span class="value-num"><?= e($n) ?></span><h3><?= e($t) ?></h3><p><?= e($d) ?></p></div>
      <?php endforeach; ?>
    </div>
    <div class="inc-grid">
      <div class="inc-card">
        <h3>Included</h3>
        <ul class="inc-list yes">
          <li>Monthly campaign planning</li><li>Platform-specific posts for each network</li><li>Website articles</li><li>Promotional offers</li><li>Scheduling &amp; publishing</li><li>Toutify directory distribution</li><li>Monthly performance report</li><li>Premium membership ($49 value)</li>
        </ul>
      </div>
      <div class="inc-card">
        <h3>Not included</h3>
        <ul class="inc-list no">
          <li>Original video production</li><li>On-site photography</li><li>Paid ad spend</li><li>Elite niche directories ($99/mo, subject to approval)</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- REQUEST FORM -->
<section class="hx-mint" id="request">
  <div class="container req-grid">
    <div>
      <p class="hx-eyebrow">Request a package</p>
      <h2 class="hx-display md"><span class="ink">Let's get you</span><span class="green">posting.</span></h2>
      <p class="hx-side dark">Tell us a little about your business. A content strategist will contact you within one business day to set things up.</p>
      <ul class="hx-checks stack"><li>No obligation, no long contract</li><li>Switch packages any time</li><li>Your content stays yours</li></ul>
    </div>
    <div class="req-card">
      <?php require ROOT . '/app/views/_errors.php'; ?>
      <form method="post" action="<?= e(url('done-for-you')) ?>#request" class="form">
        <?= csrf_field() ?>
        <fieldset>
          <legend>Package</legend>
          <div class="req-pkgs">
            <?php foreach (PACKAGES as $key => $pkg): ?>
              <label class="req-pkg"><input type="radio" name="package" value="<?= e($key) ?>" <?= old('package', $selected) === $key ? 'checked' : '' ?> required><span><b><?= e($pkg['name']) ?></b><small>$<?= number_format($pkg['price']) ?>/mo</small></span></label>
            <?php endforeach; ?>
          </div>
        </fieldset>
        <div class="row-2">
          <label>Your name<input name="name" required autocomplete="name" value="<?= e(old('name', $user['name'] ?? '')) ?>"></label>
          <label>Email<input type="email" name="email" required autocomplete="email" value="<?= e(old('email', $user['email'] ?? '')) ?>"></label>
        </div>
        <div class="row-2">
          <label>Phone<input name="phone" autocomplete="tel" value="<?= e(old('phone')) ?>"></label>
          <label>Business name<input name="business" autocomplete="organization" value="<?= e(old('business')) ?>"></label>
        </div>
        <label>Anything we should know?<textarea name="message" rows="4" placeholder="Services, service area, goals, current marketing…"><?= e(old('message')) ?></textarea></label>
        <button class="pill pill-dark pill-block" type="submit">Send my request →</button>
      </form>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="hx-faq">
  <div class="container hx-faq-grid">
    <div>
      <p class="hx-eyebrow">Questions</p>
      <h2 class="hx-display sm"><span class="ink">Before you</span><span class="green">sign up.</span></h2>
    </div>
    <div class="faq-list">
      <?php foreach ($dfyFaqs as $i => [$q, $a]): ?>
        <details<?= $i === 0 ? ' open' : '' ?>><summary><?= e($q) ?></summary><p><?= e($a) ?></p></details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="hx-final">
  <div class="container">
    <div class="hx-final-card">
      <div>
        <h2 class="hx-display sm"><span class="ink">Rather do it yourself?</span><span class="white">Start free.</span></h2>
        <p>Create your own content with ContentVendor for $0, and upgrade whenever you're ready.</p>
      </div>
      <a class="pill pill-dark" href="<?= e(url('register')) ?>">Create my free account →</a>
    </div>
  </div>
</section>
