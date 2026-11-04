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
<section class="m-section m-alt m-calc-section" id="calculator">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">Free content calculator</span>
      <h2>How much content does your business need?</h2>
      <p>Enter your website and we'll check what's working, what's missing, and how much content keeps you ahead of competitors.</p>
    </div>
    <div class="m-calc" data-calc data-scan-url="<?= e(url('scan')) ?>">
      <form class="m-calc-form" novalidate>
        <?= csrf_field() ?>
        <div class="m-q">
          <label class="m-q-label" for="cv-website">Your website</label>
          <div class="m-url">
            <span aria-hidden="true">🌐</span>
            <input id="cv-website" name="website" type="text" inputmode="url" autocomplete="url" placeholder="yourbusiness.com" required>
          </div>
          <p class="m-field-error" data-scan-error hidden></p>
        </div>
        <div class="m-q">
          <span class="m-q-label">Where do you want to show up?</span>
          <div class="m-chips">
            <?php foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'google' => 'Google', 'pinterest' => 'Pinterest', 'directory' => 'Directories', 'email' => 'Email', 'video' => 'Video'] as $k => $n): ?>
              <label class="m-chip"><input type="checkbox" name="networks" value="<?= e($k) ?>" <?= in_array($k, ['facebook', 'instagram', 'google'], true) ? 'checked' : '' ?>><span><?= e($n) ?></span></label>
            <?php endforeach; ?>
          </div>
        </div>
        <div class="m-q">
          <label class="m-q-label" for="cv-perweek">How often should you post? <output data-out="perweek">3 / week</output></label>
          <input id="cv-perweek" class="m-range" type="range" name="perweek" min="1" max="7" value="3">
        </div>
        <div class="m-q">
          <label class="m-q-label" for="cv-articles">Website articles per month <output data-out="articles">2</output></label>
          <input id="cv-articles" class="m-range" type="range" name="articles" min="0" max="8" value="2">
        </div>
        <button class="m-btn m-btn-primary m-btn-block" type="submit" data-scan-btn>Get my free content plan</button>
      </form>

      <div class="m-calc-out" aria-live="polite">
        <div class="m-calc-empty" data-state="empty">
          <span class="m-ic">📊</span>
          <h3>Your content plan will appear here</h3>
          <p>Enter your website to see what customers find today and what you need to post each month.</p>
          <ul class="m-skel"><li></li><li></li><li></li></ul>
        </div>
        <div class="m-calc-loading" data-state="loading" hidden>
          <span class="m-spin" aria-hidden="true"></span>
          <p>Checking <b data-out="checking"></b>…</p>
        </div>
        <div class="m-calc-result" data-state="result" hidden>
          <span class="m-muted m-small">Content plan for</span>
          <h3 class="m-result-site" data-out="site"></h3>
          <ul class="m-findings" data-out="findings"></ul>
          <div class="m-calc-total"><b data-out="total">0</b> pieces of content / month</div>
          <p class="m-calc-sum" data-out="summary"></p>
          <div class="m-calc-stats">
            <div><b data-out="diy">0h</b><span>to write it yourself</span></div>
            <div class="hl"><b data-out="saved">0h</b><span>saved with ContentVendor</span></div>
          </div>
          <p class="m-gap" data-out="gap"></p>
          <a class="m-btn m-btn-primary m-btn-block m-btn-lg" href="<?= e(url('register')) ?>">Join Free Today</a>
          <span class="m-muted m-small m-center">Free forever plan · No credit card</span>
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
