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
<section class="m-hero">
  <div class="container m-hero-grid">
    <div class="m-hero-copy">
      <a class="m-badge" href="<?= e(url('register')) ?>"><span>New</span> Free AI content tools for local businesses →</a>
      <h1>Get found online <span class="m-hl">before your competitors do.</span></h1>
      <p class="m-lead">Customers search Google and AI assistants before they call anyone. ContentVendor's free AI tools write your posts, articles and Google updates in minutes, so your business stays visible and turns searches into leads.</p>
      <div class="m-cta">
        <a class="m-btn m-btn-primary" href="<?= e(url('register')) ?>">Start free, no card needed</a>
        <a class="m-btn m-btn-light" href="#calculator">See what you're missing</a>
      </div>
      <ul class="m-ticks">
        <li>Free forever plan</li>
        <li>Ready in 2 minutes</li>
        <li>No marketing skills needed</li>
      </ul>
    </div>

    <div class="m-hero-visual" aria-hidden="true">
      <div class="m-card m-compare">
        <div class="m-card-head"><b>Posts this month</b><span class="m-muted">Example · Landscaping, Phoenix</span></div>
        <div class="m-bar-row"><span>Top competitor</span><div class="m-bar"><i style="width:90%"></i></div><b>18</b></div>
        <div class="m-bar-row you"><span>Your business</span><div class="m-bar"><i style="width:10%"></i></div><b>2</b></div>
        <p class="m-warn">⚠ Customers searching this week will see your competitor first.</p>
      </div>
      <div class="m-card m-gen">
        <div class="m-card-head"><b>One idea → ready-to-post content</b></div>
        <p class="m-idea">“$200 off artificial turf installation this month”</p>
        <ul class="m-gen-list">
          <li><span>📝</span>Website article<em>Ready</em></li>
          <li><span>👍</span>Facebook post<em>Ready</em></li>
          <li><span>📍</span>Google Business update<em>Ready</em></li>
          <li><span>📸</span>Instagram caption<em>Ready</em></li>
          <li class="more">+ email, Pinterest, directory &amp; video script</li>
        </ul>
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
<section class="m-section">
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

<!-- CALCULATOR -->
<section class="m-section m-alt" id="calculator">
  <div class="container">
    <div class="m-head">
      <span class="m-eyebrow">Free content calculator</span>
      <h2>How much content does your business need?</h2>
      <p>Answer three questions and see your monthly plan, and how much time it saves you.</p>
    </div>
    <div class="m-calc" data-calc>
      <form class="m-calc-form" onsubmit="return false">
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
        <div class="m-q">
          <span class="m-q-label">Who will do the work?</span>
          <div class="m-chips">
            <label class="m-chip"><input type="radio" name="who" value="me" checked><span>Me</span></label>
            <label class="m-chip"><input type="radio" name="who" value="auto"><span>Automate it</span></label>
            <label class="m-chip"><input type="radio" name="who" value="team"><span>Your team</span></label>
          </div>
        </div>
      </form>
      <div class="m-calc-out" aria-live="polite">
        <span class="m-muted">Your monthly content plan</span>
        <div class="m-calc-total"><b data-out="total">0</b> pieces of content</div>
        <p class="m-calc-sum" data-out="summary"></p>
        <div class="m-calc-stats">
          <div><b data-out="diy">0h</b><span>to write it yourself</span></div>
          <div class="hl"><b data-out="saved">0h</b><span>saved with ContentVendor</span></div>
        </div>
        <div class="m-calc-plan">
          <div><span class="m-muted">Recommended plan</span><strong data-out="plan">Pro</strong><small data-out="planwhy"></small></div>
          <b data-out="price">$19</b>
        </div>
        <a class="m-btn m-btn-primary m-btn-block" data-out-href="cta" href="<?= e(url('register')) ?>">Start free →</a>
        <span class="m-hidden" data-out="campaigns"></span><span class="m-hidden" data-out="social"></span>
      </div>
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
