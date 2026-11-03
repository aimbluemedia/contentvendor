<section class="section-sm">
  <div class="container">
    <p class="small"><a href="<?= e(url('library')) ?>">← Library</a></p>
    <div class="dash-head">
      <div>
        <p class="kicker"><?= e(GOALS[$campaign['goal']] ?? 'Campaign') ?> · <?= e(date('M j, Y', strtotime($campaign['created_at']))) ?></p>
        <h1 class="h2"><?= e(mb_strimwidth($campaign['idea'], 0, 120, '…')) ?></h1>
      </div>
      <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="approve_all"><button class="btn btn-primary" type="submit">Approve all drafts</button></form>
    </div>
    <div class="campaign-grid">
      <?php foreach ($items as $it): ?>
        <article class="card draft">
          <div class="item-top">
            <span class="chip"><?= channel_icon($it['channel']) ?> <?= e(channel_label($it['channel'])) ?></span>
            <span class="status status-<?= e($it['status']) ?>"><?= e(STATUS_LABELS[$it['status']]) ?></span>
          </div>
          <h3><?= e($it['title']) ?></h3>
          <div class="draft-body" id="body-<?= (int) $it['id'] ?>"><?= nl2br(e($it['body'])) ?></div>
          <div class="draft-actions">
            <button class="btn btn-ghost btn-sm" type="button" data-copy="#body-<?= (int) $it['id'] ?>">Copy</button>
            <a class="btn btn-ghost btn-sm" href="<?= e(url('item?id=' . $it['id'])) ?>">Edit / schedule</a>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
