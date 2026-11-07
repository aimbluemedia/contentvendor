<section class="section">
  <div class="container narrow-sm">
    <div class="card form-card">
      <h1><?= e($heading ?? 'Welcome back') ?></h1>
      <?php if (!empty($intro)): ?><p class="muted"><?= e($intro) ?></p><?php endif; ?>
      <?php require ROOT . '/app/views/_errors.php'; ?>
      <form method="post" action="<?= e($action ?? url('members')) ?>" class="form">
        <?= csrf_field() ?>
        <input type="hidden" name="_gate" value="login">
        <label>Email<input type="email" name="email" required autocomplete="email" value="<?= e(old('email')) ?>"></label>
        <label>Password<input type="password" name="password" required autocomplete="current-password"></label>
        <p class="forgot-link"><a href="<?= e(url('forgot')) ?>">Forgot password?</a></p>
        <button class="btn btn-primary btn-block" type="submit">Log in</button>
      </form>
      <?php if ($signup ?? true): ?><p class="small center">New here? <a href="<?= e(url('register')) ?>">Create a free account</a></p><?php endif; ?>
    </div>
  </div>
</section>
