<section class="section">
  <div class="container">
    <div class="section-head center">
      <p class="kicker">Done-for-you · We handle it</p>
      <h1>Your content, handled by our team</h1>
      <p class="muted">We plan, write, schedule and report on your marketing using ContentVendor — the same platform you can log into anytime to review and approve.</p>
    </div>
    <?php require ROOT . '/app/views/_packages.php'; ?>
  </div>
</section>
<section class="section alt" id="request">
  <div class="container narrow">
    <h2>Request a package</h2>
    <p class="muted">Tell us a little about your business and we'll be in touch within one business day.</p>
    <?php require ROOT . '/app/views/_errors.php'; ?>
    <form method="post" action="<?= e(url('done-for-you')) ?>#request" class="form card">
      <?= csrf_field() ?>
      <label>Package
        <select name="package" required>
          <?php foreach (PACKAGES as $key => $pkg): ?>
            <option value="<?= e($key) ?>" <?= old('package', $selected) === $key ? 'selected' : '' ?>><?= e($pkg['name']) ?> — $<?= number_format($pkg['price']) ?>/mo</option>
          <?php endforeach; ?>
        </select>
      </label>
      <div class="row-2">
        <label>Your name<input name="name" required value="<?= e(old('name', $user['name'] ?? '')) ?>"></label>
        <label>Email<input type="email" name="email" required value="<?= e(old('email', $user['email'] ?? '')) ?>"></label>
      </div>
      <div class="row-2">
        <label>Phone<input name="phone" value="<?= e(old('phone')) ?>"></label>
        <label>Business name<input name="business" value="<?= e(old('business')) ?>"></label>
      </div>
      <label>Anything we should know?<textarea name="message" rows="4" placeholder="Services, goals, current marketing…"><?= e(old('message')) ?></textarea></label>
      <button class="btn btn-primary" type="submit">Send request</button>
    </form>
  </div>
</section>
