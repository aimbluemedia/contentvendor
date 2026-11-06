<?php
$tiers = [
    'starter' => [
        'label' => 'Free', 'verb' => 'Create it', 'best' => 'Getting started and posting a few times a month.',
        'lead' => 'Includes',
        'items' => [['5 AI drafts a month', false], ['7 free AI tools: posts, articles, Google updates, offers, video scripts, email', false], ['AI content plan with daily tasks', false], ['Copy & download everything', false]],
        'time' => ['Every day', 'You write and post each task yourself', '~15 min a day'],
    ],
    'pro' => [
        'label' => 'Pro', 'verb' => 'Schedule it', 'best' => 'Posting consistently every week without the daily scramble.',
        'lead' => 'Everything in Free, plus',
        'items' => [['40 AI drafts a month (8× more)', false], ['Schedule 30 posts a month', false], ['Full content calendar', false], ['Turn one article into many posts', false], ['10 branded images a month', true]],
        'time' => ['Once a week', 'Batch your week in one sitting', 'Save ~10 hrs a month'],
    ],
    'premium' => [
        'label' => 'Premium', 'verb' => 'Automate it', 'best' => 'Owners who want their marketing planned and scheduled for them.',
        'lead' => 'Everything in Pro, plus',
        'items' => [['150 AI drafts a month', false], ['Schedule 150 posts a month', false], ['AI monthly planner fills your month', true], ['Automatic recycling of your best posts', true], ['40 branded images a month', true], ['Advanced performance reports', false]],
        'time' => ['Once a month', 'Approve your whole month at once', 'Save 30+ hrs a month'],
    ],
];
$order = array_keys($tiers);
$curIdx = array_search($user['plan'], $order, true) ?: 0;
$upgradeUrl = config('upgrade_url') ?: url('done-for-you');
?>
<section class="section-sm">
  <div class="container">
    <div class="ap-head">
      <div>
        <span class="pc-step">My plan</span>
        <h1>Pick the plan that fits your time</h1>
        <p class="muted">Every plan is part of your Toutify membership. Upgrade, downgrade or cancel anytime.</p>
      </div>
      <div class="ap-usage">
        <div><span>Current plan</span><b><?= e($tiers[$user['plan']]['label'] ?? $plan['name']) ?> · <?= e(money($plan['price'], true)) ?>/mo</b></div>
        <div><span>AI drafts this month</span><b><?= (int) $used ?> / <?= (int) $plan['generations'] ?></b></div>
        <div><span>Scheduled this month</span><b><?= (int) $scheduled ?> / <?= (int) $plan['scheduled_posts'] ?></b></div>
      </div>
    </div>

    <div class="ap-plans">
      <?php foreach ($tiers as $key => $t): $p = PLANS[$key]; $i = array_search($key, $order, true); $isCur = $key === $user['plan']; ?>
        <div class="ap-card<?= $isCur ? ' is-current' : '' ?><?= $key === 'premium' ? ' is-hero' : '' ?>">
          <?php if ($isCur): ?><span class="ap-ribbon">Your plan</span><?php elseif ($key === 'premium'): ?><span class="ap-ribbon hot">Most time saved</span><?php endif; ?>
          <span class="ap-verb"><?= e($t['label']) ?> · <?= e($t['verb']) ?></span>
          <div class="ap-price"><?= e(money($p['price'], true)) ?><small>/month</small></div>
          <p class="ap-best"><b>Best for:</b> <?= e($t['best']) ?></p>
          <div class="ap-time">
            <span class="ap-time-when"><?= e($t['time'][0]) ?></span>
            <div><b><?= e($t['time'][1]) ?></b><small><?= e($t['time'][2]) ?></small></div>
          </div>
          <span class="ap-lead"><?= e($t['lead']) ?></span>
          <ul class="ap-list">
            <?php foreach ($t['items'] as [$txt, $soon]): ?><li><?= e($txt) ?><?php if ($soon): ?> <em>soon</em><?php endif; ?></li><?php endforeach; ?>
          </ul>
          <?php if ($isCur): ?>
            <span class="ap-btn ghost">✓ Your current plan</span>
          <?php elseif ($i > $curIdx): ?>
            <a class="ap-btn" href="<?= e($upgradeUrl) ?>">Upgrade to <?= e($t['label']) ?> →</a>
          <?php else: ?>
            <a class="ap-btn ghost" href="<?= e($upgradeUrl) ?>">Switch to <?= e($t['label']) ?></a>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="ap-why">
      <h2>Why upgrade?</h2>
      <div class="ap-why-grid">
        <div><b>More drafts, less writing</b><p>Free gives you 5 AI drafts a month. Pro gives 40 and Premium 150, enough to follow your daily plan without writing posts yourself.</p></div>
        <div><b>Post on autopilot</b><p>Pro and Premium let you schedule posts ahead, so a busy week never means going quiet online.</p></div>
        <div><b>Your month, planned for you</b><p>Premium's AI planner fills your calendar each month. You approve once and you're done.</p></div>
      </div>
      <p class="ap-links"><a href="<?= e(url('pricing')) ?>">See the full feature comparison →</a> · <a href="<?= e(url('done-for-you')) ?>">Prefer we do it all for you? Done-for-you from $299/mo →</a></p>
      <p class="small muted">Features marked “soon” are rolling out in phases.</p>
    </div>
  </div>
</section>
