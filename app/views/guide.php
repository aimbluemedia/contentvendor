<?php
/** Posting Guide: how to publish on each platform. Platforms in the member's plan come first. */
$order = array_merge(array_values(array_intersect($mine, array_keys(POSTING_GUIDE))), array_values(array_diff(array_keys(POSTING_GUIDE), $mine)));
?>
<section class="section-sm">
  <div class="container">
    <div class="gd-head">
      <span class="pc-step">Posting guide</span>
      <h1>How to post on each platform</h1>
      <p class="muted">ContentVendor writes the post. These quick steps show you where to paste it and how to publish it. Most take under 5 minutes.</p>
      <nav class="gd-jump" aria-label="Jump to a platform">
        <?php foreach ($order as $k): ?><a class="tk-pl tk-pl-<?= e($k) ?>" href="#<?= e($k) ?>"><?= e(POSTING_GUIDE[$k]['title']) ?></a><?php endforeach; ?>
      </nav>
    </div>

    <div class="gd-list">
      <?php foreach ($order as $k): $g = POSTING_GUIDE[$k]; ?>
        <article class="gd-card" id="<?= e($k) ?>">
          <header class="gd-card-head">
            <div>
              <span class="tk-pl tk-pl-<?= e($k) ?>"><?= e($g['title']) ?></span>
              <?php if (in_array($k, $mine, true)): ?><span class="gd-mine">In your plan</span><?php endif; ?>
              <h2>How to post on <?= e($g['title']) ?></h2>
            </div>
          </header>
          <dl class="gd-facts">
            <div><dt>Where</dt><dd><?= e($g['where']) ?></dd></div>
            <div><dt>Format</dt><dd><?= e($g['format']) ?></dd></div>
            <div><dt>Best time</dt><dd><?= e($g['best']) ?></dd></div>
          </dl>
          <div class="gd-body">
            <ol class="gd-steps"><?php foreach ($g['steps'] as $st): ?><li><?= e($st) ?></li><?php endforeach; ?></ol>
            <div class="gd-tips"><b>Tips</b><ul><?php foreach ($g['tips'] as $tp): ?><li><?= e($tp) ?></li><?php endforeach; ?></ul></div>
          </div>
          <a class="gd-top" href="#top">↑ Back to top</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
