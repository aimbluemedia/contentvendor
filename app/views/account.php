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
        'items' => [['3 social platforms (Facebook, Instagram, TikTok, YouTube, Reddit or Pinterest)', false], ['40 AI drafts a month (8× more)', false], ['Schedule 30 posts a month', false], ['Full content calendar', false], ['Turn one article into many posts', false], ['Image & video prompts for every post', false]],
        'time' => ['Once a week', 'Batch your week in one sitting', 'Save ~10 hrs a month'],
    ],
    'premium' => [
        'label' => 'Premium', 'verb' => 'Automate it', 'best' => 'Owners who want their marketing planned and scheduled for them.',
        'lead' => 'Everything in Pro, plus',
        'items' => [['All 6 social platforms', false], ['150 AI drafts a month', false], ['Schedule 150 posts a month', false], ['AI monthly planner writes your month', false], ['Automatic recycling of your older posts', false], ['Advanced performance dashboard', false]],
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
        <h2 id="ap-dfy-title">You have a million things to do. Let us handle your content.</h2>
        <p>Running and growing a business takes everything you've got. Now, with AI, our team can plan, write and publish your content and social media every month, so you can focus on the work only you can do.</p>
        <?php $dfyMin = min(array_column(PACKAGES, 'price')); ?>
        <div class="ap-dfy-price"><b>Under $<?= (int) floor($dfyMin * 12 / 365) + 1 ?> a day</b><span>From $<?= number_format($dfyMin) ?>/mo · Premium included · month to month</span></div>
        <a class="ap-dfy-btn" href="<?= e(url('done-for-you')) ?>">See Done For You <span aria-hidden="true">→</span></a>
      </div>
      <ul class="ap-dfy-list">
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><path fill-rule="evenodd" d="M7 2h2v2h6V2h2v2h2a2 2 0 0 1 2 2v13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2zM5 10v9h14v-9zm2 2h3v3H7z"/></svg></span><div><b>We plan your month</b><small>Campaigns built around your seasons, services and offers.</small></div></li>
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M15.2 3.3a1.5 1.5 0 0 1 2.1 0l3.4 3.4a1.5 1.5 0 0 1 0 2.1L9.5 20H4v-5.5z"/></svg></span><div><b>We write every post</b><small>Social posts for up to 6 networks, plus website articles.</small></div></li>
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M2.5 10.6 21.5 2.5l-8.1 19-2.6-7.8z"/></svg></span><div><b>We publish and report</b><small>Posts go out on schedule, with a report every month.</small></div></li>
        <li><span aria-hidden="true"><svg viewBox="0 0 24 24"><path fill-rule="evenodd" d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm1 5h-2v6.1l4.6 2.8 1-1.7-3.6-2.2z"/></svg></span><div><b>You get 20+ hours back</b><small>Approve from your phone in minutes, or let us publish.</small></div></li>
      </ul>
    </section>
    <p class="ap-foot small muted"><a href="<?= e(url('pricing')) ?>">See the full feature comparison →</a></p>
  </div>
</section>
