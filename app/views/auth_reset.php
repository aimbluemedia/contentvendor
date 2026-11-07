<section class="section">
  <div class="container narrow-sm">
    <div class="card form-card">
      <h1>Choose a new password</h1>
      <?php if (!$valid): ?>
        <div class="flash flash-error">This reset link is invalid or has expired. Reset links work once and last 1 hour.</div>
        <a class="btn btn-primary btn-block" href="<?= e(url('forgot')) ?>">Send a new reset link</a>
      <?php else: ?>
        <p class="muted">Pick a password with at least 8 characters.</p>
        <?php require ROOT . '/app/views/_errors.php'; ?>
        <form method="post" action="<?= e(url('reset')) ?>" class="form">
          <?= csrf_field() ?>
          <input type="hidden" name="token" value="<?= e($token) ?>">
          <label>New password<input type="password" name="password" required minlength="8" autocomplete="new-password"></label>
          <label>Confirm new password<input type="password" name="password_confirm" required minlength="8" autocomplete="new-password"></label>
          <button class="btn btn-primary btn-block" type="submit">Save new password</button>
        </form>
      <?php endif; ?>
    </div>
  </div>
</section>
