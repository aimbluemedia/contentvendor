<section class="section">
  <div class="container narrow-sm">
    <div class="card form-card tl-login">
      <h1><?= e($heading ?? 'Member login') ?></h1>
      <?php if (!empty($intro)): ?><p class="muted"><?= e($intro) ?></p><?php endif; ?>
      <a class="btn btn-primary btn-block btn-lg" href="<?= e(url('auth/toutify/login')) ?>">Log in with Toutify</a>
      <p class="small muted center">ContentVendor uses your Toutify account. Your password stays on Toutify.</p>
      <?php if ($signup ?? true): ?><p class="small center">New here? <a href="<?= e(url('signup')) ?>">Create a free account</a></p><?php endif; ?>
    </div>
  </div>
</section>
