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

<?php
// Savings calculator defaults (the same maths runs live in the browser)
$calcPk = [];
foreach (PACKAGES as $k => $pk) $calcPk[] = ['key' => $k, 'name' => $pk['name'], 'price' => (int) $pk['price']];
$calcCap = ['starter' => 12, 'growth' => 40, 'dominator' => 120]; // approx. posts a month each package covers
?>
<section class="dfy-fomo dfy-calc-sec" id="calculator">
  <div class="dfy-fomo-bg" aria-hidden="true"></div>
  <div class="container">
    <div class="dfy-fomo-head">
      <span class="dfy-fomo-pill"><i></i> While you read this, your competitors are posting</span>
      <h2>What is your content really costing you? <span>Find out in 10 seconds.</span></h2>
      <p>Move the sliders to match what you do today. We'll show what you'd save, and how many hours you'd get back.</p>
    </div>

    <div class="dfy-calc" data-dfy-calc data-packages='<?= e(json_encode($calcPk)) ?>' data-caps='<?= e(json_encode($calcCap)) ?>'>
      <div class="dfy-calc-in">
        <div class="dfy-sl">
          <div class="dfy-sl-top"><label for="c-posts">Posts you want each month</label><output data-out="posts">20 posts</output></div>
          <input id="c-posts" type="range" min="4" max="120" step="2" value="20" data-in="posts">
          <div class="dfy-sl-scale"><span>4</span><span>120</span></div>
        </div>
        <div class="dfy-sl">
          <div class="dfy-sl-top"><label for="c-pay">What you pay for content now</label><output data-out="pay">$0 / month</output></div>
          <input id="c-pay" type="range" min="0" max="5000" step="50" value="0" data-in="pay">
          <div class="dfy-sl-scale"><span>$0 (I do it myself)</span><span>$5,000</span></div>
        </div>
        <div class="dfy-sl">
          <div class="dfy-sl-top"><label for="c-hours">Hours you spend on it each week</label><output data-out="hours">6 hrs / week</output></div>
          <input id="c-hours" type="range" min="0" max="25" step="1" value="6" data-in="hours">
          <div class="dfy-sl-scale"><span>0</span><span>25 hrs</span></div>
        </div>
        <div class="dfy-sl">
          <div class="dfy-sl-top"><label for="c-rate">What an hour of your time is worth</label><output data-out="rate">$50 / hour</output></div>
          <input id="c-rate" type="range" min="20" max="250" step="5" value="50" data-in="rate">
          <div class="dfy-sl-scale"><span>$20</span><span>$250</span></div>
        </div>
      </div>

      <div class="dfy-calc-out" aria-live="polite">
        <span class="dfy-calc-k">Your monthly savings</span>
        <div class="dfy-calc-big" data-out="save">$0</div>
        <p class="dfy-calc-yr" data-out="year">That's $0 a year back in your business.</p>
        <div class="dfy-calc-grid">
          <div><b data-out="hrsback">26 hrs</b><span>back every month</span></div>
          <div><b data-out="now">$1,300</b><span>true cost today</span></div>
          <div><b data-out="pkg">Content Growth</b><span data-out="pkgprice">$749/mo · under $25/day</span></div>
        </div>
        <div class="dfy-calc-wait" data-out="wait">Every month you wait costs you $0.</div>
        <a class="dfy-btn" href="<?= e(url('done-for-you?package=growth')) ?>#request" data-out="cta">Claim these savings <span aria-hidden="true">→</span></a>
        <small class="dfy-calc-note">Estimate only. True cost today = what you pay + your hours × what your time is worth. We recommend the package that covers your posts.</small>
      </div>
    </div>

    <div class="dfy-claim">
      <div><span class="dfy-claim-dot" aria-hidden="true"></span><p><b>We take on a limited number of new businesses each month</b> so every client gets real attention.</p></div>
      <a href="#request">Claim my spot <span aria-hidden="true">→</span></a>
    </div>
  </div>
</section>
<script>
(function () {
  var root = document.querySelector('[data-dfy-calc]');
  if (!root) return;
  var pk = JSON.parse(root.getAttribute('data-packages')), caps = JSON.parse(root.getAttribute('data-caps'));
  var base = <?= json_encode(url('done-for-you')) ?>;
  var $ = function (k) { return root.querySelector('[data-in="' + k + '"]'); };
  var out = function (k) { return root.querySelector('[data-out="' + k + '"]'); };
  var money = function (n) { return (n < 0 ? '-$' : '$') + Math.abs(Math.round(n)).toLocaleString('en-US'); };
  function fill(el) { el.style.setProperty('--p', ((el.value - el.min) / (el.max - el.min) * 100) + '%'); }
  function calc() {
    var posts = +$('posts').value, pay = +$('pay').value, hours = +$('hours').value, rate = +$('rate').value;
    ['posts', 'pay', 'hours', 'rate'].forEach(function (k) { fill($(k)); });
    out('posts').textContent = posts + ' posts';
    out('pay').textContent = money(pay) + ' / month';
    out('hours').textContent = hours + ' hrs / week';
    out('rate').textContent = money(rate) + ' / hour';
    var pick = pk[pk.length - 1];
    for (var i = 0; i < pk.length; i++) { if (posts <= (caps[pk[i].key] || 0)) { pick = pk[i]; break; } }
    var hrsMonth = Math.round(hours * 52 / 12);
    var now = pay + hrsMonth * rate;
    var save = now - pick.price;
    out('save').textContent = save > 0 ? money(save) : '$0';
    out('save').classList.toggle('neg', save <= 0);
    out('year').textContent = save > 0 ? "That's " + money(save * 12) + ' a year back in your business.' : 'You get ' + hrsMonth + ' hours back for ' + money(-save) + ' more a month.';
    out('hrsback').textContent = hrsMonth + ' hrs';
    out('now').textContent = money(now);
    out('pkg').textContent = pick.name;
    out('pkgprice').textContent = money(pick.price) + '/mo · under ' + money(Math.floor(pick.price * 12 / 365) + 1) + '/day';
    out('wait').textContent = save > 0 ? 'Every month you wait costs you ' + money(save) + '.' : 'Every month you wait is another ' + hrsMonth + ' hours of your time.';
    out('cta').setAttribute('href', base + '?package=' + pick.key + '#request');
  }
  root.addEventListener('input', calc);
  calc();
})();
</script>

<section class="m-section dfy-pk-sec" id="packages">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">Packages</span>
      <h2>Pick your pace. <span class="dfy-pk-hl">We do the rest.</span></h2>
      <p>Every package includes the $49.99 Premium membership. No contract, cancel any time.</p>
    </div>
    <?php
    $pkOut = ['starter' => 'Up to 12 posts + 1 article', 'growth' => 'Up to 40 posts + 4 articles', 'dominator' => 'Up to 120 posts + 4 articles'];
    $pkIcon = [
        'starter'   => '<path d="M12 2l2.6 6.4L21 9l-5 4.4L17.5 20 12 16.6 6.5 20 8 13.4 3 9l6.4-.6z"/>',
        'growth'    => '<path d="M3 20h4v-7H3zm7 0h4V9h-4zm7 0h4V4h-4z"/>',
        'dominator' => '<path d="M5 16 3 6l5.5 4L12 4l3.5 6L21 6l-2 10zm0 2h14v2H5z"/>',
    ];
    ?>
    <div class="dfy-pk">
      <?php foreach (PACKAGES as $key => $pkg): $hero = !empty($pkg['featured']); $day = (int) floor($pkg['price'] * 12 / 365) + 1; ?>
        <article class="dfy-pk-card<?= $hero ? ' is-hero' : '' ?>">
          <?php if ($hero): ?><span class="dfy-pk-badge">Most popular</span><?php endif; ?>
          <div class="dfy-pk-top">
            <span class="dfy-pk-ic" aria-hidden="true"><svg viewBox="0 0 24 24"><?= $pkIcon[$key] ?? $pkIcon['starter'] ?></svg></span>
            <h3><?= e($pkg['name']) ?></h3>
          </div>
          <p class="dfy-pk-for"><?= e($pkg['for']) ?></p>
          <div class="dfy-pk-price"><b>$<?= number_format($pkg['price']) ?></b><span>/month</span></div>
          <span class="dfy-pk-day">Under $<?= $day ?> a day</span>
          <div class="dfy-pk-out"><span>Each month you get</span><b><?= e($pkOut[$key] ?? '') ?></b></div>
          <a class="dfy-pk-btn" href="<?= e(url('done-for-you?package=' . $key)) ?>#request">Choose <?= e($pkg['name']) ?> <span aria-hidden="true">→</span></a>
          <ul class="dfy-pk-list"><?php foreach ($pkg['includes'] as $inc): ?><li><?= e($inc) ?></li><?php endforeach; ?></ul>
        </article>
      <?php endforeach; ?>
    </div>
    <ul class="dfy-pk-trust">
      <li><svg viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm-1.2 13.6 6-6-1.4-1.4-4.6 4.6-2.2-2.2-1.4 1.4z"/></svg>You approve every post</li>
      <li><svg viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm1 5h-2v6.1l4.6 2.8 1-1.7-3.6-2.2z"/></svg>Month to month, no contract</li>
      <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2 4 5v6c0 5 3.4 9.4 8 11 4.6-1.6 8-6 8-11V5z"/></svg>Premium membership included</li>
      <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h16v12H8l-4 4z"/></svg>Strategist call within 1 business day</li>
    </ul>
    <p class="m-center m-muted m-small">A campaign is one idea adapted for each network. Post counts are approximate. Original video and on-site photography are not included. Elite niche directories: $99/mo, subject to approval.</p>
  </div>
</section>

<section class="m-section dfy-try">
  <div class="container">
    <div class="dfy-try-card">
      <div class="dfy-try-copy">
        <span class="dfy-try-tag">First month free</span>
        <h2>Try us for one month. <span>Stay because it works.</span></h2>
        <p>Your first month is free, with no long-term contract and no commitment. Give us one month to show what consistent, professional content can do for your business. If it isn't the right fit, you can pause or cancel at any time.</p>
        <a class="dfy-btn" href="#request">Start my free month <span aria-hidden="true">→</span></a>
      </div>
      <ul class="dfy-try-list">
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><path fill-rule="evenodd" d="M6 2h9l5 5v15H6zm8 1.5V8h4.5zM9 12h8v1.6H9zm0 3.5h8v1.6H9z"/></svg></span><div><b>No long-term contract</b><small>Every package is month to month. You're never locked in.</small></div></li>
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zM9 8v8h2V8zm4 0v8h2V8z"/></svg></span><div><b>Pause when you need to</b><small>Slow season or a busy month? Put your package on hold.</small></div></li>
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm-3.5 6.1L7.1 9.5 9.6 12l-2.5 2.5 1.4 1.4 2.5-2.5 2.5 2.5 1.4-1.4-2.5-2.5 2.5-2.5-1.4-1.4-2.5 2.5z"/></svg></span><div><b>Cancel any time</b><small>Just let us know. No questions, no pressure.</small></div></li>
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 2 4 5v6c0 5 3.4 9.4 8 11 4.6-1.6 8-6 8-11V5z"/></svg></span><div><b>Your content stays yours</b><small>Everything we create remains in your ContentVendor library.</small></div></li>
      </ul>
    </div>
  </div>
</section>

<section class="m-section dfy-req-sec" id="request">
  <div class="container dfy-req">
    <aside class="dfy-offer">
      <span class="dfy-offer-tag"><i></i> New client offer</span>
      <h2>Your first month <span>is on us.</span></h2>
      <p>Try Done For You free for one month. Our team plans, writes and publishes your content, and you only continue if you love the results.</p>
      <div class="dfy-offer-save"><span>Your free month is worth up to</span><b>$<?= number_format(max(array_column(PACKAGES, 'price'))) ?></b></div>
      <ol class="dfy-offer-steps">
        <li><b>Send your request</b><small>Takes about a minute.</small></li>
        <li><b>Meet your strategist</b><small>We call you within one business day.</small></li>
        <li><b>Your free month begins</b><small>Approve your first posts from your phone.</small></li>
      </ol>
      <ul class="dfy-offer-trust">
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm-1.2 13.6 6-6-1.4-1.4-4.6 4.6-2.2-2.2-1.4 1.4z"/></svg>No credit card to start</li>
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm-1.2 13.6 6-6-1.4-1.4-4.6 4.6-2.2-2.2-1.4 1.4z"/></svg>No contract</li>
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm-1.2 13.6 6-6-1.4-1.4-4.6 4.6-2.2-2.2-1.4 1.4z"/></svg>Cancel any time</li>
        <li><svg viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm-1.2 13.6 6-6-1.4-1.4-4.6 4.6-2.2-2.2-1.4 1.4z"/></svg>Your content stays yours</li>
      </ul>
    </aside>

    <div class="dfy-form">
      <div class="dfy-form-head">
        <h3>Claim your free month</h3>
        <p>Pick a package. You won't pay anything for the first month.</p>
      </div>
      <?php require ROOT . '/app/views/_errors.php'; ?>
      <form method="post" action="<?= e(url('done-for-you')) ?>#request" class="form dfy-form-body">
        <?= csrf_field() ?>
        <fieldset>
          <legend>1. Choose your package</legend>
          <div class="dfy-pick">
            <?php foreach (PACKAGES as $key => $pkg): ?>
              <label>
                <input type="radio" name="package" value="<?= e($key) ?>" <?= old('package', $selected) === $key ? 'checked' : '' ?> required>
                <span>
                  <?php if (!empty($pkg['featured'])): ?><em>Popular</em><?php endif; ?>
                  <b><?= e(str_replace('Content ', '', $pkg['name'])) ?></b>
                  <small><s>$<?= number_format($pkg['price']) ?></s> <strong>$0</strong> first month</small>
                  <i>then $<?= number_format($pkg['price']) ?>/mo</i>
                </span>
              </label>
            <?php endforeach; ?>
          </div>
        </fieldset>
        <fieldset>
          <legend>2. Tell us about you</legend>
          <div class="row-2">
            <label>Your name<input name="name" required autocomplete="name" placeholder="Jane Smith" value="<?= e(old('name', $user['name'] ?? '')) ?>"></label>
            <label>Email<input type="email" name="email" required autocomplete="email" placeholder="jane@yourbusiness.com" value="<?= e(old('email', $user['email'] ?? '')) ?>"></label>
          </div>
          <div class="row-2">
            <label>Phone<input name="phone" type="tel" autocomplete="tel" placeholder="(555) 123-4567" value="<?= e(old('phone')) ?>"></label>
            <label>Business name<input name="business" autocomplete="organization" placeholder="Your business" value="<?= e(old('business')) ?>"></label>
          </div>
          <label>Anything we should know? <span class="dfy-opt">Optional</span><textarea name="message" rows="3" placeholder="Your services, service area and goals…"><?= e(old('message')) ?></textarea></label>
        </fieldset>
        <button class="dfy-submit" type="submit">Start my free month <span aria-hidden="true">→</span></button>
        <p class="dfy-form-foot">No credit card. No contract. A strategist will contact you within one business day.</p>
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
