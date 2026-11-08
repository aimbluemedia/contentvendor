<?php
$daysInMonth = (int) date('t', $first);
$lead = (int) date('w', $first); // 0 = Sunday
$prev = date('Y-m', strtotime('-1 month', $first));
$next = date('Y-m', strtotime('+1 month', $first));
$today = date('Y-m') === date('Y-m', $first) ? (int) date('j') : 0;
?>
<section class="section-sm">
  <div class="container">
    <div class="dash-head">
      <h1><?= e(date('F Y', $first)) ?></h1>
      <div class="actions">
        <a class="btn btn-ghost btn-sm" href="<?= e(url('calendar?m=' . $prev)) ?>">← Prev</a>
        <a class="btn btn-ghost btn-sm" href="<?= e(url('calendar')) ?>">Today</a>
        <a class="btn btn-ghost btn-sm" href="<?= e(url('calendar?m=' . $next)) ?>">Next →</a>
      </div>
    </div>
    <?php if (!$plan['scheduling']): ?>
      <div class="flash flash-info">The free calendar shows what you've planned. Scheduling posts is included with Pro and Premium — <a href="<?= e(url('account')) ?>">compare plans</a>.</div>
    <?php endif; ?>
    <div class="cal-legend"><span><i class="cal-dot cal-dot-plan"></i>Planned posts from your content plan (tap one to see how to post it)</span><span><i class="cal-dot cal-dot-sched"></i>Scheduled content</span><a href="<?= e(url('planner')) ?>">Today's tasks →</a></div>
    <div class="calendar">
      <?php foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $d): ?><div class="cal-head"><?= $d ?></div><?php endforeach; ?>
      <?php for ($i = 0; $i < $lead; $i++): ?><div class="cal-day empty"></div><?php endfor; ?>
      <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>
        <div class="cal-day<?= $d === $today ? ' today' : '' ?>">
          <span class="cal-num"><?= $d ?></span>
          <?php foreach ($tasksByDay[$d] ?? [] as $t): $isToday = $d === $today; ?>
            <a class="cal-task tk-pl-<?= e($t['platform']) ?> is-<?= e($t['status']) ?>" href="<?= e($isToday ? url('planner') : guide_url($t['platform'])) ?>" title="<?= e(platform_label($t['platform']) . ': ' . $t['idea']) ?>"><?= $t['status'] === 'done' ? '✓ ' : '' ?><b><?= e(platform_label($t['platform'])) ?></b> <?= e(mb_strimwidth($t['idea'], 0, 34, '…')) ?></a>
          <?php endforeach; ?>
          <?php foreach ($byDay[$d] ?? [] as $it): ?>
            <a class="cal-item status-<?= e($it['status']) ?>" href="<?= e(url('item?id=' . $it['id'])) ?>" title="<?= e($it['title']) ?>"><?= channel_icon($it['channel']) ?> <?= e(date('g:ia', strtotime($it['scheduled_at']))) ?> <?= e(mb_strimwidth($it['title'], 0, 24, '…')) ?></a>
          <?php endforeach; ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>
