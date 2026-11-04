<?php
$freeTools = [
    ['✨', 'AI Campaign Builder', 'Type one idea and get posts for every channel at once.'],
    ['📝', 'Article Writer', 'Helpful local articles that answer the questions customers search for.'],
    ['💬', 'Social Post Writer', 'Facebook, Instagram and Pinterest posts written for each network.'],
    ['📍', 'Google Business Updates', 'Keep your Google profile fresh so customers see you\'re open and active.'],
    ['🏷️', 'Offer Builder', 'Turn a special into a promotion with a clear call to action.'],
    ['🎬', 'Video Script Writer', 'Short Reels and TikTok scripts: what to film and what to say.'],
];
$paidTools = ['Scheduling', 'Content calendar', 'Repurpose content', 'Branded images', 'AI monthly planner', 'Directory distribution'];
$faqs = [
    ['Is it really free?', 'Yes. The Starter plan is $0 forever: 5 AI content pieces a month, the Campaign Builder and your content library. No credit card.'],
    ['How does this help me show up in Google and AI search?', 'Search engines and AI assistants favor businesses with fresh, helpful and consistent information. ContentVendor makes it easy to publish that every week. No one can guarantee rankings or AI recommendations, but staying active and useful is the foundation.'],
    ['I\'m not a marketer. Can I use this?', 'That\'s who it\'s built for. Pick a goal, type one sentence about your business, and approve the drafts. No prompts or SEO knowledge needed.'],
    ['Do I pay separately from Toutify?', 'No. ContentVendor plans are part of your Toutify membership.'],
    ['Can someone just do it for me?', 'Yes. Our team can handle everything, starting at $299/month.'],
];
?>

<!-- HERO -->
<?php
$heroPhoto = asset('img/hero-owner.webp');
foreach (['webp', 'jpg', 'png'] as $ext) {
    if (is_file(ROOT . '/assets/img/hero-owner.' . $ext)) { $heroPhoto = asset('img/hero-owner.' . $ext); break; }
}
$thumbSign = asset('img/thumb-sign.webp');
$thumbOwner = asset('img/thumb-owner.webp');
?>
<section class="th-hero" aria-label="ContentVendor for small businesses">
  <div class="th-wrap">
    <div class="th-copy">
      <div class="th-eyebrow"><span class="th-spark">✦</span> AI + Search + Social + Leads, in One Platform</div>
      <p class="th-label">FOR SMALL BUSINESSES</p>
      <h1>Create Content Today That Gets&nbsp;You <span class="th-accent">Found Tomorrow.</span></h1>
      <p class="th-intro">ContentVendor's AI writes the posts, articles and updates that keep your business visible on Google, AI search and social media, building an online presence that keeps bringing in leads.</p>
      <div class="th-actions">
        <a class="th-btn th-btn-primary" href="<?= e(url('register')) ?>">Get Started Free <span aria-hidden="true">→</span></a>
        <a class="th-btn th-btn-outline" href="#how-it-works"><span class="th-play" aria-hidden="true">▶</span> See How It Works</a>
      </div>
      <div class="th-proof"><span><b class="th-tick">✓</b> More Visibility</span><span><b class="th-tick">✓</b> More Engagement</span><span><b class="th-tick">✓</b> More Leads</span></div>
    </div>
    <div class="th-visual" aria-label="Illustrative example of marketing results across AI, search and social media">
      <div class="th-photo">
        <img src="<?= e($heroPhoto) ?>" alt="Smiling small business owner at her laptop in front of a Desert Turf Pros sign" fetchpriority="high">
      </div>
      <article class="th-card th-chatgpt"><div class="th-card-head"><span class="th-logo th-logo-gpt">✳</span> ChatGPT</div><div class="th-bubble">“Best turf installer near Phoenix?”</div><div class="th-answer">✦ &nbsp;I recommend <strong>Desert Turf Pros</strong> for professional turf installation in Phoenix.</div></article>
      <article class="th-card th-google"><div class="th-card-head"><span class="th-logo th-logo-google">G</span> Google</div><div class="th-row"><img class="th-thumb" src="<?= e($thumbSign) ?>" alt="" loading="lazy"><div class="th-meta"><strong>Desert Turf Pros</strong><br><span class="th-star">★</span> <strong>4.9 stars</strong><br><span class="th-status">● Open now</span></div></div></article>
      <article class="th-card th-facebook"><div class="th-card-head"><span class="th-logo th-logo-facebook">f</span> Facebook</div><div class="th-row"><img class="th-thumb" src="<?= e($thumbOwner) ?>" alt="" loading="lazy"><div class="th-meta"><span class="th-num">128 likes</span> and <span class="th-num">24 comments</span> on the $200-off post.</div></div></article>
      <article class="th-card th-tiktok"><div class="th-card-head"><span class="th-logo th-logo-tiktok">♪</span> TikTok</div><div class="th-row"><div class="th-icon th-icon-dark">▶</div><div class="th-meta"><span class="th-num">12.4K views</span> on a before-and-after video.</div></div></article>
      <article class="th-card th-reddit"><div class="th-card-head"><span class="th-logo th-logo-reddit">●</span> Reddit</div><div class="th-row"><span class="th-upvote">↑</span><div class="th-meta"><span class="th-num">86 upvotes</span><br>on r/phoenix.</div></div></article>
      <article class="th-card th-lead"><div class="th-card-head"><span class="th-logo th-logo-lead">♙</span> New quote request</div><div class="th-row"><span class="th-icon">✉</span><p>A new quote request just came in from your website.</p></div></article>
    </div>
  </div>
</section>
<!-- Illustrative marketing data only; these mock metrics and AI answers are examples, not real results. -->

<!-- CALCULATOR -->
<?php
$platforms = [
    // key => [label, icon, color, group, default]
    'google'     => ['Google', 'G', '#4285f4', 'social', true],
    'facebook'   => ['Facebook', 'f', '#1877f2', 'social', true],
    'instagram'  => ['Instagram', '◎', '#e1306c', 'social', true],
    'tiktok'     => ['TikTok', '♪', '#111111', 'social', false],
    'youtube'    => ['YouTube', '▶', '#ff0000', 'social', false],
    'reddit'     => ['Reddit', '●', '#ff4500', 'social', false],
    'pinterest'  => ['Pinterest', 'P', '#e60023', 'social', false],
    'chatgpt'    => ['ChatGPT', '✳', '#10a37f', 'ai', true],
    'perplexity' => ['Perplexity', '✺', '#20808d', 'ai', false],
    'claude'     => ['Claude', '✶', '#d97757', 'ai', false],
    'gemini'     => ['Gemini', '✦', '#4f7cff', 'ai', false],
];
?>
<section class="cz" id="calculator">
  <div class="container">
    <div class="cz-head">
      <span class="m-eyebrow">Free content analysis</span>
      <h2>See how visible <span class="cz-hl">your business is online</span></h2>
      <p>Enter your website and get a free report: what customers find today, what's missing, and exactly how much content you need each month.</p>
    </div>

    <div class="cz-grid" data-calc data-scan-url="<?= e(url('scan')) ?>">
      <form class="cz-form" novalidate>
        <?= csrf_field() ?>
        <div class="cz-form-head">
          <span class="cz-form-ic" aria-hidden="true">📈</span>
          <div>
            <h3>Get your free content analysis</h3>
            <p>See how customers and AI search find your business today, and the content that gets you found tomorrow.</p>
          </div>
        </div>
        <ul class="cz-gets">
          <li>Visibility score</li>
          <li>What's missing</li>
          <li>Monthly content plan</li>
        </ul>
        <div class="cz-url-block">
          <label class="cz-step" for="cv-website"><span>1</span> Enter your website</label>
          <div class="cz-url">
            <span class="cz-url-ic" aria-hidden="true">🌐</span>
            <input id="cv-website" name="website" type="text" inputmode="url" autocomplete="url" placeholder="yourbusiness.com" required>
          </div>
          <p class="m-field-error" data-scan-error hidden></p>
          <p class="cz-url-note">🔒 Free · No sign-up needed · Takes about 10 seconds</p>
        </div>

        <div class="cz-q">
          <span class="cz-step"><span>2</span> Where do you want to be found?</span>
          <div class="cz-group-label">Search &amp; social</div>
          <div class="cz-chips">
            <?php foreach ($platforms as $k => [$label, $icon, $color, $group, $on]): if ($group !== 'social') continue; ?>
              <label class="cz-chip"><input type="checkbox" name="networks" value="<?= e($k) ?>" data-label="<?= e($label) ?>" data-icon="<?= e($icon) ?>" data-color="<?= e($color) ?>" data-group="social" <?= $on ? 'checked' : '' ?>><span><i style="background:<?= e($color) ?>"><?= e($icon) ?></i><?= e($label) ?></span></label>
            <?php endforeach; ?>
          </div>
          <div class="cz-group-label">AI search assistants</div>
          <div class="cz-chips">
            <?php foreach ($platforms as $k => [$label, $icon, $color, $group, $on]): if ($group !== 'ai') continue; ?>
              <label class="cz-chip"><input type="checkbox" name="networks" value="<?= e($k) ?>" data-label="<?= e($label) ?>" data-icon="<?= e($icon) ?>" data-color="<?= e($color) ?>" data-group="ai" <?= $on ? 'checked' : '' ?>><span><i style="background:<?= e($color) ?>"><?= e($icon) ?></i><?= e($label) ?></span></label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="cz-q">
          <span class="cz-step"><span>3</span> Your posting goal</span>
          <label class="cz-range-label" for="cv-perweek">Social posts per week <output data-out="perweek">3 / week</output></label>
          <input id="cv-perweek" class="m-range" type="range" name="perweek" min="1" max="7" value="3">
          <label class="cz-range-label" for="cv-articles">Website articles per month <output data-out="articles">2</output></label>
          <input id="cv-articles" class="m-range" type="range" name="articles" min="0" max="8" value="2">
        </div>

        <button class="cz-submit" type="submit" data-scan-btn>Get Free Content Analysis <span aria-hidden="true">→</span></button>
      </form>

      <div class="cz-report" data-report aria-live="polite">
        <div class="cz-loading" data-state="loading" hidden>
          <span class="m-spin" aria-hidden="true"></span>
          <p>Analyzing <b data-out="checking"></b>…</p>
          <ul class="cz-steps-list"><li>Reading your website</li><li>Checking search &amp; social links</li><li>Building your content plan</li></ul>
        </div>

        <div data-state="report">
          <div class="cz-rep-top">
            <span class="cz-badge" data-out="badge">Sample report</span>
            <span class="cz-rep-date" data-out="when">Example business</span>
          </div>
          <div class="cz-rep-site">
            <div class="cz-favicon" data-out="initial">D</div>
            <div><b data-out="site">deserturfpros.com</b><small data-out="sub">Landscaping · Phoenix, AZ</small></div>
          </div>

          <div class="cz-score-row">
            <div class="cz-ring" data-ring style="--p:40"><b data-out="score">40</b><small>/100</small></div>
            <div>
              <span class="cz-score-label">Website visibility score</span>
              <strong data-out="band">Fair: gaps competitors can use</strong>
              <p data-out="bandtext">Missing a blog, Instagram and a Google Business Profile link.</p>
            </div>
          </div>

          <div class="cz-box">
            <div class="cz-box-title">What customers find today</div>
            <ul class="cz-checks" data-out="findings">
              <li class="ok">Secure website (HTTPS)</li>
              <li class="ok">Search description for Google</li>
              <li class="miss">Blog or helpful articles</li>
              <li class="ok">Facebook page linked</li>
              <li class="miss">Instagram linked</li>
              <li class="miss">Google Business Profile linked</li>
            </ul>
          </div>

          <div class="cz-box">
            <div class="cz-box-title">Your monthly content plan</div>
            <ul class="cz-plan" data-out="plan"></ul>
          </div>

          <div class="cz-totals">
            <div><b data-out="total">0</b><span>pieces / month</span></div>
            <div><b data-out="diy">0h</b><span>to write yourself</span></div>
            <div class="hl"><b data-out="saved">0h</b><span>saved with AI</span></div>
          </div>

          <div class="cz-cta" data-cta="sample">
            <p>This is an example. <b>See the real numbers for your business.</b></p>
            <button type="button" class="cz-submit ghost" data-focus-url>See my own report <span aria-hidden="true">→</span></button>
          </div>
          <div class="cz-cta" data-cta="real" hidden>
            <p data-out="gap"></p>
            <a class="cz-submit" href="<?= e(url('register')) ?>">Join Free Today <span aria-hidden="true">→</span></a>
            <small>Free forever plan · No credit card</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- NETWORK STRIP -->
<section class="m-strip">
  <div class="container m-strip-inner">
    <span class="m-muted">Part of the Toutify network</span>
    <div class="m-logos"><b>SearchMonster</b><b>MonsterList</b><b>PromoMonster</b><b>LeadCrazy</b><b class="on">ContentVendor</b></div>
  </div>
</section>

<!-- WHY -->
<section class="m-section">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">Why it matters</span>
      <h2>Quiet businesses get passed over.</h2>
      <p>When a customer compares two local businesses, the one with fresh posts, helpful answers and recent updates looks like the safer choice to people, to Google and to AI assistants.</p>
    </div>
    <div class="m-grid3">
      <div class="m-feature"><span class="m-ic">🔎</span><h3>Customers search first</h3><p>Before they call, they look you up. An empty profile or a post from last year sends them to someone else.</p></div>
      <div class="m-feature"><span class="m-ic">🤖</span><h3>AI search is the new word of mouth</h3><p>Assistants like ChatGPT and Google's AI answers draw on helpful, consistent information about your business.</p></div>
      <div class="m-feature"><span class="m-ic">📈</span><h3>Consistency turns into leads</h3><p>Posting a little every week beats a big push once a year, and ContentVendor makes every week take minutes.</p></div>
    </div>
  </div>
</section>

<!-- FREE TOOLS -->
<section class="m-section m-alt" id="tools">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">Free AI tools</span>
      <h2>Everything you need to stay visible, free.</h2>
      <p>Each tool uses your business profile, so the content sounds like you and never needs retyping.</p>
    </div>
    <div class="m-grid3">
      <?php foreach ($freeTools as [$ic, $name, $text]): ?>
        <div class="m-tool"><span class="m-ic"><?= $ic ?></span><div><h3><?= e($name) ?> <span class="m-free">Free</span></h3><p><?= e($text) ?></p></div></div>
      <?php endforeach; ?>
    </div>
    <div class="m-more">
      <span>On Pro &amp; Premium:</span>
      <?php foreach ($paidTools as $t): ?><em><?= e($t) ?></em><?php endforeach; ?>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="m-section" id="how-it-works">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">How it works</span>
      <h2>From idea to posted in three steps.</h2>
    </div>
    <div class="m-steps">
      <div class="m-step"><span>1</span><h3>Add your business</h3><p>Your name, services and area, entered once.</p></div>
      <div class="m-step"><span>2</span><h3>Type one idea</h3><p>“20% off spring cleanups.” Pick where it should go.</p></div>
      <div class="m-step"><span>3</span><h3>Approve and post</h3><p>Edit if you like, then copy, download or schedule.</p></div>
    </div>
  </div>
</section>

<!-- PRICING -->
<section class="m-section">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">Pricing</span>
      <h2>Start free. Upgrade when it pays off.</h2>
      <p>Included with your Toutify membership. No separate ContentVendor bill.</p>
    </div>
    <?php require ROOT . '/app/views/_plan_cards.php'; ?>
    <p class="m-center m-muted m-small">Rather have it done for you? <a href="<?= e(url('done-for-you')) ?>">Done-for-you packages from $299/mo →</a></p>
  </div>
</section>

<!-- FAQ -->
<section class="m-section m-alt">
  <div class="container m-faq">
    <div class="m-head left">
      <span class="m-eyebrow">FAQ</span>
      <h2>Questions, answered.</h2>
    </div>
    <div class="m-faq-list">
      <?php foreach ($faqs as $i => [$q, $a]): ?>
        <details<?= $i === 0 ? ' open' : '' ?>><summary><?= e($q) ?></summary><p><?= e($a) ?></p></details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FINAL CTA -->
<section class="m-section">
  <div class="container">
    <div class="m-final">
      <h2>Your competitors posted this week. Did you?</h2>
      <p>Create your free account and publish your first campaign in minutes.</p>
      <a class="m-btn m-btn-primary" href="<?= e(url('register')) ?>">Start free, no card needed</a>
    </div>
  </div>
</section>
