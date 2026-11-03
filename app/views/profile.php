<section class="section-sm">
  <div class="container narrow">
    <h1>Business profile</h1>
    <p class="muted">Enter your information once. Every ContentVendor tool uses it to write content that sounds like your business — no repeated typing.</p>
    <?php require ROOT . '/app/views/_errors.php'; ?>
    <form method="post" class="form card" action="<?= e(url('profile' . (isset($_GET['next']) ? '?next=' . urlencode((string) $_GET['next']) : ''))) ?>">
      <?= csrf_field() ?>
      <div class="row-2">
        <label>Business name *<input name="business_name" required value="<?= e($profile['business_name']) ?>"></label>
        <label>Industry<input name="industry" placeholder="Landscaping, plumbing, roofing…" value="<?= e($profile['industry']) ?>"></label>
      </div>
      <label>Services * <span class="hint">One per line or comma-separated</span><textarea name="services" rows="3" required placeholder="Artificial turf installation, lawn care, irrigation repair"><?= e($profile['services']) ?></textarea></label>
      <div class="row-2">
        <label>Location *<input name="location" required placeholder="Phoenix, AZ" value="<?= e($profile['location']) ?>"></label>
        <label>Phone<input name="phone" value="<?= e($profile['phone']) ?>"></label>
      </div>
      <div class="row-2">
        <label>Website<input name="website" placeholder="https://" value="<?= e($profile['website']) ?>"></label>
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
