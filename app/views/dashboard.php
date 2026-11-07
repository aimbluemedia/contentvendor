<?php $plan = plan_of($user); ?>
<section class="section-sm">
  <div class="container">
    <?php require ROOT . '/app/views/_toutify_banner.php'; ?>

    <?php $myPlan = active_plan((int) $user['id']); ?>
    <?php if (!$myPlan): ?>
      <div class="td-start">
        <div class="td-start-copy">
          <span class="pc-step">Step 1 · Start here</span>
          <h2>Build your AI content plan</h2>
          <p>Tell us where you want to show up and how much time you have. We'll give you a simple to-do list every day, with the AI tool to finish each task in minutes.</p>
        </div>
        <ol class="td-steps"><li><b>Pick your platforms</b><small>Facebook, Google, TikTok…</small></li><li><b>Choose your time</b><small>5 to 60 minutes a day</small></li><li><b>Follow daily tasks</b><small>AI drafts every post</small></li></ol>
        <a class="pc-submit" href="<?= e(url('planner')) ?>">Create my plan · 2 minutes <span aria-hidden="true">→</span></a>
      </div>
    <?php else: ?>
      <?php $todayList = tasks_between((int) $user['id'], date('Y-m-d'), date('Y-m-d')); $todayDone = count(array_filter($todayList, fn($t) => $t['status'] !== 'todo')); ?>
      <div class="td-card">
        <div class="td-head">
          <div><span class="pc-step">Today's marketing tasks</span><h2><?= $todayList ? ($todayDone === count($todayList) ? 'All done for today 🎉' : (count($todayList) - $todayDone) . ' task' . (count($todayList) - $todayDone === 1 ? '' : 's') . ' left today') : 'No tasks today' ?></h2></div>
          <a href="<?= e(url('planner')) ?>">See full plan →</a>
        </div>
        <?php if ($todayList): ?><div class="pv-bar"><i style="width:<?= round($todayDone / count($todayList) * 100) ?>%"></i></div><?php endif; ?>
        <div class="tk-list">
          <?php $back = 'members'; foreach ($todayList as $t) require ROOT . '/app/views/_task_row.php'; ?>
          <?php if (!$todayList): ?><div class="tk-empty">Enjoy the break. <a href="<?= e(url('planner')) ?>">See what's next →</a></div><?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

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
