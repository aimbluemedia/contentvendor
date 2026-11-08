<?php
$tiers = [
    'starter' => [
        'label' => 'Free', 'verb' => 'Create it', 'best' => 'Getting started and posting a few times a month.',
        'lead' => 'Includes',
        'items' => [['Content posts + 1 social platform', false], ['5 AI drafts a month', false], ['7 free AI tools: posts, articles, Google updates, offers, video scripts, email', false], ['AI content plan with daily tasks', false], ['Copy & download everything', false]],
        'time' => ['Every day', 'You write and post each task yourself', '~15 min a day'],
    ],
    'pro' => [
        'label' => 'Pro', 'verb' => 'Schedule it', 'best' => 'Posting consistently every week without the daily scramble.',
        'lead' => 'Everything in Free, plus',
        'items' => [['3 social platforms (Facebook, Instagram, TikTok, YouTube, Reddit or Pinterest)', false], ['40 AI drafts a month (8× more)', false], ['Schedule 30 posts a month', false], ['Full content calendar', false], ['Turn one article into many posts', false], ['10 branded images a month', true]],
        'time' => ['Once a week', 'Batch your week in one sitting', 'Save ~10 hrs a month'],
    ],
    'premium' => [
        'label' => 'Premium', 'verb' => 'Automate it', 'best' => 'Owners who want their marketing planned and scheduled for them.',
        'lead' => 'Everything in Pro, plus',
        'items' => [['All 6 social platforms', false], ['150 AI drafts a month', false], ['Schedule 150 posts a month', false], ['AI monthly planner fills your month', true], ['Automatic recycling of your best posts', true], ['40 branded images a month', true], ['Advanced performance reports', false]],
        'time' => ['Once a month', 'Approve your whole month at once', 'Save 30+ hrs a month'],
    ],
];
$order = array_keys($tiers);
$curIdx = array_search($user['plan'], $order, true) ?: 0;
$upgradeUrl = config('upgrade_url') ?: url('done-for-you');
?>
<section class="section-sm">
  <div class="container">
    <?php require ROOT . '/app/views/_plan_banner.php'; ?>

    <div class="ap-head" id="plans">
      <div>
        <span class="pc-step">Compare plans</span>
        <h2>Pick the plan that fits your time</h2>
        <p class="muted">Every plan is part of your Toutify membership. Upgrade, downgrade or cancel anytime.</p>
      </div>
      <div class="ap-usage">
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

    <section class="ap-dfy" aria-labelledby="ap-dfy-title">
      <div class="ap-dfy-copy">
        <span class="ap-dfy-tag">Done For You</span>
        <h2 id="ap-dfy-title">Too busy to post? Let our team do it all.</h2>
        <p>Our content team uses AI to plan, write and publish a full month of content and social media for your business. You just approve it, and you stay ahead of the competition.</p>
        <div class="ap-dfy-price"><b>From $<?= number_format(min(array_column(PACKAGES, 'price'))) ?>/mo</b><span>Premium membership included · month to month</span></div>
        <a class="ap-dfy-btn" href="<?= e(url('done-for-you')) ?>">See Done For You <span aria-hidden="true">→</span></a>
      </div>
      <ul class="ap-dfy-list">
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/></svg></span><div><b>We plan your month</b><small>Campaigns built around your seasons, services and offers.</small></div></li>
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M4 20h4L19 9l-4-4L4 16z"/><path d="M13.5 6.5l4 4"/></svg></span><div><b>We write every post</b><small>Social posts for up to 6 networks, plus website articles.</small></div></li>
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M21 3L10 14"/><path d="M21 3l-7 18-4-7-7-4z"/></svg></span><div><b>We publish and report</b><small>Posts go out on schedule, with a report every month.</small></div></li>
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></span><div><b>You get 20+ hours back</b><small>Approve from your phone in minutes, or let us publish.</small></div></li>
      </ul>
    </section>
    <p class="ap-foot small muted"><a href="<?= e(url('pricing')) ?>">See the full feature comparison →</a> · Features marked “soon” are rolling out in phases.</p>
  </div>
</section>
