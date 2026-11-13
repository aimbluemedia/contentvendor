<?php
$slug = fn($t) => trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($t)), '-');
$other = $doc === 'terms' ? ['privacy', 'Privacy Policy'] : ['terms', 'Terms of Service'];
?>
<section class="lg">
  <div class="container lg-wrap">
    <header class="lg-head">
      <span class="m-eyebrow">Legal</span>
      <h1><?= e($title) ?></h1>
      <p class="muted">Last updated <?= e(legal_updated()) ?> · ContentVendor by <?= e(legal_company()) ?></p>
    </header>
    <div class="lg-grid">
      <nav class="lg-toc" aria-label="On this page">
        <b>On this page</b>
        <?php foreach ($sections as [$h]): ?><a href="#<?= e($slug($h)) ?>"><?= e($h) ?></a><?php endforeach; ?>
        <a class="lg-other" href="<?= e(url($other[0])) ?>">Read our <?= e($other[1]) ?> →</a>
      </nav>
      <article class="lg-body">
        <?php foreach ($sections as $i => [$h, $paras]): ?>
          <section id="<?= e($slug($h)) ?>">
            <h2><span><?= $i + 1 ?>.</span> <?= e($h) ?></h2>
            <?php foreach ($paras as $p): ?>
              <?php if (is_array($p)): ?>
                <ul><?php foreach ($p['list'] as $li): ?><li><?= e($li) ?></li><?php endforeach; ?></ul>
              <?php elseif ($p === '__contact__'): ?>
                <p>Questions about this <?= $doc === 'terms' ? 'agreement' : 'policy' ?> or a privacy request? Contact <?= e(legal_company()) ?>.<br><?= legal_contact_html() ?></p>
              <?php else: ?>
                <p><?= preg_replace('/\*\*(.+?)\*\*/', '<b>$1</b>', e($p)) ?></p>
              <?php endif; ?>
            <?php endforeach; ?>
          </section>
        <?php endforeach; ?>
      </article>
    </div>
  </div>
</section>
