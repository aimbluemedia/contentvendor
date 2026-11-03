<section class="section-sm">
  <div class="container">
    <div class="dash-head">
      <h1>Content library</h1>
      <a class="btn btn-primary" href="<?= e(url('create')) ?>">New campaign</a>
    </div>
    <form class="filters" method="get" action="<?= e(url('library')) ?>">
      <input type="search" name="q" placeholder="Search content" value="<?= e($search) ?>">
      <select name="status"><option value="">All statuses</option><?php foreach (STATUS_LABELS as $k => $v): ?><option value="<?= e($k) ?>" <?= $status === $k ? 'selected' : '' ?>><?= e($v) ?></option><?php endforeach; ?></select>
      <select name="channel"><option value="">All destinations</option><?php foreach (CHANNELS as $k => $c): ?><option value="<?= e($k) ?>" <?= $channel === $k ? 'selected' : '' ?>><?= e($c['label']) ?></option><?php endforeach; ?></select>
      <button class="btn btn-ghost" type="submit">Filter</button>
    </form>
    <div class="two-col wide-left">
      <div>
        <?php if (!$items): ?><p class="muted">No content found.</p><?php endif; ?>
        <div class="item-grid"><?php foreach ($items as $it) require ROOT . '/app/views/_item_card.php'; ?></div>
      </div>
      <aside>
        <h2 class="h3">My campaigns</h2>
        <?php if (!$campaigns): ?><p class="muted small">No campaigns yet.</p><?php endif; ?>
        <ul class="campaign-list">
          <?php foreach ($campaigns as $c): ?>
            <li><a href="<?= e(url('campaign?id=' . $c['id'])) ?>"><?= e(mb_strimwidth($c['idea'], 0, 60, '…')) ?></a><span class="small muted"><?= (int) $c['n'] ?> pieces · <?= e(date('M j', strtotime($c['created_at']))) ?></span></li>
          <?php endforeach; ?>
        </ul>
      </aside>
    </div>
  </div>
</section>
