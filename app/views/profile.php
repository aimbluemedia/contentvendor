<section class="section-sm">
  <div class="container narrow">
    <h1>Business profile</h1>
    <p class="muted">Enter your information once. Every ContentVendor tool uses it to write content that sounds like your business — no repeated typing.</p>
    <?php require ROOT . '/app/views/_errors.php'; ?>
    <div class="card tx-account">
      <div class="tx-head">
        <div><h2>Your Toutify account</h2><p class="muted small">These details come from Toutify and are shared across SearchMonster, MonsterList, PromoMonster and LeadCrazy.</p></div>
        <a class="btn btn-ghost" href="<?= e('https://toutify.com/members/profile.php?client_id=' . rawurlencode(toutify_client_id()) . '&return_to=' . rawurlencode(site_url(''))) ?>">Edit on Toutify ↗</a>
      </div>
      <dl class="tx-grid">
        <div><dt>Name</dt><dd><?= e($user['name'] ?: '—') ?></dd></div>
        <div><dt>Email</dt><dd><?= e($user['email'] ?: '—') ?></dd></div>
        <div><dt>Business</dt><dd><?= e($user['business_name'] ?? '' ?: '—') ?></dd></div>
        <div><dt>Phone</dt><dd><?= e($user['phone'] ?? '' ?: '—') ?></dd></div>
        <div class="tx-wide"><dt>Website</dt><dd><?php $site = (string) ($user['website'] ?? ''); if ($site !== ''): $href = preg_match('~^https?://~i', $site) ? $site : 'https://' . $site; ?><a href="<?= e($href) ?>" target="_blank" rel="noopener"><?= e(preg_replace('~^https?://(www\.)?~i', '', rtrim($site, '/'))) ?> ↗</a><?php else: ?>—<?php endif; ?></dd></div>
      </dl>
      <?php $sites = toutify_member_websites((string) $user['toutify_sub']); ?>
      <div class="tx-sites">
        <div class="tx-sites-head"><h3>My websites on ContentVendor</h3><a href="https://toutify.com/members/websites.php" target="_blank" rel="noopener">Manage my websites on Toutify ↗</a></div>
        <?php if (!$sites): ?>
          <p class="muted small">No websites yet. Add one on Toutify and it will appear here after your next sign-in.</p>
        <?php else: ?>
          <ul class="tx-site-list">
            <?php foreach ($sites as $w): $href = preg_match('~^https?://~i', $w['url']) ? $w['url'] : 'https://' . $w['url']; $tierPlan = toutify_tier_to_plan($w['tier']); ?>
              <li>
                <div><b><?= e($w['business_name'] !== '' ? $w['business_name'] : '—') ?></b>
                  <?php if ($w['url'] !== ''): ?><a href="<?= e($href) ?>" target="_blank" rel="noopener"><?= e(preg_replace('~^https?://(www\.)?~i', '', rtrim($w['url'], '/'))) ?> ↗</a><?php endif; ?></div>
                <span class="tx-tier tier-<?= e($tierPlan ?? 'starter') ?>"><?= e($tierPlan ? PLANS[$tierPlan]['name'] : ($w['tier'] !== '' ? ucfirst($w['tier']) : 'Free')) ?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>
    </div>
    <form method="post" class="form card" action="<?= e(url('profile' . (isset($_GET['next']) ? '?next=' . urlencode((string) $_GET['next']) : ''))) ?>">
      <?= csrf_field() ?>
      <div class="row-2">
        <label>Industry<input name="industry" placeholder="Landscaping, plumbing, roofing…" value="<?= e($profile['industry']) ?>"></label>
      </div>
      <label>Services * <span class="hint">One per line or comma-separated</span><textarea name="services" rows="3" required placeholder="Artificial turf installation, lawn care, irrigation repair"><?= e($profile['services']) ?></textarea></label>
      <div class="row-2">
        <label>Location *<input name="location" required placeholder="Phoenix, AZ" value="<?= e($profile['location']) ?>"></label>
      </div>
      <div class="row-2">
        <label>Brand voice
          <select name="brand_voice">
            <?php foreach (['friendly' => 'Friendly & approachable', 'professional' => 'Professional & trustworthy', 'bold' => 'Bold & energetic', 'warm' => 'Warm & family-owned', 'expert' => 'Expert & educational'] as $k => $v): ?>
              <option value="<?= e($k) ?>" <?= $profile['brand_voice'] === $k ? 'selected' : '' ?>><?= e($v) ?></option>
            <?php endforeach; ?>
          </select>
        </label>
      </div>
      <label>Service areas<textarea name="service_areas" rows="2" placeholder="Phoenix, Scottsdale, Tempe, Mesa"><?= e($profile['service_areas']) ?></textarea></label>
      <label>Specialties<textarea name="specialties" rows="2" placeholder="Pet-friendly turf, drought-tolerant designs, licensed & insured"><?= e($profile['specialties']) ?></textarea></label>
      <label>About your business<textarea name="description" rows="4" placeholder="Family-owned since 2012…"><?= e($profile['description']) ?></textarea></label>
      <label>Ideal customers<input name="audience" placeholder="Homeowners who want a low-maintenance yard" value="<?= e($profile['audience']) ?>"></label>
      <button class="btn btn-primary" type="submit">Save profile</button>
    </form>
  </div>
</section>
