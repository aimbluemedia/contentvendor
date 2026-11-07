<section class="section">
  <div class="container narrow-sm">
    <div class="card form-card">
      <h1>Create your free account</h1>
      <p class="muted">5 AI content generations every month, free. No credit card.</p>
      <?php require ROOT . '/app/views/_errors.php'; ?>
      <form method="post" action="<?= e(url('register')) ?>" class="form">
        <?= csrf_field() ?>
        <label>Your name<input name="name" required autocomplete="name" value="<?= e(old('name')) ?>"></label>
        <label>Email<input type="email" name="email" required autocomplete="email" value="<?= e(old('email')) ?>"></label>
        <label>Password<input type="password" name="password" required minlength="8" autocomplete="new-password"></label>
        <button class="btn btn-primary btn-block" type="submit">Create account</button>
      </form>
      <p class="small center">Already have an account? <a href="<?= e(url('members')) ?>">Log in</a></p>
    </div>
  </div>
</section>
