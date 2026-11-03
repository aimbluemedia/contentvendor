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
    <div class="calendar">
      <?php foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $d): ?><div class="cal-head"><?= $d ?></div><?php endforeach; ?>
      <?php for ($i = 0; $i < $lead; $i++): ?><div class="cal-day empty"></div><?php endfor; ?>
      <?php for ($d = 1; $d <= $daysInMonth; $d++): ?>
        <div class="cal-day<?= $d === $today ? ' today' : '' ?>">
          <span class="cal-num"><?= $d ?></span>
          <?php foreach ($byDay[$d] ?? [] as $it): ?>
            <a class="cal-item status-<?= e($it['status']) ?>" href="<?= e(url('item?id=' . $it['id'])) ?>" title="<?= e($it['title']) ?>"><?= channel_icon($it['channel']) ?> <?= e(date('g:ia', strtotime($it['scheduled_at']))) ?> <?= e(mb_strimwidth($it['title'], 0, 24, '…')) ?></a>
          <?php endforeach; ?>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>
