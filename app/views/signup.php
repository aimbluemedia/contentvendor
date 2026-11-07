<section class="section">
  <div class="container narrow-sm">
    <div class="card form-card">
      <h1>Create your free account</h1>
      <p class="muted">One free Toutify account gives you ContentVendor plus SearchMonster, MonsterList, PromoMonster and LeadCrazy. No credit card.</p>
      <?php require ROOT . '/app/views/_toutify_signup.php'; ?>
      <p class="small center">Already have an account? <a href="<?= e(url('auth/toutify/login')) ?>">Log in</a></p>
    </div>
  </div>
</section>
