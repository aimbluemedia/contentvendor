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
    <div class="tv">
      <div class="tv-stage" aria-label="Illustrative example of marketing results across AI, search and social media">
        <div class="tv-photo">
          <img src="<?= e($heroPhoto) ?>" alt="Smiling small business owner at her laptop in front of a Desert Turf Pros sign" width="1672" height="941" fetchpriority="high">
        </div>

        <article class="tv-card tv-chatgpt">
          <div class="tv-head"><span class="tv-logo" style="background:#10a37f">✳</span> ChatGPT</div>
          <div class="tv-bubble">“Best turf installer near Phoenix?”</div>
          <div class="tv-answer">✦ I recommend <strong>Desert Turf Pros</strong> for turf installation in Phoenix.</div>
        </article>

        <article class="tv-card tv-facebook">
          <div class="tv-head"><span class="tv-logo" style="background:#1877f2">f</span> Social post published</div>
          <div class="tv-row"><img class="tv-thumb" src="<?= e($thumbOwner) ?>" alt="" width="56" height="52"><p>Summer-ready yards: <b>$200 off</b> turf installs this month!</p></div>
          <div class="tv-foot"><span class="tv-dots"><i style="background:#1877f2">f</i><i style="background:#e1306c">◎</i><i style="background:#111">♪</i></span><span>👍 128 · 💬 24</span></div>
        </article>

        <article class="tv-card tv-google">
          <span class="tv-logo tv-logo-g">G</span>
          <div><b>New 5-star Google review</b><small><span class="tv-stars">★★★★★</span> 4.9 · Just now</small></div>
        </article>

        <article class="tv-card tv-lead">
          <span class="tv-logo tv-logo-lead">✓</span>
          <div><b>New lead: quote request</b><small>From your website · 2 min ago</small></div>
        </article>

        <span class="tv-chip tv-tiktok"><i style="background:#111">♪</i> 12.4K TikTok views</span>
        <span class="tv-chip tv-reddit"><i style="background:#ff4500">▲</i> 86 upvotes · r/phoenix</span>
      </div>

      <div class="tv-members">
        <p class="tv-members-label"><span>✓</span> Membership includes access to</p>
        <div class="tv-boxes">
          <div class="tv-box"><span class="tv-box-ic">🔎</span><b>SearchMonster</b><small>AI search &amp; free listing</small></div>
          <div class="tv-box"><span class="tv-box-ic">📋</span><b>MonsterList</b><small>Free listings everywhere</small></div>
          <div class="tv-box"><span class="tv-box-ic">⭐</span><b>PromoMonster</b><small>Reviews &amp; reputation</small></div>
          <div class="tv-box"><span class="tv-box-ic">⚡</span><b>LeadCrazy</b><small>Lead conversion</small></div>
          <div class="tv-box"><span class="tv-box-ic">🏛️</span><b>Official Directories</b><small>Free state directory listings</small></div>
        </div>
      </div>
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

<!-- JOIN FREE -->
<?php
$freeBrands = [
    ['SearchMonster', '🔎', '#16a34a', 'Your business storefront with articles, offers and updates customers can find.'],
    ['MonsterList', '📋', '#2563eb', 'Business listings kept accurate and in sync everywhere.'],
    ['PromoMonster', '⭐', '#f59e0b', 'Turn happy customers into reviews and testimonials.'],
    ['LeadCrazy', '⚡', '#db2777', 'Lead forms and calls to action that capture new inquiries.'],
];
?>
<section class="jf" id="join-free">
  <div class="container">
    <div class="jf-card">
      <div class="jf-glow" aria-hidden="true"></div>
      <div class="jf-grid">
        <div class="jf-copy">
          <span class="jf-pill">✦ Free forever membership</span>
          <h2>Join free. <span>Get it all for&nbsp;$0.</span></h2>
          <p>One free Toutify membership gives you the tools to get found, look trustworthy and turn visitors into leads, plus ContentVendor's AI content tools.</p>
          <a class="jf-btn" href="<?= e(url('register')) ?>">Join Free Today <span aria-hidden="true">→</span></a>
          <ul class="jf-ticks"><li>No credit card</li><li>Free forever</li><li>Set up in 2 minutes</li></ul>
          <div class="jf-value"><b>$0</b><span>Every tool and directory listed here, included free</span></div>
        </div>

        <div class="jf-includes">
          <span class="jf-label">Your free membership includes</span>
          <div class="jf-brands">
            <?php foreach ($freeBrands as [$name, $ic, $color, $text]): ?>
              <div class="jf-brand">
                <span class="jf-ic" style="--c:<?= e($color) ?>"><?= $ic ?></span>
                <div><b><?= e($name) ?></b><small><?= e($text) ?></small></div>
                <em>Free</em>
              </div>
            <?php endforeach; ?>
          </div>
          <span class="jf-label">Plus free access to</span>
          <div class="jf-dirs">
            <div class="jf-dir">
              <span class="jf-ic" style="--c:#0f766e">🏛️</span>
              <div><b>Official State Directories</b><small>Get listed on location-based directories in your state.</small></div>
            </div>
            <div class="jf-dir">
              <span class="jf-ic" style="--c:#7c3aed">🏆</span>
              <div><b>Elite Niche Directories</b><small>Stand out in directories built for your industry.</small></div>
            </div>
          </div>
          <div class="jf-plus">
            <span class="jf-ic" style="--c:#15803d">✨</span>
            <span><b>ContentVendor AI content tools</b>: free articles, posts and Google updates every month</span>
          </div>
        </div>
      </div>
    </div>
    <p class="jf-more"><a href="<?= e(url('pricing')) ?>">See more options →</a></p>
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
