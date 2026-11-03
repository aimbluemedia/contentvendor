<section class="section">
  <div class="container narrow-sm">
    <div class="card form-card">
      <h1>Welcome back</h1>
      <?php require ROOT . '/app/views/_errors.php'; ?>
      <form method="post" action="<?= e(url('login')) ?>" class="form">
        <?= csrf_field() ?>
        <label>Email<input type="email" name="email" required autocomplete="email" value="<?= e(old('email')) ?>"></label>
        <label>Password<input type="password" name="password" required autocomplete="current-password"></label>
        <button class="btn btn-primary btn-block" type="submit">Log in</button>
      </form>
      <p class="small center">New here? <a href="<?= e(url('register')) ?>">Create a free account</a></p>
    </div>
  </div>
</section>
