<a class="item-card" href="<?= e(url('item?id=' . $it['id'])) ?>">
  <div class="item-top">
    <span class="chip"><?= channel_icon($it['channel']) ?> <?= e(channel_label($it['channel'])) ?></span>
    <span class="status status-<?= e($it['status']) ?>"><?= e(STATUS_LABELS[$it['status']] ?? $it['status']) ?></span>
  </div>
  <strong><?= e($it['title'] !== '' ? $it['title'] : channel_label($it['channel'])) ?></strong>
  <p><?= e(mb_strimwidth(preg_replace('/\s+/', ' ', $it['body']), 0, 140, '…')) ?></p>
  <?php if ($it['scheduled_at']): ?><span class="small muted">📅 <?= e(date('D M j, g:ia', strtotime($it['scheduled_at']))) ?></span><?php endif; ?>
</a>
