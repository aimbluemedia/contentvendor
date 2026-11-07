<section class="section">
  <div class="container narrow-sm">
    <div class="card form-card">
      <h1>Reset your password</h1>
      <?php if ($sent): ?>
        <div class="flash flash-success">If an account exists for that email, we've sent a link to reset your password. It expires in 1 hour.</div>
        <p class="muted small">Didn't get it? Check your spam folder, or try again in a few minutes.</p>
        <?php if (!empty($devLink)): ?><p class="small"><b>Debug mode:</b> <a href="<?= e($devLink) ?>">open reset link</a></p><?php endif; ?>
        <p class="small center"><a href="<?= e(url('members')) ?>">← Back to log in</a></p>
      <?php else: ?>
        <p class="muted">Enter the email you signed up with and we'll send you a link to choose a new password.</p>
        <?php require ROOT . '/app/views/_errors.php'; ?>
        <form method="post" action="<?= e(url('forgot')) ?>" class="form">
          <?= csrf_field() ?>
          <label>Email<input type="email" name="email" required autocomplete="email" value="<?= e(old('email')) ?>"></label>
          <button class="btn btn-primary btn-block" type="submit">Send reset link</button>
        </form>
        <p class="small center"><a href="<?= e(url('members')) ?>">← Back to log in</a></p>
      <?php endif; ?>
    </div>
  </div>
</section>
