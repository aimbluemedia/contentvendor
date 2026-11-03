<?php
$tools = [
    ['icon' => '✨', 'name' => 'AI Campaign Builder', 'tag' => 'free', 'text' => 'Type one idea. Get an article, social posts, a Google update, an email and a video script, all written for your business.'],
    ['icon' => '📝', 'name' => 'Article & Blog Writer', 'tag' => 'free', 'text' => 'Helpful, local website articles that answer real customer questions. Basic on Free, full-length on Pro.'],
    ['icon' => '💬', 'name' => 'Social Caption Writer', 'tag' => 'free', 'text' => 'Facebook posts, Instagram captions with local hashtags, and Pinterest pins. Each one is written for its network.'],
    ['icon' => '🏷️', 'name' => 'Offer & Promotion Builder', 'tag' => 'free', 'text' => 'Turn a discount or seasonal special into a promotion with a clear call to action.'],
    ['icon' => '📍', 'name' => 'Google Business Updates', 'tag' => 'free', 'text' => 'Short, factual updates that keep your Google Business Profile active and fresh.'],
    ['icon' => '🎬', 'name' => 'Video Script Writer', 'tag' => 'free', 'text' => '30-second Reels, TikTok and Shorts scripts: what to film, what to say and how to close.'],
    ['icon' => '✉️', 'name' => 'Email Promotions', 'tag' => 'free', 'text' => 'A subject line, preview text and a short customer email with one clear call to action.'],
    ['icon' => '♻️', 'name' => 'Repurpose Content', 'tag' => 'pro', 'text' => 'Turn any article into social posts, or any post into an email and a video script, in one click.'],
    ['icon' => '📅', 'name' => 'Content Calendar', 'tag' => 'pro', 'text' => 'See the whole month at a glance and never wonder what to post next.'],
    ['icon' => '⏱️', 'soon' => true, 'name' => 'Scheduling & Auto-publish', 'tag' => 'pro', 'text' => 'Approve once and schedule posts to your connected Facebook, Instagram and Google profiles.'],
    ['icon' => '🖼️', 'soon' => true, 'name' => 'Business-Branded Images', 'tag' => 'pro', 'text' => 'On-brand graphics with your name, colours and offer. 10 a month on Pro, 40 on Premium.'],
    ['icon' => '📇', 'soon' => true, 'name' => 'Directory Distribution', 'tag' => 'pro', 'text' => 'Share offers and updates to SearchMonster, MonsterList and approved state directories.'],
    ['icon' => '🧠', 'soon' => true, 'name' => 'AI Monthly Planner', 'tag' => 'premium', 'text' => 'Get a month of campaign ideas built around your seasons, services and goals, ready to approve.'],
    ['icon' => '🔁', 'soon' => true, 'name' => 'Automatic Recycling', 'tag' => 'premium', 'text' => 'Your best evergreen posts come back on a schedule, refreshed so they never look copied.'],
    ['icon' => '📈', 'name' => 'Performance Dashboard', 'tag' => 'free', 'text' => 'See what's published, scheduled and in draft, plus your monthly usage at a glance.'],
];
$tagLabels = ['free' => 'Free', 'pro' => 'Pro', 'premium' => 'Premium'];
$goalCards = [
    ['calls',   '📞', 'Get more calls',        'Posts with a strong call to action and your phone number on every channel.'],
    ['special', '🏷️', 'Promote a special',     'Turn this month\'s deal into a campaign everywhere at once.'],
    ['service', '🆕', 'Announce a new service', 'Let your area know what you offer now.'],
    ['job',     '📸', 'Share a completed job',  'Turn a finished project into proof for your next customer.'],
    ['active',  '🌱', 'Keep my business active', 'Helpful tips and updates so you never go quiet.'],
    ['repurpose', '♻️', 'Repurpose content',      'Turn one article into a week of social posts.'],
];
$faqs = [
    ['Is ContentVendor really free?', 'Yes. The Starter plan is $0 forever and includes 5 AI content generations a month, the Campaign Builder for up to 3 channels, and copy and download for everything you create. No credit card required.'],
    ['Do I pay separately for ContentVendor?', 'No. The $0, $19 and $49 memberships are part of your main Toutify subscription. You are not charged again just to use ContentVendor.'],
    ['What counts as one AI generation?', 'One requested content item, such as one Facebook post or one article. A campaign for 4 channels uses 4 generations. Fair-use limits apply to length and revisions.'],
    ['I\'m not a marketer. Will I be able to use this?', 'That\'s who it\'s built for. You pick a goal like "Promote a special", type one sentence, and approve the drafts. No prompts, SEO or social media strategy needed.'],
    ['Will it post for me automatically?', 'Pro and Premium let you schedule content to your calendar. Auto-publishing to Facebook Pages, Instagram business accounts and Google Business Profiles is rolling out as each network approves our integration.'],
    ['Can your team just do it for me?', 'Yes. Done-for-you packages start at $299/month. Our team creates, schedules and reports on your content using the same platform, and the $49 Premium membership is included.'],
    ['Can I cancel anytime?', 'Yes. Plans are month to month. If you downgrade, everything you created stays in your content library.'],
];
?>

<!-- ============ HERO ============ -->
<section class="hx-hero">
  <div class="container hx-hero-grid">
    <div class="hx-hero-copy">
      <p class="hx-eyebrow">AI content creation · Social media · From $0</p>
      <h1 class="hx-display">
        <span class="ink">Create</span>
        <span class="ink">once.</span>
        <span class="light">Post everywhere.</span>
      </h1>
      <p class="hx-lead"><strong>ContentVendor</strong> turns one business idea into a website article, social posts, a Google update, an email and a video script in about a minute. Write it yourself for free, automate it with your membership, or let our team handle everything.</p>
      <div class="hx-actions">
        <a class="pill pill-dark" href="<?= e(url('register')) ?>">Start free <span aria-hidden="true">→</span></a>
        <a class="pill pill-outline" href="#calculator">Calculate my content plan</a>
      </div>
      <ul class="hx-checks">
        <li>Free forever plan</li>
        <li>No credit card</li>
        <li>Built for local businesses</li>
      </ul>
    </div>

    <div class="hx-stage" aria-hidden="true">
      <div class="hx-arch">
        <div class="hx-idea">
          <span class="hx-label">What would you like to promote?</span>
          <strong>“$200 off artificial turf installation this month.”</strong>
          <span class="hx-go">Create my campaign →</span>
        </div>

        <div class="hx-post">
          <div class="hx-post-head"><span class="hx-avatar">DT</span><div><b>Desert Turf Pros</b><small>Phoenix, AZ · Just now</small></div></div>
          <p>Summer-ready yards, zero mowing. 🌿 Save <b>$200</b> on artificial turf installation this month only. Call (602) 555-0142!</p>
          <div class="hx-post-img"><span>🌿</span><em>$200 OFF</em></div>
          <div class="hx-post-foot"><span>👍 Like</span><span>💬 Comment</span><span>↗ Share</span></div>
        </div>

        <div class="hx-channels">
          <?php foreach (CHANNELS as $c): ?><span title="<?= e($c['label']) ?>"><?= $c['icon'] ?></span><?php endforeach; ?>
        </div>
      </div>

      <div class="hx-float hx-float-plan">
        <span class="hx-label">This month</span>
        <div class="hx-big">24<small> posts</small></div>
        <div class="hx-bar"><span style="width:78%"></span></div>
        <small>Next post: <b>Tue 9:00am</b> · Facebook</small>
      </div>

      <div class="hx-float hx-float-saved">
        <span class="hx-label">Time saved</span>
        <div class="hx-big">11<small> hrs</small></div>
      </div>

      <svg class="hx-badge" viewBox="0 0 120 120">
        <defs><path id="hxCircle" d="M60,60 m-46,0 a46,46 0 1,1 92,0 a46,46 0 1,1 -92,0"/></defs>
        <circle cx="60" cy="60" r="58" />
        <text><textPath href="#hxCircle" textLength="286" lengthAdjust="spacing">ONE IDEA · EIGHT CHANNELS · ONE IDEA · EIGHT CHANNELS ·</textPath></text>
        <text x="60" y="58" text-anchor="middle" class="hx-badge-big">8×</text>
        <text x="60" y="76" text-anchor="middle" class="hx-badge-sm">CONTENT</text>
      </svg>
    </div>
  </div>
</section>

<!-- ============ TICKER ============ -->
<div class="hx-ticker" aria-hidden="true">
  <div class="hx-ticker-track">
    <?php for ($i = 0; $i < 2; $i++): ?>
      <span>One idea → 8 posts</span><i>✦</i>
      <span>AI article writer</span><i>✦</i>
      <span class="hl">Free forever plan</span><i>✦</i>
      <span>Schedule a month in minutes</span><i>✦</i>
      <span>Toutify directory network</span><i>✦</i>
      <span class="hl">Done-for-you from $299</span><i>✦</i>
    <?php endfor; ?>
  </div>
</div>

<!-- ============ CALCULATOR ============ -->
<section class="hx-dark" id="calculator">
  <div class="container">
    <div class="hx-split-head">
      <div>
        <p class="hx-eyebrow light"><span class="hx-tag">Free tool</span> Content calculator</p>
        <h2 class="hx-display md">
          <span class="white">How much content</span>
          <span class="white">do you need?</span>
          <span class="lime">Find out in 30 seconds.</span>
        </h2>
      </div>
      <p class="hx-side">Tell us where you want to show up and how often. We'll show your monthly content plan, how many hours it takes to do yourself, and the plan that fits.</p>
    </div>

    <div class="calc" data-calc>
      <form class="calc-inputs" onsubmit="return false">
        <div class="calc-q">
          <h3><span>01</span> Your industry</h3>
          <div class="opt-grid four">
            <?php foreach (['Landscaping', 'Plumbing', 'Roofing', 'Handyman', 'HVAC', 'Cleaning', 'Restaurant', 'Other'] as $i => $ind): ?>
              <label class="opt"><input type="radio" name="industry" value="<?= e($ind) ?>" <?= $i === 0 ? 'checked' : '' ?>><span><b><?= e($ind) ?></b></span></label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="calc-q">
          <h3><span>02</span> Where do you want to show up?</h3>
          <div class="opt-grid four">
            <?php foreach (['facebook' => 'Facebook', 'instagram' => 'Instagram', 'google' => 'Google', 'pinterest' => 'Pinterest', 'directory' => 'Directories', 'email' => 'Email', 'video' => 'Video'] as $k => $n): ?>
              <label class="opt"><input type="checkbox" name="networks" value="<?= e($k) ?>" <?= in_array($k, ['facebook', 'instagram', 'google'], true) ? 'checked' : '' ?>><span><b><?= e($n) ?></b></span></label>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="calc-q">
          <h3><span>03</span> How often should you post?</h3>
          <div class="range-row">
            <input type="range" name="perweek" min="1" max="7" value="3" aria-label="Posts per week">
            <output data-out="perweek">3 / week</output>
          </div>
          <div class="range-scale"><span>Once a week</span><span>Every day</span></div>
        </div>

        <div class="calc-q">
          <h3><span>04</span> Website articles per month</h3>
          <div class="range-row">
            <input type="range" name="articles" min="0" max="8" value="2" aria-label="Articles per month">
            <output data-out="articles">2</output>
          </div>
        </div>

        <div class="calc-q">
          <h3><span>05</span> Who will do the work?</h3>
          <div class="opt-grid three">
            <label class="opt"><input type="radio" name="who" value="me" checked><span><b>Me</b><small>I'll approve and post</small></span></label>
            <label class="opt"><input type="radio" name="who" value="auto"><span><b>Automate it</b><small>Schedule it for me</small></span></label>
            <label class="opt"><input type="radio" name="who" value="team"><span><b>Your team</b><small>Done for me</small></span></label>
          </div>
        </div>
      </form>

      <div class="calc-result" aria-live="polite">
        <div class="calc-result-head">
          <h3>Your monthly content plan</h3>
          <span class="live-dot">Updates as you answer</span>
        </div>
        <div class="calc-score">
          <div class="ring" data-ring style="--p:60"><b data-out="total">0</b><small>pieces / mo</small></div>
          <p data-out="summary">To stay active you need about this much content every month.</p>
        </div>
        <div class="calc-tiles">
          <div class="tile"><b data-out="campaigns">0</b><span>Campaign ideas</span><small>One idea, adapted to every network</small></div>
          <div class="tile"><b data-out="social">0</b><span>Social posts</span><small>Facebook, Instagram, Google and more</small></div>
          <div class="tile"><b data-out="diy">0h</b><span>Writing it yourself</span><small>About 20 min per post, 2 hrs per article</small></div>
          <div class="tile hl"><b data-out="saved">0h</b><span>Saved with ContentVendor</span><small>You just review and approve</small></div>
        </div>
        <div class="calc-plan">
          <div>
            <span class="hx-label">Recommended</span>
            <strong data-out="plan">Pro</strong>
            <small data-out="planwhy">Covers your monthly volume with scheduling included.</small>
          </div>
          <div class="calc-price" data-out="price">$19<small>/mo</small></div>
        </div>
        <a class="pill pill-lime pill-block" data-out-href="cta" href="<?= e(url('register')) ?>">Start with this plan →</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ GOALS ============ -->
<section class="hx-mint">
  <div class="container">
    <div class="hx-split-head">
      <div>
        <p class="hx-eyebrow">Pick a goal</p>
        <h2 class="hx-display md"><span class="ink">What do you want</span><span class="green">to do today?</span></h2>
      </div>
      <p class="hx-side dark">No prompts or marketing jargon. Choose what you want to happen and ContentVendor writes the rest from your business profile.</p>
    </div>
    <div class="goals-wrap">
      <div class="goal-grid">
        <?php foreach ($goalCards as [$key, $icon, $name, $text]): ?>
          <a class="goal-card" href="<?= e(url($key === 'repurpose' ? 'register' : 'register?goal=' . $key)) ?>">
            <span class="goal-icon"><?= $icon ?></span>
            <b><?= e($name) ?></b>
            <small><?= e($text) ?></small>
          </a>
        <?php endforeach; ?>
      </div>
      <div class="mock-dash" aria-hidden="true">
        <div class="mock-side">
          <b>ContentVendor</b>
          <span class="on">Dashboard</span><span>Create</span><span>Library</span><span>Calendar</span><span>Performance</span>
        </div>
        <div class="mock-main">
          <div class="mock-top"><b>Welcome back, Maria</b><span class="chip-premium">Premium</span></div>
          <div class="mock-stats">
            <div><b>12</b><small>Published</small></div>
            <div><b>8</b><small>Scheduled</small></div>
            <div><b>4</b><small>Drafts</small></div>
          </div>
          <div class="mock-row"><span>📝 Spring lawn care checklist</span><em class="s-pub">Published</em></div>
          <div class="mock-row"><span>👍 20% off backyard landscaping</span><em class="s-sch">Tue 9:00</em></div>
          <div class="mock-row"><span>📍 New: drip irrigation installs</span><em class="s-sch">Thu 12:00</em></div>
          <div class="mock-row"><span>🎬 Before &amp; after: Mesa turf job</span><em class="s-dra">Draft</em></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ TOOLS ============ -->
<section class="hx-forest" id="tools">
  <div class="container">
    <div class="hx-split-head">
      <div>
        <p class="hx-eyebrow light">Every ContentVendor tool</p>
        <h2 class="hx-display md"><span class="white">One workspace.</span><span class="lime">Every post you need.</span></h2>
      </div>
      <p class="hx-side">Content creation and social media tools built for business owners, not marketers. Every tool uses your business profile, so you never type the same details twice.</p>
    </div>
    <div class="tool-grid">
      <?php foreach ($tools as $t): ?>
        <div class="tool-card">
          <div class="tool-top"><span class="tool-icon"><?= $t['icon'] ?></span><span class="tier tier-<?= e($t['tag']) ?>"><?= e($tagLabels[$t['tag']]) ?></span></div>
          <?php if (!empty($t['soon'])): ?><span class="soon">Rolling out</span><?php endif; ?>
          <h3><?= e($t['name']) ?></h3>
          <p><?= e($t['text']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="hx-strip">
      <div><b>Your competitors are posting this week.</b><span>Start free today. Your first campaign takes about a minute.</span></div>
      <a class="pill pill-lime" href="<?= e(url('register')) ?>">Create my first campaign →</a>
    </div>
  </div>
</section>

<!-- ============ CHANNELS (bestseller style) ============ -->
<section class="hx-mint">
  <div class="container">
    <div class="hx-split-head">
      <div>
        <p class="hx-eyebrow">The Campaign Builder</p>
        <h2 class="hx-display md"><span class="ink">One idea.</span><span class="green">Eight destinations.</span></h2>
      </div>
      <p class="hx-side dark">Every draft is written for where it's going, not copied and pasted. Approve, schedule and publish from one place.</p>
    </div>
    <div class="ch-grid">
      <?php
      $samples = [
          'article' => ['Is artificial turf worth it in Phoenix?', '600 words · SEO title'],
          'facebook' => ['Summer-ready yards, zero mowing 🌿', '90 words · CTA + phone'],
          'instagram' => ['Your weekends called. They want you back.', 'Caption + 8 hashtags'],
          'pinterest' => ['Pet-friendly turf ideas for small yards', 'Pin title + description'],
          'google_business' => ['$200 off turf installs this month', 'Under 1,500 characters'],
          'directory' => ['Desert Turf Pros, turf installation in Phoenix', 'SearchMonster · MonsterList'],
          'email' => ['Subject: Your $200 turf credit is waiting', 'Subject + preview + body'],
          'video_script' => ['HOOK: “Still mowing in July?”', '30-second Reel script'],
      ];
      foreach (CHANNELS as $k => $c): ?>
        <div class="ch-card">
          <span class="ch-icon"><?= $c['icon'] ?></span>
          <h3><?= e($c['label']) ?></h3>
          <p class="ch-sample">“<?= e($samples[$k][0]) ?>”</p>
          <div class="ch-foot"><small><?= e($samples[$k][1]) ?></small><span class="ch-plus">+</span></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ NETWORK ============ -->
<section class="hx-network">
  <div class="container">
    <p class="hx-eyebrow center">The Toutify advantage</p>
    <h2 class="hx-display sm center"><span class="ink">Publish beyond social media.</span></h2>
    <div class="net-grid">
      <div class="net-card"><b>SearchMonster</b><p>Articles, offers and updates on your storefront.</p></div>
      <div class="net-card"><b>MonsterList</b><p>Business info kept in sync, plus eligible updates.</p></div>
      <div class="net-card"><b>State Directories</b><p>Local content on approved state listings.</p></div>
      <div class="net-card"><b>PromoMonster</b><p>Real customer feedback turned into testimonials.</p></div>
      <div class="net-card"><b>LeadCrazy</b><p>Calls to action and lead forms on every campaign.</p></div>
      <div class="net-card on"><b>ContentVendor</b><p>Create, schedule and measure it all in one place.</p></div>
    </div>
  </div>
</section>

<!-- ============ FREE PLAN ============ -->
<section class="hx-free-wrap">
  <div class="container">
    <div class="hx-free">
      <p class="hx-eyebrow light"><span class="hx-tag">Free forever plan</span></p>
      <h2 class="hx-display md"><span class="white">Join free.</span><span class="lime">Start posting for $0.</span></h2>
      <p class="hx-side">No credit card and no trial clock. Free means useful: a handyman who only needs a few posts a month never has to upgrade.</p>
      <div class="free-grid">
        <div><span>✨</span><b>5 AI generations / month</b><small>Articles, posts, offers and scripts</small></div>
        <div><span>🧩</span><b>Campaign Builder</b><small>One idea for up to 3 channels</small></div>
        <div><span>🏢</span><b>Business profile</b><small>Enter your details once</small></div>
        <div><span>📚</span><b>Content library</b><small>Edit, copy and download everything</small></div>
        <div><span>📅</span><b>Basic calendar</b><small>Plan what goes out when</small></div>
        <div><span>📇</span><b>Directory sharing</b><small>Manual posting to the Toutify network</small></div>
      </div>
      <div class="hx-actions">
        <a class="pill pill-lime" href="<?= e(url('register')) ?>">Join free now →</a>
        <a class="pill pill-ghost-light" href="<?= e(url('pricing')) ?>">Compare all plans</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ PRICING TEASER ============ -->
<section class="hx-mint">
  <div class="container">
    <div class="hx-split-head">
      <div>
        <p class="hx-eyebrow">Included with your Toutify membership</p>
        <h2 class="hx-display md"><span class="ink">Create it.</span><span class="ink">Automate it.</span><span class="green">Or we handle it.</span></h2>
      </div>
      <p class="hx-side dark">The $0, $19 and $49 plans are part of your main Toutify subscription. Done-for-you packages include Premium.</p>
    </div>
    <div class="price-grid">
      <?php foreach (PLANS as $key => $p): ?>
        <div class="price-card<?= $key === 'premium' ? ' hero' : '' ?>">
          <?php if ($key === 'premium'): ?><span class="ribbon">Most time saved</span><?php endif; ?>
          <span class="hx-label"><?= e($p['name']) ?> · <?= e($p['verb']) ?></span>
          <div class="pc-price">$<?= (int) $p['price'] ?><small>/mo</small></div>
          <p><?= e($p['tagline']) ?></p>
          <ul>
            <li><?= (int) $p['generations'] ?> AI generations / month</li>
            <li><?= $p['campaign_channels'] >= 8 ? 'All 8 campaign channels' : 'Up to ' . (int) $p['campaign_channels'] . ' channels per campaign' ?></li>
            <li><?= $p['scheduling'] ? (int) $p['scheduled_posts'] . ' scheduled posts / month' : 'Copy & download everything' ?></li>
          </ul>
          <a class="pill <?= $key === 'premium' ? 'pill-lime' : 'pill-dark' ?> pill-block" href="<?= e(url('register')) ?>"><?= $p['price'] ? 'Choose ' . e($p['name']) : 'Start free' ?></a>
        </div>
      <?php endforeach; ?>
      <div class="price-card dfy">
        <span class="hx-label">Done-for-you</span>
        <div class="pc-price">$299<small>+/mo</small></div>
        <p>Our team creates, schedules and reports on your content. Premium included.</p>
        <ul><li>4–20 campaigns / month</li><li>Up to 6 networks</li><li>Articles + monthly report</li></ul>
        <a class="pill pill-outline pill-block" href="<?= e(url('done-for-you')) ?>">See packages</a>
      </div>
    </div>
  </div>
</section>

<!-- ============ FAQ ============ -->
<section class="hx-faq">
  <div class="container hx-faq-grid">
    <div>
      <p class="hx-eyebrow">Questions</p>
      <h2 class="hx-display sm"><span class="ink">Good to</span><span class="green">know.</span></h2>
    </div>
    <div class="faq-list">
      <?php foreach ($faqs as $i => [$q, $a]): ?>
        <details<?= $i === 0 ? ' open' : '' ?>><summary><?= e($q) ?></summary><p><?= e($a) ?></p></details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============ FINAL CTA ============ -->
<section class="hx-final">
  <div class="container">
    <div class="hx-final-card">
      <div>
        <h2 class="hx-display sm"><span class="ink">Stay active. Get discovered.</span><span class="white">Turn content into customers.</span></h2>
        <p>Create a free account and finish your first campaign today.</p>
      </div>
      <a class="pill pill-dark" href="<?= e(url('register')) ?>">Start free →</a>
    </div>
  </div>
</section>
