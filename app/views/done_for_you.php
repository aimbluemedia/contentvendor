<?php
$dfyFaqs = [
    ['What is a "social campaign"?', 'One original idea, like this month\'s offer or a finished job, adapted into posts for each of your networks.'],
    ['What do you need from me?', 'Your business details, any offers you want to run, and photos of your work if you have them. We handle the rest.'],
    ['Do I approve everything?', 'Yes. Drafts arrive in your ContentVendor library to approve or edit, or you can tell us to publish without review.'],
    ['Is video production or photography included?', 'No. We write video scripts and work with the photos you provide.'],
    ['Is there a contract?', 'No. Packages are month to month.'],
];
?>
<section class="dfy-hero">
  <div class="dfy-hero-bg" aria-hidden="true"></div>
  <div class="container dfy-hero-grid">
    <div class="dfy-hero-copy">
      <span class="dfy-pill"><i></i> Done-for-you content, powered by AI</span>
      <h1>Grow your business with content that keeps you <span>ahead of the competition</span>.</h1>
      <p class="dfy-lead">Our team uses AI to plan, write and publish a full month of content and social media for your business. You show up everywhere customers look, every week, while your competitors go quiet.</p>
      <div class="dfy-cta">
        <a class="dfy-btn" href="#request">Get my monthly content plan <span aria-hidden="true">→</span></a>
        <a class="dfy-btn ghost" href="#packages">See packages</a>
      </div>
      <ul class="dfy-trust">
        <li><b>From $299</b><span>per month</span></li>
        <li><b>You approve</b><span>every post</span></li>
        <li><b>No contract</b><span>month to month</span></li>
      </ul>
    </div>

    <div class="dfy-photo">
      <img src="<?= e(asset('img/hero-owner.webp')) ?>" alt="Smiling small business owner at her laptop while our team handles her content" width="1672" height="941" fetchpriority="high">
      <div class="dfy-ov o1" aria-hidden="true">
        <div class="dfy-ov-head"><b>Ready for your approval</b><span>3 new</span></div>
        <ul>
          <li><i class="tk-pl tk-pl-facebook"></i>Spring cleanup special<em>Approve</em></li>
          <li><i class="tk-pl tk-pl-article"></i>5 signs your yard needs turf<em>Approve</em></li>
          <li><i class="tk-pl tk-pl-tiktok"></i>Before &amp; after: Mesa backyard<em class="ok">Scheduled</em></li>
        </ul>
      </div>
      <div class="dfy-ov o2" aria-hidden="true"><b>You vs. local competitors</b><div class="dfy-bars"><span style="--w:92%">You · 32 posts</span><span style="--w:38%">Competitor A</span><span style="--w:21%">Competitor B</span></div></div>
      <div class="dfy-ov o3" aria-hidden="true"><span>⏱</span><div><b>20+ hours</b><small>back this month</small></div></div>
    </div>
  </div>
  <div class="container">
    <div class="dfy-strip"><span>We create for</span><?php foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'google_business' => 'Google Business', 'tiktok' => 'TikTok', 'youtube' => 'YouTube', 'pinterest' => 'Pinterest', 'reddit' => 'Reddit', 'article' => 'Your website'] as $k => $l): ?><b class="tk-pl tk-pl-<?= $k ?>"><?= $l ?></b><?php endforeach; ?></div>
  </div>
</section>

<section class="m-section dfy-paths">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">Which one sounds like you?</span>
      <h2>Two ways small businesses win with us.</h2>
      <p>Whether you post yourself or pay someone to do it, done-for-you content pays for itself.</p>
    </div>
    <div class="dfy-path-grid">
      <article class="dfy-path">
        <span class="dfy-path-tag">You do it yourself</span>
        <h3>Get your evenings and weekends back.</h3>
        <p>You know you should post, but it happens late at night, after the real work. When you get busy, it stops, and customers forget you.</p>
        <div class="dfy-big"><b>20+ hours</b><span>back every month</span></div>
        <ul class="dfy-list">
          <li><b>We plan your month</b> around your seasons, services and offers.</li>
          <li><b>We write every post</b> for each network, plus website articles.</li>
          <li><b>You approve in minutes</b> from your phone, or let us publish.</li>
          <li><b>You never go quiet</b>, even in your busiest weeks.</li>
        </ul>
        <a class="dfy-btn" href="#request">Give me my time back <span aria-hidden="true">→</span></a>
      </article>

      <article class="dfy-path money">
        <span class="dfy-path-tag">You pay someone to do it</span>
        <h3>Save $1,000 to $2,000 a month in payroll.</h3>
        <p>A part-time employee for social media costs about $2,000–$2,800 a month once you add payroll taxes. Our team does more for a fraction of that.</p>
        <div class="dfy-compare">
          <div class="dfy-row"><span>Part-time employee</span><div class="dfy-meter emp"><i style="width:100%"></i></div><b>~$2,500/mo</b></div>
          <div class="dfy-row"><span>Content Growth</span><div class="dfy-meter us"><i style="width:30%"></i></div><b>$<?= number_format(PACKAGES['growth']['price']) ?>/mo</b></div>
          <div class="dfy-save"><span>You keep</span><b>~$1,750 a month</b></div>
        </div>
        <ul class="dfy-list">
          <li><b>No hiring, training or sick days.</b> A whole team, not one person.</li>
          <li><b>More output:</b> up to 20 campaigns on 6 networks every month.</li>
          <li><b>Put the savings into advertising</b> and grow even faster.</li>
        </ul>
        <a class="dfy-btn" href="#request">Show me the savings <span aria-hidden="true">→</span></a>
      </article>
    </div>
  </div>
</section>

<section class="m-section m-alt" id="packages">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">Packages</span>
      <h2>Pick your pace. We do the rest.</h2>
      <p>Every package includes the $49.99 Premium membership.</p>
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
