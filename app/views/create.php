<section class="section-sm">
  <div class="container narrow">
    <?php if (!empty($task)): ?><div class="td-taskbar"><span class="pc-step">Today's task · <?= e(platform_label($task['platform'])) ?></span><p><?= e($task['idea']) ?></p><a href="<?= e(url('planner')) ?>">← Back to my plan</a></div><?php endif; ?>
    <h1>Campaign Builder</h1>
    <p class="muted">One idea becomes drafts for every destination you choose. Each destination uses one AI generation — you have <strong><?= (int) $left ?></strong> left this month.</p>
    <?php if (!profile_is_complete($profile)): ?>
      <div class="flash flash-info">First, <a href="<?= e(url('profile?next=create')) ?>">complete your business profile</a> so the drafts include your name, services and service area.</div>
    <?php endif; ?>
    <?php require ROOT . '/app/views/_errors.php'; ?>
    <form method="post" action="<?= e(url('create')) ?>" class="form card" data-builder data-max="<?= (int) $plan['campaign_channels'] ?>">
      <?= csrf_field() ?>
      <?php if (!empty($task)): ?><input type="hidden" name="task_id" value="<?= (int) $task['id'] ?>"><?php endif; ?>
      <fieldset>
        <legend>What's your goal?</legend>
        <div class="radio-pills">
          <?php foreach (GOALS as $k => $g): ?>
            <label><input type="radio" name="goal" value="<?= e($k) ?>" <?= $goal === $k ? 'checked' : '' ?>><span><?= e($g) ?></span></label>
          <?php endforeach; ?>
        </div>
      </fieldset>
      <label>Tell us about it in plain words
        <textarea name="idea" rows="4" required maxlength="2000" placeholder="We're offering $200 off artificial turf installation this month."><?= e($idea) ?></textarea>
      </label>
      <fieldset>
        <legend>Where should it go? <span class="hint" data-count></span></legend>
        <div class="channel-picks">
          <?php foreach (CHANNELS as $k => $c): ?>
            <label class="pick"><input type="checkbox" name="channels[]" value="<?= e($k) ?>" <?= in_array($k, $selected, true) ? 'checked' : '' ?>><span><?= $c['icon'] ?> <?= e($c['label']) ?></span></label>
          <?php endforeach; ?>
        </div>
        <?php if ($plan['campaign_channels'] < 8): ?>
          <p class="small muted">Free campaigns cover up to <?= (int) $plan['campaign_channels'] ?> destinations at once. <a href="<?= e(url('account')) ?>">Pro unlocks all 8.</a></p>
        <?php endif; ?>
      </fieldset>
      <button class="btn btn-primary btn-lg" type="submit" data-loading="Writing your campaign… this can take up to a minute">Create my campaign</button>
    </form>
  </div>
</section>
