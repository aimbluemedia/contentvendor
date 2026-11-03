<section class="hero">
  <div class="container hero-grid">
    <div>
      <p class="kicker">Your AI marketing assistant</p>
      <h1>Create once.<br><span class="accent">Promote everywhere.</span></h1>
      <p class="lead">Turn one business idea into articles, social posts, promotions and directory updates. Do it yourself for free, automate it with your membership, or let our team handle everything.</p>
      <div class="actions">
        <a class="btn btn-primary btn-lg" href="<?= e(url('register')) ?>">Start free — no card needed</a>
        <a class="btn btn-ghost btn-lg" href="<?= e(url('pricing')) ?>">See plans</a>
      </div>
      <p class="small muted">Built for plumbers, landscapers, roofers, handymen and every local business owner.</p>
    </div>
    <div class="hero-card" aria-label="Campaign builder example">
      <div class="idea-box">
        <span class="small muted">What would you like to promote today?</span>
        <strong>“We're offering $200 off artificial turf installation this month.”</strong>
      </div>
      <div class="arrow-down">↓ ContentVendor AI Campaign Builder</div>
      <div class="channel-grid">
        <?php foreach (CHANNELS as $c): ?>
          <div class="channel-chip"><span><?= $c['icon'] ?></span><?= e($c['label']) ?></div>
        <?php endforeach; ?>
      </div>
      <div class="flow"><span>Approve</span>→<span>Schedule</span>→<span>Publish</span></div>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head center">
      <h2>One idea becomes an entire marketing campaign</h2>
      <p class="muted">Instead of writing eight different pieces of content, you write one sentence. ContentVendor uses your business profile, service area, brand voice and offer to draft every piece together — each customized for its destination.</p>
    </div>
    <div class="steps">
      <div class="step"><b>1</b><h3>Pick a goal</h3><p>Get more calls, promote a special, announce a new service, share a completed job, or keep your business active.</p></div>
      <div class="step"><b>2</b><h3>Describe it in plain words</h3><p>No prompts, SEO or social media strategy needed. Your profile fills in the details.</p></div>
      <div class="step"><b>3</b><h3>Approve, schedule, publish</h3><p>Edit anything you like, approve it, then copy, download or schedule it on your calendar.</p></div>
    </div>
  </div>
</section>

<section class="section alt">
  <div class="container">
    <div class="section-head center"><h2>Three ways to use ContentVendor</h2></div>
    <div class="cards-3">
      <div class="card"><p class="kicker">Free · $0</p><h3>Create it</h3><p>Genuinely useful AI content tools. A handyman who needs a few Facebook posts a month never has to upgrade.</p></div>
      <div class="card featured"><p class="kicker">Pro $19 · Premium $49</p><h3>Automate it</h3><p>Create more, schedule posts and promote consistently. Premium prepares weeks of business-specific content for you to approve.</p></div>
      <div class="card"><p class="kicker">From $299/mo</p><h3>We handle it</h3><p>Our team runs your content on the same platform — you approve, we publish and report.</p><a href="<?= e(url('done-for-you')) ?>">See packages →</a></div>
    </div>
    <p class="center small muted">The $0, $19 and $49 memberships are part of your main Toutify subscription — no extra charge to access ContentVendor.</p>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="section-head center">
      <h2>The Toutify advantage: a connected promotion network</h2>
      <p class="muted">Standalone schedulers stop at social media. ContentVendor gives your whole Toutify presence something useful to publish every week.</p>
    </div>
    <div class="cards-3">
      <div class="card"><h3>SearchMonster</h3><p>Publish relevant articles, service updates, offers and promotions to your storefront.</p></div>
      <div class="card"><h3>MonsterList</h3><p>Keep business information synchronized and publish eligible business updates.</p></div>
      <div class="card"><h3>Official State Directories</h3><p>Distribute location-relevant content to approved state listings.</p></div>
      <div class="card"><h3>PromoMonster</h3><p>Turn authentic customer feedback into approved testimonials and social content.</p></div>
      <div class="card"><h3>LeadCrazy</h3><p>Add calls to action and lead forms to campaigns, then measure inquiries.</p></div>
      <div class="card"><h3>ContentVendor</h3><p>Create, coordinate, schedule and measure all your content from one workspace.</p></div>
    </div>
    <p class="center small muted">Enter your business information once — name, services, location, service areas, specialties and offers — and every tool uses it.</p>
  </div>
</section>

<section class="section cta-band">
  <div class="container center">
    <h2>Stay active. Get discovered. Turn content into customers.</h2>
    <a class="btn btn-light btn-lg" href="<?= e(url('register')) ?>">Create my free account</a>
  </div>
</section>
