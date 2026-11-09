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

    <?php if ($user['plan'] === 'premium'): ?>
      <section class="mp-card" data-month-writer data-total="<?= (int) $monthPending ?>">
        <div class="mp-copy">
          <span class="mp-tag">AI monthly planner</span>
          <?php if ($monthPending): ?>
            <h2>Write your whole month in one click.</h2>
            <p><?= (int) $monthPending ?> upcoming task<?= $monthPending === 1 ? '' : 's' ?> in the next 30 days don't have a draft yet. The AI writes each one so you can review and approve them all at once.</p>
          <?php else: ?>
            <h2>Your month is written.</h2>
            <p>Every task in the next 30 days has a draft ready. Review and approve them, then post them on their days.</p>
          <?php endif; ?>
          <div class="mp-bar" hidden><i></i></div>
          <p class="mp-status small" aria-live="polite"></p>
        </div>
        <div class="mp-actions">
          <?php if ($monthPending): ?>
            <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="write_month"><button class="btn btn-primary" type="submit" data-mp-go>Write my month (<?= (int) $monthPending ?> drafts)</button></form>
          <?php endif; ?>
          <?php if ($monthCampaign): ?><a class="mp-link" href="<?= e(url('campaign?id=' . $monthCampaign)) ?>">Review &amp; approve drafts →</a><?php endif; ?>
        </div>
      </section>
    <?php else: ?>
      <section class="mp-card mp-lock">
        <div class="mp-copy"><span class="mp-tag">Premium</span><h2>Let the AI write your whole month.</h2><p>Premium writes a draft for every task in your plan, so you approve the month in one sitting.</p></div>
        <div class="mp-actions"><a class="btn btn-primary" href="<?= e(url('account')) ?>">Upgrade to Premium</a></div>
      </section>
    <?php endif; ?>

    <h2 class="pv-h">Today · <?= e(date('l, M j')) ?></h2>
    <div class="tk-list">
      <?php $back = 'planner'; foreach (array_merge($overdue, $todayTasks) as $t) require ROOT . '/app/views/_task_row.php'; ?>
      <?php if (!$todayTasks && !$overdue): ?><div class="tk-empty">No tasks today. Enjoy the break! <a href="<?= e(url('calendar')) ?>">See your next posts on the calendar →</a></div><?php endif; ?>
    </div>

    <div class="pv-next">
      <span>Want to see what's coming up?</span>
      <a href="<?= e(url('calendar')) ?>">Open your calendar →</a>
      <a href="<?= e(url('posting-guide')) ?>">Posting guide →</a>
    </div>
<?php endif; ?>
  </div>
</section>
<script>
(function () {
  var card = document.querySelector('[data-month-writer]');
  var go = card && card.querySelector('[data-mp-go]');
  if (!go || !window.fetch) return;
  var form = go.form, total = +card.getAttribute('data-total'), bar = card.querySelector('.mp-bar'), fill = bar.querySelector('i'), status = card.querySelector('.mp-status');
  form.addEventListener('submit', function (e) {
    e.preventDefault(); go.disabled = true; bar.hidden = false;
    var done = 0, body = new FormData(form); body.set('action', 'write_one');
    (function next() {
      status.textContent = 'Writing draft ' + (done + 1) + ' of ' + total + '…';
      fetch(form.getAttribute('action') || location.href, { method: 'POST', body: body, credentials: 'same-origin' })
        .then(function (r) { return r.json(); })
        .then(function (d) {
          if (!d.ok) { status.textContent = d.error; go.disabled = false; return; }
          done += d.written; fill.style.width = Math.min(100, done / total * 100) + '%';
          if (d.left > 0 && d.written > 0) return next();
          status.textContent = 'Done! ' + done + ' drafts written.'; setTimeout(function () { location.reload(); }, 800);
        })
        .catch(function () { status.textContent = 'Connection problem. Click again to continue.'; go.disabled = false; });
    })();
  });
})();
</script>
