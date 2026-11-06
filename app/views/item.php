<section class="section-sm">
  <div class="container narrow">
    <p class="small"><a href="<?= e(url($item['campaign_id'] ? 'campaign?id=' . $item['campaign_id'] : 'library')) ?>">← Back</a></p>
    <div class="dash-head">
      <h1 class="h2"><?= channel_icon($item['channel']) ?> <?= e(channel_label($item['channel'])) ?></h1>
      <span class="status status-<?= e($item['status']) ?>"><?= e(STATUS_LABELS[$item['status']]) ?><?= $item['scheduled_at'] ? ' · ' . e(date('M j, g:ia', strtotime($item['scheduled_at']))) : '' ?></span>
    </div>
    <?php require ROOT . '/app/views/_errors.php'; ?>
    <?php if ($item['source'] === 'demo'): ?><p class="small muted">Template draft (demo mode). Edit it to make it yours.</p><?php endif; ?>

    <form method="post" class="form card">
      <?= csrf_field() ?>
      <input type="hidden" name="action" value="save">
      <label>Title<input name="title" value="<?= e($item['title']) ?>"></label>
      <label>Content <span class="hint" data-charcount-for="body"></span><textarea id="body" name="body" rows="14"><?= e($item['body']) ?></textarea></label>
      <div class="actions">
        <button class="btn btn-primary" type="submit">Save changes</button>
        <button class="btn btn-ghost" type="button" data-copy="#body">Copy</button>
        <a class="btn btn-ghost" href="<?= e(url('item?id=' . $item['id'] . '&download=1')) ?>">Download</a>
      </div>
    </form>

    <div class="card">
      <h2 class="h3">Approve → Schedule → Publish</h2>
      <div class="actions">
        <?php if ($item['status'] === 'draft'): ?>
          <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="approve"><button class="btn btn-primary" type="submit">Approve</button></form>
        <?php else: ?>
          <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="draft"><button class="btn btn-ghost" type="submit">Back to draft</button></form>
        <?php endif; ?>
        <?php if ($item['status'] !== 'published'): ?>
          <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="published"><button class="btn btn-ghost" type="submit">I posted this</button></form>
        <?php endif; ?>
      </div>
      <?php if ($plan['scheduling']): ?>
        <form method="post" class="inline-form">
          <?= csrf_field() ?><input type="hidden" name="action" value="schedule">
          <label>Schedule for<input type="datetime-local" name="scheduled_at" required value="<?= e($item['scheduled_at'] ? date('Y-m-d\TH:i', strtotime($item['scheduled_at'])) : date('Y-m-d\T09:00', strtotime('+1 day'))) ?>"></label>
          <button class="btn btn-ghost" type="submit">Schedule</button>
        </form>
        <p class="small muted">Scheduled items appear on your calendar. Automatic publishing to Facebook, Instagram and Google Business Profile is rolling out as network approvals complete.</p>
      <?php else: ?>
        <p class="small muted">Copy or download this draft and post it yourself — or <a href="<?= e(url('account')) ?>">upgrade to Pro</a> to schedule it.</p>
      <?php endif; ?>
    </div>

    <div class="card">
      <h2 class="h3">Repurpose this content</h2>
      <?php if ($plan['scheduling']): ?>
        <form method="post" data-builder data-max="8">
          <?= csrf_field() ?><input type="hidden" name="action" value="repurpose">
          <div class="channel-picks">
            <?php $allowedCh = allowed_channels($user); foreach (CHANNELS as $k => $c): if ($k === $item['channel'] || !in_array($k, $allowedCh, true)) continue; ?>
              <label class="pick"><input type="checkbox" name="channels[]" value="<?= e($k) ?>" <?= in_array($k, ['facebook', 'instagram', 'google_business'], true) ? 'checked' : '' ?>><span><?= $c['icon'] ?> <?= e($c['label']) ?></span></label>
            <?php endforeach; ?>
          </div>
          <button class="btn btn-ghost" type="submit" data-loading="Repurposing…">Turn into new drafts</button>
        </form>
      <?php else: ?>
        <p class="small muted">Turning articles into social posts is included with Pro and Premium.</p>
      <?php endif; ?>
    </div>

    <form method="post" onsubmit="return confirm('Delete this content?');">
      <?= csrf_field() ?><input type="hidden" name="action" value="delete">
      <button class="link-button danger" type="submit">Delete this content</button>
    </form>
  </div>
</section>
