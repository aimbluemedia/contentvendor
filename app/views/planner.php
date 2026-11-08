<?php
$cur = $plan ? ['platforms' => explode(',', $plan['platforms']), 'minutes' => (int) $plan['minutes'], 'days' => array_map('intval', explode(',', $plan['days']))]
             : ['platforms' => ['facebook', 'instagram', 'google_business'], 'minutes' => 15, 'days' => [1, 2, 3, 4, 5]];
$planUser = plan_of($user);
?>
<section class="section-sm">
  <div class="container">
<?php if ($editing): ?>
    <div class="pc-hero">
      <span class="pc-step">Step 1 · Your daily marketing routine</span>
      <h1>AI Content Plan Creator</h1>
      <p>Answer 3 quick questions. We'll build a 4-week plan of small daily tasks, each with the AI tool to finish it in minutes.</p>
    </div>
    <?php require ROOT . '/app/views/_errors.php'; ?>
    <?php if (!profile_is_complete($profile)): ?>
      <div class="flash flash-info">Tip: <a href="<?= e(url('profile')) ?>">complete your business profile</a> first so your post ideas mention your services and area.</div>
    <?php endif; ?>
    <form method="post" action="<?= e(url('planner')) ?>" class="pc-form" data-plan-form>
      <?= csrf_field() ?><input type="hidden" name="action" value="create">

      <div class="pc-q">
        <div class="pc-q-head"><span>1</span><div><h2>Where do you want to show up?</h2><p>Pick the places your customers spend time. Start small. You can change this anytime.</p></div></div>
        <div class="pc-chips">
          <?php $okPl = planner_allowed_platforms($user); foreach (PLAN_PLATFORMS as $k => [$label]): if (!in_array($k, $okPl, true)) continue; ?>
            <label class="pc-chip"><input type="checkbox" name="platforms[]" value="<?= e($k) ?>" <?= in_array($k, $cur['platforms'], true) ? 'checked' : '' ?>><span><i class="tk-pl tk-pl-<?= e($k) ?>"></i><?= e($label) ?></span></label>
          <?php endforeach; ?>
          <?php foreach (PLAN_PLATFORMS as $k => [$label]): if ($k === 'email' || in_array($k, $okPl, true)) continue; ?>
            <a class="pick-locked" href="<?= e(url('platforms')) ?>">🔒 <?= e($label) ?></a>
          <?php endforeach; ?>
        </div>
        <p class="small muted pc-note">Social platforms follow <a href="<?= e(url('platforms')) ?>">My platforms</a>. Your plan lets you switch on <?= platform_limit($user) >= count(SOCIAL_PLATFORMS) ? 'all of them' : platform_limit($user) ?>.</p>
      </div>

      <div class="pc-q">
        <div class="pc-q-head"><span>2</span><div><h2>How much time can you give it?</h2><p>Be honest. A little every day beats a lot once a month.</p></div></div>
        <div class="pc-effort">
          <?php foreach (PLAN_EFFORT as $m => [$label, $desc]): ?>
            <label class="pc-eff"><input type="radio" name="minutes" value="<?= (int) $m ?>" <?= $cur['minutes'] === $m ? 'checked' : '' ?>><span><b><?= e($label) ?></b><small><?= e($desc) ?></small></span></label>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="pc-q">
        <div class="pc-q-head"><span>3</span><div><h2>Which days do you work on marketing?</h2><p>Your tasks only show up on these days.</p></div></div>
        <div class="pc-days">
          <?php foreach (WEEKDAYS as $n => $d): ?>
            <label class="pc-day"><input type="checkbox" name="days[]" value="<?= $n ?>" <?= in_array($n, $cur['days'], true) ? 'checked' : '' ?>><span><?= e($d) ?></span></label>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="pc-summary">
        <div><b data-plan-sum>About 5 tasks a week</b><small>Each task comes with an AI tool that drafts it for you. You just review and post.</small></div>
        <button class="pc-submit" type="submit">Build my plan <span aria-hidden="true">→</span></button>
      </div>
      <?php if ($plan): ?><p class="center small"><a href="<?= e(url('planner')) ?>">Cancel and keep my current plan</a></p><?php endif; ?>
    </form>
<?php else: ?>
    <div class="pv-head">
      <div>
        <span class="pc-step">Your daily marketing routine</span>
        <h1>My content plan</h1>
        <div class="pv-chips">
          <?php foreach (explode(',', $plan['platforms']) as $p): ?><span class="tk-pl tk-pl-<?= e($p) ?>"><?= e(platform_label($p)) ?></span><?php endforeach; ?>
          <span class="pv-chip"><?= e(PLAN_EFFORT[(int) $plan['minutes']][0] ?? '') ?></span>
          <span class="pv-chip"><?= e(implode(' · ', array_map(fn($d) => WEEKDAYS[(int) $d], explode(',', $plan['days'])))) ?></span>
        </div>
      </div>
      <a class="btn btn-ghost" href="<?= e(url('planner?edit=1')) ?>">Edit plan</a>
    </div>

    <div class="pv-progress">
      <div><b><?= (int) $weekDone ?> of <?= (int) $weekTotal ?></b> tasks done this week</div>
      <div class="pv-bar"><i style="width:<?= $weekTotal ? round($weekDone / $weekTotal * 100) : 0 ?>%"></i></div>
    </div>

    <?php if ($monthTasks > $planUser['generations']): ?>
      <div class="pv-upsell">
        <div><b>Your plan has <?= (int) $monthTasks ?> tasks in the next 4 weeks.</b> Your <?= e($planUser['name'] === 'Starter' ? 'Free' : $planUser['name']) ?> plan includes <?= (int) $planUser['generations'] ?> AI drafts a month, so you'll write some posts yourself.</div>
        <a href="<?= e(url('account')) ?>">See plans →</a>
      </div>
    <?php endif; ?>

    <h2 class="pv-h">Today · <?= e(date('l, M j')) ?></h2>
    <div class="tk-list">
      <?php $back = 'planner'; foreach (array_merge($overdue, $todayTasks) as $t) require ROOT . '/app/views/_task_row.php'; ?>
      <?php if (!$todayTasks && !$overdue): ?><div class="tk-empty">No tasks today. Enjoy the break! <a href="<?= e(url('calendar')) ?>">See your next posts on the calendar →</a></div><?php endif; ?>
    </div>

    <div class="pv-next">
      <span>Want to see what's coming up?</span>
      <a href="<?= e(url('calendar')) ?>">Open your calendar →</a>
      <a href="<?= e(url('posting-guide')) ?>">📘 Posting guide</a>
    </div>
<?php endif; ?>
  </div>
</section>
