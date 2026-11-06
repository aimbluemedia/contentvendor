<?php $plan = plan_of($user); ?>
<section class="section-sm">
  <div class="container">
    <?php require ROOT . '/app/views/_plan_banner.php'; ?>

    <?php if (!profile_is_complete($profile)): ?>
      <div class="flash flash-info">Finish your <a href="<?= e(url('profile')) ?>">business profile</a> (name, services and location) so ContentVendor can write about your business.</div>
    <?php endif; ?>

    <form class="promote card" method="get" action="<?= e(url('create')) ?>">
      <label for="idea"><strong>What would you like to promote today?</strong></label>
      <div class="promote-row">
        <input id="idea" name="idea" placeholder="We are offering 20% off backyard landscaping this month" required>
        <button class="btn btn-primary" type="submit">Create my campaign</button>
      </div>
      <div class="goal-pills">
        <?php foreach (GOALS as $k => $g): ?>
          <a href="<?= e(url('create?goal=' . $k)) ?>"><?= e($g) ?></a>
        <?php endforeach; ?>
      </div>
    </form>

    <div class="stats">
      <div class="stat"><b><?= (int) $counts['published'] ?></b><span>Published</span></div>
      <div class="stat"><b><?= (int) $counts['scheduled'] ?></b><span>Scheduled</span></div>
      <div class="stat"><b><?= (int) ($counts['draft'] + $counts['approved']) ?></b><span>Drafts & approved</span></div>
      <div class="stat"><b><?= max(0, $plan['generations'] - $used) ?><small>/<?= (int) $plan['generations'] ?></small></b><span>AI generations left this month</span></div>
    </div>

    <h2 class="h3">Your content tools</h2>
    <div class="tools">
      <a class="tool" href="<?= e(url('create')) ?>"><span>✨</span>AI Content Writer</a>
      <a class="tool" href="<?= e(url('calendar')) ?>"><span>📅</span>Social Calendar</a>
      <a class="tool" href="<?= e(url('library?channel=article')) ?>"><span>♻️</span>Repurpose Content</a>
      <a class="tool" href="<?= e(url('create?goal=special')) ?>"><span>🏷️</span>Promote an Offer</a>
      <a class="tool" href="<?= e(url('library')) ?>"><span>📚</span>My Campaigns</a>
      <a class="tool" href="<?= e(url('account')) ?>"><span>📈</span>Performance</a>
    </div>

    <div class="two-col">
      <div>
        <h2 class="h3">Recent content</h2>
        <?php if (!$recent): ?><p class="muted">Nothing yet — create your first campaign above.</p><?php endif; ?>
        <div class="item-list"><?php foreach ($recent as $it) require ROOT . '/app/views/_item_card.php'; ?></div>
      </div>
      <div>
        <h2 class="h3">Coming up</h2>
        <?php if (!$plan['scheduling']): ?>
          <div class="card upsell"><strong>Want posts ready all month?</strong><p>Pro and Premium add scheduling, a full calendar and turning articles into social posts.</p><a href="<?= e(url('account')) ?>">Compare plans →</a></div>
        <?php elseif (!$upcoming): ?>
          <p class="muted">No scheduled posts. Open any approved draft to schedule it.</p>
        <?php endif; ?>
        <div class="item-list"><?php foreach ($upcoming as $it) require ROOT . '/app/views/_item_card.php'; ?></div>
      </div>
    </div>
  </div>
</section>
