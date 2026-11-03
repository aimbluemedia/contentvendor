<?php
$dfyFaqs = [
    ['What is a "social campaign"?', 'One original idea, like this month\'s offer or a finished job, adapted into posts for each of your networks.'],
    ['What do you need from me?', 'Your business details, any offers you want to run, and photos of your work if you have them. We handle the rest.'],
    ['Do I approve everything?', 'Yes. Drafts arrive in your ContentVendor library to approve or edit, or you can tell us to publish without review.'],
    ['Is video production or photography included?', 'No. We write video scripts and work with the photos you provide.'],
    ['Is there a contract?', 'No. Packages are month to month.'],
];
?>
<section class="m-hero">
  <div class="container m-hero-grid">
    <div class="m-hero-copy">
      <span class="m-eyebrow">Done-for-you content</span>
      <h1>We write it. <span class="m-hl">You approve it.</span></h1>
      <p class="m-lead">No time for marketing? Our team plans, writes, schedules and reports on your content, so you stay visible every week without lifting a finger.</p>
      <div class="m-cta">
        <a class="m-btn m-btn-primary" href="#request">Request a package</a>
        <a class="m-btn m-btn-light" href="#packages">See packages</a>
      </div>
      <ul class="m-ticks"><li>Premium membership included</li><li>Month to month</li><li>Monthly report</li></ul>
    </div>
    <div class="m-hero-visual" aria-hidden="true">
      <div class="m-card">
        <div class="m-card-head"><b>Ready for your approval</b><span class="m-pill">3 new</span></div>
        <ul class="m-gen-list">
          <li><span>👍</span>Spring cleanup special<em>Approve</em></li>
          <li><span>📝</span>5 signs your sprinklers need repair<em>Approve</em></li>
          <li><span>🎬</span>Before &amp; after: Mesa backyard<em class="done">Scheduled</em></li>
        </ul>
        <div class="m-mini-stats"><div><b>32</b><span>posts</span></div><div><b>4</b><span>articles</span></div><div><b>6</b><span>networks</span></div></div>
      </div>
    </div>
  </div>
</section>

<section class="m-section m-alt" id="packages">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">Packages</span>
      <h2>Pick your pace. We do the rest.</h2>
      <p>Every package includes the $49 Premium membership.</p>
    </div>
    <div class="m-plans">
      <?php foreach (PACKAGES as $key => $pkg): $hero = !empty($pkg['featured']); ?>
        <div class="m-plan<?= $hero ? ' hero' : '' ?>">
          <?php if ($hero): ?><span class="m-plan-badge">Most popular</span><?php endif; ?>
          <h3><?= e($pkg['name']) ?></h3>
          <p class="m-plan-tag"><?= e($pkg['for']) ?></p>
          <div class="m-price">$<?= number_format($pkg['price']) ?><small>/month</small></div>
          <a class="m-btn <?= $hero ? 'm-btn-primary' : 'm-btn-light' ?> m-btn-block" href="<?= e(url('done-for-you?package=' . $key)) ?>#request">Choose <?= e($pkg['name']) ?></a>
          <ul><?php foreach ($pkg['includes'] as $inc): ?><li><?= e($inc) ?></li><?php endforeach; ?></ul>
        </div>
      <?php endforeach; ?>
    </div>
    <p class="m-center m-muted m-small">A campaign is one idea adapted for each network. Original video and on-site photography are not included. Elite niche directories: $99/mo, subject to approval.</p>
  </div>
</section>

<section class="m-section">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">How it works</span>
      <h2>Four simple steps.</h2>
    </div>
    <div class="m-steps four">
      <div class="m-step"><span>1</span><h3>Tell us about you</h3><p>A short call to set up your business profile.</p></div>
      <div class="m-step"><span>2</span><h3>We plan your month</h3><p>Campaigns built around your seasons and offers.</p></div>
      <div class="m-step"><span>3</span><h3>You approve</h3><p>Review and edit drafts from any device.</p></div>
      <div class="m-step"><span>4</span><h3>We publish &amp; report</h3><p>Posts go out on schedule. A report every month.</p></div>
    </div>
  </div>
</section>

<section class="m-section m-alt" id="request">
  <div class="container m-req">
    <div>
      <span class="m-eyebrow">Get started</span>
      <h2>Request a package</h2>
      <p class="m-muted">A content strategist will contact you within one business day.</p>
      <ul class="m-ticks stack"><li>No long contract</li><li>Switch packages any time</li><li>Your content stays yours</li></ul>
    </div>
    <div class="m-card m-form-card">
      <?php require ROOT . '/app/views/_errors.php'; ?>
      <form method="post" action="<?= e(url('done-for-you')) ?>#request" class="form">
        <?= csrf_field() ?>
        <fieldset>
          <legend>Package</legend>
          <div class="m-pkg-pick">
            <?php foreach (PACKAGES as $key => $pkg): ?>
              <label><input type="radio" name="package" value="<?= e($key) ?>" <?= old('package', $selected) === $key ? 'checked' : '' ?> required><span><b><?= e($pkg['name']) ?></b><small>$<?= number_format($pkg['price']) ?>/mo</small></span></label>
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
        <label>Anything we should know?<textarea name="message" rows="3" placeholder="Services, area, goals…"><?= e(old('message')) ?></textarea></label>
        <button class="m-btn m-btn-primary m-btn-block" type="submit">Send my request</button>
      </form>
    </div>
  </div>
</section>

<section class="m-section">
  <div class="container m-faq">
    <div class="m-head left"><span class="m-eyebrow">FAQ</span><h2>Before you sign up.</h2></div>
    <div class="m-faq-list">
      <?php foreach ($dfyFaqs as $i => [$q, $a]): ?>
        <details<?= $i === 0 ? ' open' : '' ?>><summary><?= e($q) ?></summary><p><?= e($a) ?></p></details>
      <?php endforeach; ?>
    </div>
  </div>
</section>
