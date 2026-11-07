<?php $plan = plan_of($user); ?>
<section class="section-sm">
  <div class="container">
    <?php require ROOT . '/app/views/_toutify_banner.php'; ?>

    <?php $myPlan = active_plan((int) $user['id']); ?>
    <?php if (!$myPlan): ?>
      <section class="cp cp-new" aria-labelledby="cp-title">
        <div class="cp-copy">
          <span class="cp-kicker cp-first"><i></i> Start here first</span>
          <h2 id="cp-title">Plan Your Daily <span>Content</span> and <span>Social Media</span></h2>
          <p>Tell us where you want to show up and how much time you have. Every day you get a short to-do list, and the AI writes each post for you in minutes.</p>
          <div class="cp-cta">
            <a class="cp-btn" href="<?= e(url('planner')) ?>">Create my plan <span aria-hidden="true">→</span></a>
            <span class="cp-note">⏱ Takes 2 minutes · Included on every plan</span>
          </div>
        </div>
        <ol class="cp-steps">
          <li><span class="cp-ico" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="2"/><rect x="14" y="3" width="7" height="7" rx="2"/><rect x="3" y="14" width="7" height="7" rx="2"/><rect x="14" y="14" width="7" height="7" rx="2"/></svg></span><div><b>Pick your platforms</b><small>Facebook, Google, TikTok, your blog…</small></div></li>
          <li><span class="cp-ico" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><div><b>Choose your time</b><small>From 5 minutes to an hour a day</small></div></li>
          <li><span class="cp-ico" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M9 11l3 3 8-8"/><path d="M20 12v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h9"/></svg></span><div><b>Follow your daily tasks</b><small>AI drafts every post, you hit publish</small></div></li>
        </ol>
      </section>
    <?php else: ?>
      <?php $todayList = tasks_between((int) $user['id'], date('Y-m-d'), date('Y-m-d')); $todayDone = count(array_filter($todayList, fn($t) => $t['status'] !== 'todo'));
        $planPlatforms = array_filter(explode(',', (string) $myPlan['platforms']));
        $dayKeys = array_map('intval', array_filter(explode(',', (string) $myPlan['days']))); sort($dayKeys);
        $planDaysLabel = count($dayKeys) === 7 ? 'Every day' : ($dayKeys === [1, 2, 3, 4, 5] ? 'Mon–Fri' : implode(', ', array_map(fn($d) => WEEKDAYS[$d] ?? '', $dayKeys)));
        $planEffort = PLAN_EFFORT[(int) $myPlan['minutes']][0] ?? ((int) $myPlan['minutes'] . ' minutes a day'); ?>
      <section class="cp cp-active" aria-labelledby="cp-title">
        <div class="cp-bar">
          <div class="cp-bar-copy">
            <span class="cp-kicker"><i></i> Your AI content plan is active</span>
            <ul class="cp-chips">
              <li>⏱ <?= e($planEffort) ?></li>
              <li>📅 <?= e($planDaysLabel) ?></li>
              <?php foreach ($planPlatforms as $pk): ?><li><?= e(platform_label($pk)) ?></li><?php endforeach; ?>
            </ul>
          </div>
          <div class="cp-bar-actions">
            <a class="cp-btn sm" href="<?= e(url('planner?edit=1')) ?>">✎ Edit plan</a>
            <a class="cp-link" href="<?= e(url('planner')) ?>">See full plan →</a>
          </div>
        </div>
        <div class="td-head">
          <div><span class="pc-step">Today's marketing tasks</span><h2 id="cp-title"><?= $todayList ? ($todayDone === count($todayList) ? 'All done for today 🎉' : (count($todayList) - $todayDone) . ' task' . (count($todayList) - $todayDone === 1 ? '' : 's') . ' left today') : 'No tasks today' ?></h2></div>
          <?php if ($todayList): ?><span class="cp-count"><?= $todayDone ?> / <?= count($todayList) ?> done</span><?php endif; ?>
        </div>
        <?php if ($todayList): ?><div class="pv-bar"><i style="width:<?= round($todayDone / count($todayList) * 100) ?>%"></i></div><?php endif; ?>
        <div class="tk-list">
          <?php $back = 'members'; foreach ($todayList as $t) require ROOT . '/app/views/_task_row.php'; ?>
          <?php if (!$todayList): ?><div class="tk-empty">Enjoy the break. <a href="<?= e(url('planner')) ?>">See what's next →</a></div><?php endif; ?>
        </div>
      </section>
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
