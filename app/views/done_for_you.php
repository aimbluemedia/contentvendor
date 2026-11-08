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
      <?php $dfyMin = min(array_column(PACKAGES, 'price')); $dfyDay = (int) floor($dfyMin * 12 / 365) + 1; ?>
      <h1>For under $<?= $dfyDay ?> a day, we handle your content. <span>You make more money doing what you do best.</span></h1>
      <p class="dfy-lead">Every hour you spend writing posts is an hour you're not serving customers or winning new jobs. Our team uses AI to plan, write and publish your content and social media every month, so you're free to grow your business.</p>
      <div class="dfy-cta">
        <a class="dfy-btn" href="#request">Free up my time <span aria-hidden="true">→</span></a>
        <a class="dfy-btn ghost" href="#packages">See packages</a>
      </div>
      <ul class="dfy-trust">
        <li><b>Under $<?= $dfyDay ?>/day</b><span>from $<?= number_format($dfyMin) ?>/month</span></li>
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
      <div class="dfy-ov o3" aria-hidden="true"><span class="dfy-ov-ic"><svg viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm1 5h-2v6.1l4.6 2.8 1-1.7-3.6-2.2z"/></svg></span><div><b>20+ hours</b><small>back this month</small></div></div>
    </div>
  </div>
  <div class="container">
    <div class="dfy-strip"><span>We create for</span><?php foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'google_business' => 'Google Business', 'tiktok' => 'TikTok', 'youtube' => 'YouTube', 'pinterest' => 'Pinterest', 'reddit' => 'Reddit', 'article' => 'Your website'] as $k => $l): ?><b class="tk-pl tk-pl-<?= $k ?>"><?= $l ?></b><?php endforeach; ?></div>
  </div>
</section>

<section class="dfy-fomo">
  <div class="dfy-fomo-bg" aria-hidden="true"></div>
  <div class="container">
    <div class="dfy-fomo-head">
      <span class="dfy-fomo-pill"><i></i> While you read this, your competitors are posting</span>
      <h2>Every week you go quiet, <span>a competitor gets your customer.</span></h2>
      <p>Customers check Google, social media and AI assistants before they call. The business that shows up every week is the one they remember. Which one sounds like you?</p>
    </div>

    <div class="dfy-duo">
      <article class="dfy-side">
        <div class="dfy-side-top">
          <span class="dfy-side-tag">You do it yourself</span>
          <span class="dfy-side-ic" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M20.5 14.6A8.5 8.5 0 1 1 9.4 3.5a7 7 0 0 0 11.1 11.1z"/></svg></span>
        </div>
        <h3>Stop writing posts at 10pm.</h3>
        <p class="dfy-side-pain">Marketing happens after the real work, if it happens at all. Then you get busy, the posts stop, and customers forget you.</p>
        <div class="dfy-cost">
          <span>What it costs you now</span>
          <div class="dfy-cost-row"><b>~20 hrs</b><small>a month writing, designing and posting</small></div>
          <div class="dfy-cost-row"><b>Weeks</b><small>of silence every time you get busy</small></div>
        </div>
        <ul class="dfy-gain">
          <li>We plan, write and publish your whole month</li>
          <li>You approve from your phone in minutes</li>
          <li>You stay visible, even in your busiest season</li>
        </ul>
        <div class="dfy-wait"><span>Every month you wait:</span> another ~20 hours gone</div>
        <a class="dfy-side-btn" href="#request">Give me my time back <span aria-hidden="true">→</span></a>
      </article>

      <div class="dfy-vs" aria-hidden="true">or</div>

      <article class="dfy-side gold">
        <div class="dfy-side-top">
          <span class="dfy-side-tag">You pay someone to do it</span>
          <span class="dfy-side-ic" aria-hidden="true"><svg viewBox="0 0 24 24"><path fill-rule="evenodd" d="M2 6h20v12H2zm10 3a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/></svg></span>
        </div>
        <h3>Save $1,000–$2,000 a month.</h3>
        <p class="dfy-side-pain">A part-time social media employee costs about $2,000–$2,800 a month with payroll taxes, and it all stops when they're sick, on vacation or quit.</p>
        <div class="dfy-cost">
          <span>Monthly cost</span>
          <div class="dfy-vsbar"><em>Employee</em><div><i class="emp" style="width:100%"></i></div><b>~$2,500</b></div>
          <div class="dfy-vsbar"><em>Our team</em><div><i class="us" style="width:30%"></i></div><b>$<?= number_format(PACKAGES['growth']['price']) ?></b></div>
          <div class="dfy-keep"><span>Put back in your pocket</span><b>~$1,750/mo</b></div>
        </div>
        <ul class="dfy-gain">
          <li>A whole content team, no hiring or training</li>
          <li>More output: up to 20 campaigns on 6 networks</li>
          <li>Move the savings into ads and grow faster</li>
        </ul>
        <div class="dfy-wait"><span>Every month you wait:</span> ~$1,750 more on payroll</div>
        <a class="dfy-side-btn" href="#request">Show me the savings <span aria-hidden="true">→</span></a>
      </article>
    </div>

    <div class="dfy-claim">
      <div><span class="dfy-claim-dot" aria-hidden="true"></span><p><b>We take on a limited number of new businesses each month</b> so every client gets real attention.</p></div>
      <a href="#request">Claim my spot <span aria-hidden="true">→</span></a>
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
