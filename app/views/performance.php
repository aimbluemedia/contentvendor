<?php
/** Performance dashboard: Basic (Free), Standard (Pro), Advanced (Premium) */
$pro = in_array($tier, ['pro', 'premium'], true);
$prem = $tier === 'premium';
$maxWeek = max(1, max(array_column($s['weeks'], 'n')));
$maxCh = $s['channels'] ? max(array_column($s['channels'], 'n')) : 1;
$tierName = ['starter' => 'Basic', 'pro' => 'Standard', 'premium' => 'Advanced'][$tier] ?? 'Basic';
?>
<section class="section-sm">
  <div class="container">
    <div class="pf2-head">
      <div>
        <span class="pc-step">Performance</span>
        <h1>How your marketing is going</h1>
        <p class="muted">Your activity across ContentVendor: what you've posted, how consistent you are and where you're showing up.</p>
      </div>
      <span class="pf2-tier"><?= e($tierName) ?> dashboard</span>
    </div>

    <div class="pf2-tiles">
      <div class="pf2-tile"><span>Published this month</span><b><?= (int) $s['published_month'] ?></b><small><?= (int) $s['published_total'] ?> all time</small></div>
      <div class="pf2-tile"><span>Plan consistency</span><b><?= $s['consistency'] === null ? '–' : (int) $s['consistency'] . '%' ?></b><small><?= (int) $s['tasks_done'] ?> of <?= (int) $s['tasks_due'] ?> tasks, last 4 weeks</small></div>
      <div class="pf2-tile"><span>Active streak</span><b><?= (int) $s['streak'] ?> day<?= $s['streak'] === 1 ? '' : 's' ?></b><small>Days in a row you posted or finished a task</small></div>
      <div class="pf2-tile"><span>Ready to post</span><b><?= (int) $s['ready'] ?></b><small><?= (int) $s['scheduled'] ?> scheduled ahead</small></div>
    </div>

    <div class="pf2-grid">
      <div class="pf2-card<?= $pro ? '' : ' is-locked' ?>">
        <h2>Weekly activity</h2>
        <p class="muted small">Posts published or plan tasks finished each week.</p>
        <div class="pf2-chart" role="img" aria-label="Weekly activity chart">
          <?php $many = count($s['weeks']) > 8; foreach ($s['weeks'] as $wi => $w): ?>
            <div class="pf2-col"><span class="pf2-n"><?= (int) $w['n'] ?></span><i style="height:<?= max(4, round($w['n'] / $maxWeek * 100)) ?>%"></i><small><?= $many && $wi % 2 ? '&nbsp;' : e($w['label']) ?></small></div>
          <?php endforeach; ?>
        </div>
        <?php if (!$pro): ?><div class="pf2-lock"><b>Weekly activity is included with Pro and Premium.</b><a class="btn btn-primary btn-sm" href="<?= e(url('account')) ?>">See plans</a></div><?php endif; ?>
      </div>

      <div class="pf2-card<?= $pro ? '' : ' is-locked' ?>">
        <h2>Where you're showing up</h2>
        <p class="muted small">Published posts by channel, last 90 days.</p>
        <?php if (!$s['channels']): ?><p class="muted">No published posts yet. Tap "I posted this" on a draft after you post it.</p><?php endif; ?>
        <ul class="pf2-ch">
          <?php foreach ($s['channels'] as $c): ?>
            <li><span><?= channel_icon($c['channel']) ?> <?= e(channel_label($c['channel'])) ?></span><div><i style="width:<?= round($c['n'] / $maxCh * 100) ?>%"></i></div><b><?= (int) $c['n'] ?></b></li>
          <?php endforeach; ?>
        </ul>
        <?php if (!$pro): ?><div class="pf2-lock"><b>Channel breakdown is included with Pro and Premium.</b><a class="btn btn-primary btn-sm" href="<?= e(url('account')) ?>">See plans</a></div><?php endif; ?>
      </div>
    </div>

    <?php if ($prem): ?>
      <div class="pf2-grid">
        <div class="pf2-card">
          <h2>Recommendations</h2>
          <ul class="pf2-tips"><?php foreach (performance_tips($user, $s) as $tip): ?><li><?= e($tip) ?></li><?php endforeach; ?></ul>
        </div>
        <div class="pf2-card pf2-recycle">
          <h2>Automatic content recycling</h2>
          <?php $cands = recycle_candidates($user, 5); $last = last_recycle_at((int) $user['id']); ?>
          <p class="muted small">Once a week, your older published posts (45+ days) come back as refreshed drafts with new wording, so you stay active with zero effort.</p>
          <div class="pf2-rc">
            <div><b><?= recycled_count((int) $user['id'], date('Y-m-01')) ?></b><span>refreshed this month</span></div>
            <div><b><?= count($cands) ?></b><span>posts ready to recycle</span></div>
            <div><b><?= $last ? e(date('M j', strtotime($last))) : '–' ?></b><span>last refresh</span></div>
          </div>
          <form method="post"><?= csrf_field() ?><input type="hidden" name="action" value="recycle_now"><button class="btn btn-primary" type="submit" <?= $cands ? '' : 'disabled' ?> data-loading="Refreshing…">Refresh 2 posts now</button></form>
          <?php $rc = q("SELECT id FROM campaigns WHERE user_id = ? AND goal = 'recycle' ORDER BY id DESC LIMIT 1", [$user['id']])->fetchColumn(); if ($rc): ?>
            <a class="mp-link" href="<?= e(url('campaign?id=' . $rc)) ?>">Review recycled drafts →</a>
          <?php endif; ?>
        </div>
      </div>
    <?php else: ?>
      <div class="pf2-up">
        <div><b>Premium adds the advanced dashboard</b><p>Personal recommendations, 12 weeks of history and automatic recycling of your best posts.</p></div>
        <a class="btn btn-primary" href="<?= e(url('account')) ?>">Upgrade to Premium</a>
      </div>
    <?php endif; ?>
  </div>
</section>
