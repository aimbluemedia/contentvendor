<div class="plans">
  <?php foreach (PACKAGES as $key => $pkg): ?>
    <div class="plan<?= !empty($pkg['featured']) ? ' featured' : '' ?>">
      <?php if (!empty($pkg['featured'])): ?><span class="badge">Most popular</span><?php endif; ?>
      <p class="kicker"><?= e($pkg['name']) ?></p>
      <div class="price">$<?= number_format($pkg['price']) ?><small>/month</small></div>
      <p><?= e($pkg['for']) ?></p>
      <ul class="ticks"><?php foreach ($pkg['includes'] as $inc): ?><li><?= e($inc) ?></li><?php endforeach; ?></ul>
      <a class="btn <?= !empty($pkg['featured']) ? 'btn-primary' : 'btn-ghost' ?> btn-block" href="<?= e(url('done-for-you?package=' . $key)) ?>#request">Get started</a>
    </div>
  <?php endforeach; ?>
</div>
<p class="small muted">One social campaign is one original concept adapted into platform-specific posts. All packages require customer-provided business information and assets; original video production and on-site photography are excluded. Elite niche directories are available separately at $99/month, subject to approval.</p>
