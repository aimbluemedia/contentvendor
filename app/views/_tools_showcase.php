<?php
/**
 * Homepage tools showcase: every Free / Pro / Premium tool with a live
 * sample preview and a CTA that lands on the Join Free section (#join-free).
 * Sample output is illustrative and written for the Desert Turf Pros demo.
 */
$ico = [
    'campaign' => '<path d="M12 3v3M12 18v3M3 12h3M18 12h3M5.6 5.6l2.1 2.1M16.3 16.3l2.1 2.1M5.6 18.4l2.1-2.1M16.3 7.7l2.1-2.1"/><circle cx="12" cy="12" r="3"/>',
    'article'  => '<path d="M6 3h9l4 4v14H6z"/><path d="M15 3v4h4M9 12h7M9 16h7M9 8h3"/>',
    'social'   => '<path d="M4 5h16v11H9l-5 4z"/><path d="M8 9h8M8 12h5"/>',
    'google'   => '<path d="M12 21s-7-6.2-7-11.5A7 7 0 0 1 19 9.5C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
    'offer'    => '<path d="M3 12V4h8l10 10-8 8z"/><circle cx="7.5" cy="8.5" r="1.5"/>',
    'video'    => '<rect x="3" y="6" width="13" height="12" rx="2"/><path d="M16 10l5-3v10l-5-3z"/>',
    'email'    => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
    'repurpose'=> '<path d="M4 9a8 8 0 0 1 14-3l2 2M20 15a8 8 0 0 1-14 3l-2-2"/><path d="M20 4v4h-4M4 20v-4h4"/>',
    'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4M8 14h2M14 14h2M8 18h2"/>',
    'schedule' => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/>',
    'images'   => '<rect x="3" y="4" width="18" height="16" rx="2"/><circle cx="9" cy="10" r="2"/><path d="M21 16l-5-5-9 9"/>',
    'directory'=> '<path d="M3 9.5 12 4l9 5.5M5 10v8M9.7 10v8M14.3 10v8M19 10v8M3 20.5h18"/>',
    'planner'  => '<path d="M9 18h6M10 21h4M12 3a6 6 0 0 0-4 10.5c.8.8 1 1.5 1 2.5h6c0-1 .2-1.7 1-2.5A6 6 0 0 0 12 3z"/>',
    'recycle'  => '<path d="M7 19H4l3-5M17 19h3l-3-5M9 5l3-2 3 2M7.5 14 5 9.5M16.5 14 19 9.5M9 19h6"/>',
    'stats'    => '<path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/>',
];
$tools = [
    ['campaign', 'free', 'AI Campaign Builder', 'One idea becomes posts for every channel.', false,
        ['Type one sentence about your offer', 'Get 8 channel-ready drafts in about a minute', 'Edit, approve and post'],
        '<div class="tp-input">“$200 off artificial turf installation this month”</div>
         <ul class="tp-outs"><li><i>📝</i>Website article<em>Ready</em></li><li><i>👍</i>Facebook post<em>Ready</em></li><li><i>📸</i>Instagram caption<em>Ready</em></li><li><i>📍</i>Google Business update<em>Ready</em></li><li><i>✉️</i>Email promotion<em>Ready</em></li><li><i>🎬</i>Video script<em>Ready</em></li></ul>'],
    ['article', 'free', 'Article & Blog Writer', 'Helpful local articles customers and AI search find.', false,
        ['Answers the questions customers really ask', 'Written for your city and service area', 'Helps Google and AI assistants understand you'],
        '<h4 class="tp-title">Is Artificial Turf Worth It in Phoenix? 5 Things to Know</h4>
         <p class="tp-line">Phoenix summers are tough on grass. Here is what homeowners should know before switching to turf…</p>
         <p class="tp-h">1. How much water will you save?</p><p class="tp-line short">A typical yard can cut outdoor watering dramatically…</p>
         <p class="tp-h">2. Is it safe for pets and kids?</p><span class="tp-meta">620 words · Local SEO title · Call to action</span>'],
    ['social', 'free', 'Social Post Writer', 'Facebook, Instagram and Pinterest posts in your voice.', false,
        ['Written differently for each network', 'Local hashtags and a clear call to action', 'Copy, download or schedule'],
        '<div class="tp-post"><div class="tp-post-head"><span>DT</span><div><b>Desert Turf Pros</b><small>Sponsored · Phoenix, AZ</small></div></div>
         <p>Summer-ready yards, zero mowing. 🌿 Save <b>$200</b> on artificial turf installation this month only. Call (602) 555-0142!</p>
         <p class="tp-tags">#PhoenixLandscaping #ArtificialTurf #ScottsdaleHomes</p>
         <div class="tp-post-foot"><span>👍 128</span><span>💬 24</span><span>↗ 9</span></div></div>'],
    ['google', 'free', 'Google Business Updates', 'Keep your Google profile fresh and active.', false,
        ['Short, factual updates customers trust', 'Shows you are open and active', 'Built-in “Call now” call to action'],
        '<div class="tp-gbp"><div class="tp-gbp-head"><b>Desert Turf Pros</b><span>★★★★★ 4.9 · Open now</span></div>
         <p class="tp-badge-sm">Offer · Valid this month</p><p><b>$200 off turf installation.</b> Free on-site estimate across Phoenix, Scottsdale and Tempe.</p>
         <span class="tp-btn">📞 Call now</span></div>'],
    ['offer', 'free', 'Offer & Promotion Builder', 'Turn any special into a promotion that sells.', false,
        ['Headline, details and fine print in one click', 'Ready for every channel', 'Clear call to action'],
        '<div class="tp-offer"><span>THIS MONTH ONLY</span><b>$200 OFF</b><p>Artificial turf installation</p><small>Free estimate · Call (602) 555-0142</small></div>'],
    ['video', 'free', 'Video Script Writer', 'Reels, TikTok and Shorts scripts: what to film and say.', false,
        ['30-second scripts with a strong hook', 'Scene-by-scene filming guide', 'Works with the phone in your pocket'],
        '<div class="tp-script"><p><b>HOOK</b> “Still mowing in July?”</p><p><b>SCENE 1</b> Film the dry, patchy lawn. “This was Mesa last week.”</p><p><b>SCENE 2</b> Time-lapse of the install. “One day later…”</p><p><b>CTA</b> “$200 off this month. Link in bio.”</p></div>'],
    ['email', 'free', 'Email Promotions', 'Subject line, preview and a short email that converts.', false,
        ['Subject lines people open', 'Short, friendly and on-brand', 'One clear call to action'],
        '<div class="tp-email"><p><b>Subject:</b> Your $200 turf credit is waiting 🌿</p><p class="tp-muted">Preview: Beat the heat with a yard that never needs mowing…</p><p>Hi there, summer is the perfect time to switch to turf. This month only, save $200 on installation…</p><span class="tp-btn">Get my free estimate</span></div>'],
    ['repurpose', 'pro', 'Repurpose Content', 'Turn one article into a week of social posts.', false,
        ['One article becomes 6+ posts', 'Each rewritten for its network', 'Saves hours every week'],
        '<div class="tp-flow"><div class="tp-src">📝 “5 Things to Know About Turf”</div><div class="tp-arrow">↓ repurposed into</div><div class="tp-chips"><span>👍 Facebook</span><span>📸 Instagram</span><span>📌 Pinterest</span><span>📍 Google</span><span>✉️ Email</span><span>🎬 Reel</span></div></div>'],
    ['calendar', 'pro', 'Content Calendar', 'See your whole month and never miss a post.', false,
        ['Plan the month at a glance', 'See what is drafted, scheduled and live', 'Never go quiet again'],
        '<div class="tp-cal"><span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><i></i><i class="f">👍</i><i></i><i class="g">📍</i><i class="i">📸</i><i class="a">📝</i><i></i><i class="f">👍</i><i></i><i class="v">🎬</i><i></i><i class="g">📍</i><i class="i">📸</i><i></i><i class="f">👍</i></div>'],
    ['schedule', 'pro', 'Scheduling & Auto-publish', 'Approve once and your posts go out on time.', true,
        ['Schedule weeks of posts in minutes', 'Facebook, Instagram and Google Business', 'Post-status tracking'],
        '<ul class="tp-sched"><li><b>Tue 9:00</b><span>👍 Summer turf special</span><em>Scheduled</em></li><li><b>Wed 12:00</b><span>📍 Free estimates this week</span><em>Scheduled</em></li><li><b>Thu 6:00</b><span>📸 Before &amp; after: Mesa</span><em>Scheduled</em></li><li><b>Fri 9:00</b><span>🎬 “Still mowing in July?”</span><em class="d">Draft</em></li></ul>'],
    ['images', 'pro', 'Business-Branded Images', 'On-brand graphics with your name and offer.', true,
        ['Your colors, name and phone', 'Sized for every network', '10/month on Pro, 40 on Premium'],
        '<div class="tp-img"><div class="tp-img-card"><small>DESERT TURF PROS</small><b>$200 OFF</b><span>Turf installation · This month</span><em>(602) 555-0142</em></div><div class="tp-img-sizes"><span>1:1 Instagram</span><span>1.91:1 Facebook</span><span>2:3 Pinterest</span></div></div>'],
    ['directory', 'pro', 'Directory Distribution', 'Share updates across the Toutify network.', true,
        ['SearchMonster storefront updates', 'MonsterList and state directories', 'Business facts kept consistent'],
        '<ul class="tp-dirs"><li><i>🔎</i>SearchMonster storefront<em>Published</em></li><li><i>📋</i>MonsterList listing<em>Updated</em></li><li><i>🏛️</i>Arizona state directory<em>Published</em></li><li><i>⭐</i>PromoMonster reviews<em>Linked</em></li></ul>'],
    ['planner', 'premium', 'AI Monthly Content Planner', 'A month of campaigns planned for you to approve.', true,
        ['Built around your seasons and services', 'Weeks of content ready to approve', 'The biggest time-saver'],
        '<ul class="tp-weeks"><li><b>Week 1</b>Summer turf special · $200 off</li><li><b>Week 2</b>Pet-friendly turf tips</li><li><b>Week 3</b>Customer spotlight: Mesa backyard</li><li><b>Week 4</b>Drip irrigation for desert yards</li></ul><p class="tp-meta">32 drafts ready · Approve all in one click</p>'],
    ['recycle', 'premium', 'Automatic Content Recycling', 'Your best evergreen posts return, refreshed.', true,
        ['Top posts come back on a schedule', 'Rewritten so they never look copied', 'Stay active with zero effort'],
        '<div class="tp-recycle"><div><small>Posted in March</small><p>“5 signs your sprinklers need repair”</p><em>👍 212 · top performer</em></div><div class="tp-arrow">↻ refreshed and back on</div><div><small>June 3</small><p>“Is your sprinkler system ready for summer?”</p><em class="s">Scheduled</em></div></div>'],
    ['stats', 'premium', 'Performance Dashboard', 'See what is working and what brings in leads.', false,
        ['Published, scheduled and drafts at a glance', 'Track usage and activity', 'Advanced reporting on Premium'],
        '<div class="tp-stats"><div><b>32</b><small>Published</small></div><div><b>14</b><small>Scheduled</small></div><div><b>6</b><small>Drafts</small></div></div><div class="tp-bars"><i style="height:30%"></i><i style="height:45%"></i><i style="height:40%"></i><i style="height:62%"></i><i style="height:58%"></i><i style="height:80%"></i><i style="height:92%"></i></div>'],
];
$tierLabel = ['free' => 'Free', 'pro' => 'Pro', 'premium' => 'Premium'];
$counts = array_count_values(array_column($tools, 1));
$svg = fn($k) => '<svg viewBox="0 0 24 24" aria-hidden="true">' . $ico[$k] . '</svg>';
?>
<section class="tl" id="tools">
  <div class="container">
    <div class="tl-head">
      <span class="tl-eyebrow"><i>✦</i> $0 forever · No credit card · No trial clock</span>
      <h2><span class="tl-accent">Free Forever</span> Tools <em>from ContentVendor</em></h2>
      <p>Posts, articles, Google updates and video scripts, written for your business in seconds. Get <b><?= (int) $counts['free'] ?> AI tools free for life</b>, then unlock Pro and Premium when you're ready to put it on autopilot.</p>
      <div class="tl-stats">
        <span><b><?= (int) $counts['free'] ?></b> free tools</span>
        <span><b><?= count($tools) ?></b> tools in total</span>
        <span><b>$0</b> to start</span>
      </div>
    </div>

    <div class="tl-filter" role="tablist" aria-label="Filter tools by plan">
      <button type="button" class="on" data-filter="all">All tools <span><?= count($tools) ?></span></button>
      <button type="button" data-filter="free">Free <span><?= (int) $counts['free'] ?></span></button>
      <button type="button" data-filter="pro">Pro <span><?= (int) $counts['pro'] ?></span></button>
      <button type="button" data-filter="premium">Premium <span><?= (int) $counts['premium'] ?></span></button>
    </div>

    <div class="tl-grid" data-tools>
      <div class="tl-list" role="list">
        <?php foreach ($tools as $i => [$k, $tier, $name, $short]): ?>
          <button type="button" role="listitem" class="tl-item<?= $i === 0 ? ' on' : '' ?>" data-tool="<?= e($k) ?>" data-tier="<?= e($tier) ?>">
            <span class="tl-ic tier-<?= e($tier) ?>"><?= $svg($k) ?></span>
            <span class="tl-txt"><b><?= e($name) ?></b><small><?= e($short) ?></small></span>
            <span class="tl-tier tier-<?= e($tier) ?>"><?= e($tierLabel[$tier]) ?></span>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="tl-preview">
        <?php foreach ($tools as $i => [$k, $tier, $name, $short, $soon, $points, $sample]): ?>
          <div class="tl-pane<?= $i === 0 ? ' on play' : '' ?>" data-pane="<?= e($k) ?>"<?= $i === 0 ? '' : ' hidden' ?>>
            <div class="tl-pane-head">
              <span class="tl-ic big tier-<?= e($tier) ?>"><?= $svg($k) ?></span>
              <div>
                <span class="tl-tier tier-<?= e($tier) ?>"><?= e($tierLabel[$tier]) ?><?= $tier === 'free' ? ' forever' : ' plan' ?></span><?php if ($soon): ?><span class="tl-soon">Rolling out</span><?php endif; ?>
                <h3><?= e($name) ?></h3>
                <p><?= e($short) ?></p>
              </div>
            </div>
            <div class="tl-window">
              <div class="tl-bar"><i></i><i></i><i></i><span>ContentVendor · <?= e($name) ?></span></div>
              <div class="tl-sample"><?= $sample ?></div>
            </div>
            <ul class="tl-points"><?php foreach ($points as $pt): ?><li><?= e($pt) ?></li><?php endforeach; ?></ul>
            <a class="tl-cta" href="#join-free"><?= $tier === 'free' ? 'Try ' . e($name) . ' free' : 'Start free, upgrade anytime' ?> <span aria-hidden="true">→</span></a>
            <small class="tl-note"><?= $tier === 'free' ? 'Included in your free membership · No credit card' : 'Included with ' . e($tierLabel[$tier]) . ($tier === 'pro' ? ' and Premium' : '') . ' · Start free today' ?></small>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="tl-strip">
      <div><b>All <?= (int) $counts['free'] ?> free tools are yours the moment you join.</b><span>No credit card. No trial clock. Upgrade only if you want more.</span></div>
      <a class="tl-cta" href="#join-free">Get my free tools <span aria-hidden="true">→</span></a>
    </div>
    <p class="tl-disclaimer">Sample content shown for an example business. Features marked “Rolling out” are being released in phases.</p>
  </div>
</section>
