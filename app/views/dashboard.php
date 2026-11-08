<?php
/** Members dashboard: Toutify banner + the 3 setup cards that must be done before posting */
$doneCount = count(array_filter($steps));
$allDone = $doneCount === 3;
$next = array_search(false, $steps, true); // first unfinished step

$myPlan = $steps['plan'] ? active_plan((int) $user['id']) : null;
$platforms = $steps['platforms'] ? enabled_platforms($user) : [];
$todayList = $myPlan ? tasks_between((int) $user['id'], date('Y-m-d'), date('Y-m-d')) : [];
$todayLeft = count(array_filter($todayList, fn($t) => $t['status'] === 'todo'));
if ($myPlan) {
    $dayKeys = array_map('intval', array_filter(explode(',', (string) $myPlan['days']))); sort($dayKeys);
    $planDays = count($dayKeys) === 7 ? 'Every day' : ($dayKeys === [1, 2, 3, 4, 5] ? 'Mon–Fri' : implode(', ', array_map(fn($d) => WEEKDAYS[$d] ?? '', $dayKeys)));
    $planEffort = PLAN_EFFORT[(int) $myPlan['minutes']][0] ?? ((int) $myPlan['minutes'] . ' minutes a day');
}

$cards = [
    'profile' => [
        'title' => 'Business profile',
        'icon'  => '<path d="M3 21h18M5 21V8l7-5 7 5v13"/><path d="M9 21v-6h6v6"/>',
        'todo'  => 'Add your business name, services and location so the AI writes about your business.',
        'chips' => $steps['profile'] ? array_filter([$profile['business_name'], $profile['location']]) : [],
        'cta'   => $steps['profile'] ? ['Edit profile', url('profile')] : ['Complete my profile', url('profile')],
    ],
    'platforms' => [
        'title' => 'My platforms',
        'icon'  => '<rect x="3" y="3" width="7" height="7" rx="2"/><rect x="14" y="3" width="7" height="7" rx="2"/><rect x="3" y="14" width="7" height="7" rx="2"/><rect x="14" y="14" width="7" height="7" rx="2"/>',
        'todo'  => 'Choose the social platforms you want to post on. Your plan includes ' . platform_limit($user) . '.',
        'chips' => array_map(fn($k) => SOCIAL_PLATFORMS[$k][0], $platforms),
        'cta'   => $steps['platforms'] ? ['Edit platforms', url('platforms')] : ['Choose my platforms', url('platforms')],
    ],
    'plan' => [
        'title' => 'My content plan',
        'icon'  => '<path d="M9 11l3 3 8-8"/><path d="M20 12v7a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h9"/>',
        'todo'  => 'Decide your daily schedule. You get a short to-do list every day and the AI drafts each post.',
        'chips' => $myPlan ? [$planEffort, $planDays, $todayLeft ? $todayLeft . ' task' . ($todayLeft === 1 ? '' : 's') . ' today' : 'Nothing left today'] : [],
        'cta'   => $myPlan ? ['Edit plan', url('planner?edit=1')] : ['Create my plan', url('planner')],
    ],
];
?>
<section class="section-sm">
  <div class="container">
    <?php require ROOT . '/app/views/_toutify_banner.php'; ?>

    <div class="su-head">
      <div>
        <?php if ($allDone): ?>
          <span class="su-kicker done">✓ Setup complete</span>
          <h2>You're all set. Start posting!</h2>
          <p>Your profile, platforms and daily plan are ready. Follow today's tasks or create a campaign.</p>
        <?php else: ?>
          <span class="su-kicker">Start here first</span>
          <h2>Finish these 3 steps to start posting</h2>
          <p>All 3 need to be done before you can create and post content.</p>
        <?php endif; ?>
      </div>
      <div class="su-progress">
        <b><?= $doneCount ?> of 3 done</b>
        <div class="su-bar"><i style="width:<?= round($doneCount / 3 * 100) ?>%"></i></div>
        <?php if ($allDone): ?><a class="su-go" href="<?= e(url('planner')) ?>">Today's tasks →</a><?php endif; ?>
      </div>
    </div>

    <div class="su-cards">
      <?php $n = 0; foreach ($cards as $key => $c): $n++; $done = $steps[$key]; $isNext = $key === $next; ?>
        <article class="su-card<?= $done ? ' is-done' : '' ?><?= $isNext ? ' is-next' : '' ?>">
          <div class="su-top">
            <span class="su-ico" aria-hidden="true"><svg viewBox="0 0 24 24"><?= $c['icon'] ?></svg></span>
            <?php if ($done): ?><span class="su-status ok">✓ Done</span><?php elseif ($isNext): ?><span class="su-status next">Do this next</span><?php else: ?><span class="su-status">Step <?= $n ?></span><?php endif; ?>
          </div>
          <span class="su-step">Step <?= $n ?></span>
          <h3><?= e($c['title']) ?></h3>
          <?php if ($done && $c['chips']): ?>
            <ul class="su-chips"><?php foreach ($c['chips'] as $chip): ?><li><?= e($chip) ?></li><?php endforeach; ?></ul>
          <?php else: ?>
            <p><?= e($c['todo']) ?></p>
          <?php endif; ?>
          <a class="su-btn<?= $done ? ' ghost' : '' ?>" href="<?= e($c['cta'][1]) ?>"><?= $done ? '✎ ' : '' ?><?= e($c['cta'][0]) ?><?= $done ? '' : ' <span aria-hidden="true">→</span>' ?></a>
        </article>
      <?php endforeach; ?>
    </div>

    <?php if ($allDone): $nextDay = next_task_day((int) $user['id']); ?>
      <section class="nx" aria-labelledby="nx-title">
        <div class="nx-head">
          <div>
            <span class="nx-kicker"><i></i> Your next post</span>
            <?php if ($nextDay): [$nxDate, $nxTasks] = $nextDay;
              $nxWhen = $nxDate === date('Y-m-d') ? 'Today · ' : ($nxDate === date('Y-m-d', strtotime('+1 day')) ? 'Tomorrow · ' : ''); ?>
              <h2 id="nx-title"><?= e($nxWhen . date($nxWhen ? 'D, M j' : 'l, M j', strtotime($nxDate))) ?></h2>
              <p><?= count($nxTasks) ?> post<?= count($nxTasks) === 1 ? '' : 's' ?> to publish on
                <?php $nxPl = array_values(array_unique(array_map(fn($t) => platform_label($t['platform']), $nxTasks))); echo e(implode(', ', $nxPl)); ?></p>
            <?php else: ?>
              <h2 id="nx-title">No posts scheduled yet</h2>
              <p>Your plan has no open tasks coming up. Edit your plan to get a fresh month of posts.</p>
            <?php endif; ?>
          </div>
          <a class="su-btn" href="<?= e(url('planner')) ?>">Go to My Content Plan <span aria-hidden="true">→</span></a>
        </div>
        <?php if ($nextDay): ?>
          <ul class="nx-list">
            <?php foreach ($nxTasks as $t): $pl = PLAN_PLATFORMS[$t['platform']] ?? [ucfirst($t['platform']), '', 10]; ?>
              <li>
                <span class="tk-pl tk-pl-<?= e($t['platform']) ?>"><?= e($pl[0]) ?></span>
                <div><b><?= e($t['idea']) ?></b><small><?= e(GOALS[$t['goal']] ?? '') ?> · ~<?= (int) $pl[2] ?> min</small></div>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </section>
    <?php endif; ?>
  </div>
</section>
