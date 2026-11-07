<?php
$plan = plan_of($user);
$all = count(SOCIAL_PLATFORMS);
$nextPlan = $user['plan'] === 'starter' ? ['Pro', 3] : ($user['plan'] === 'pro' ? ['Premium', $all] : null);
?>
<section class="section-sm">
  <div class="container">
    <div class="ap-head">
      <div>
        <span class="pc-step">My platforms</span>
        <h1>Choose where your tools post</h1>
        <p class="muted">Switch on the social platforms you use. Your AI tools, content plan and Campaign Builder create content for everything that's on.</p>
      </div>
      <div class="pf-count" data-pf-count>
        <b><span data-pf-used><?= count($enabled) ?></span> of <?= $limit >= $all ? $all : $limit ?></b>
        <small>social platforms on · <?= e($plan['name']) ?> plan</small>
      </div>
    </div>

    <form method="post" action="<?= e(url('platforms')) ?>" class="pf" data-pf data-limit="<?= (int) $limit ?>">
      <?= csrf_field() ?>
      <div class="pf-group">
        <div class="pf-group-head"><h2>Content posts</h2><span class="pf-tag">Included on every plan</span></div>
        <div class="pf-row is-locked-on">
          <span class="pf-ic" style="background:#16a34a">✎</span>
          <div class="pf-txt"><b>Content posts</b><small>Website articles, Google Business updates, email promotions and directory posts</small></div>
          <span class="pf-switch on" aria-label="Always on"><i></i></span>
        </div>
      </div>

      <div class="pf-group">
        <div class="pf-group-head">
          <h2>Social platforms</h2>
          <span class="pf-tag"><?= $limit >= $all ? 'All platforms included' : 'Choose ' . $limit . ' on your plan' ?></span>
        </div>
        <?php foreach (SOCIAL_PLATFORMS as $k => [$label, $icon, $color, $desc]): $on = in_array($k, $enabled, true); ?>
          <label class="pf-row">
            <span class="pf-ic" style="background:<?= e($color) ?>"><?= e($icon) ?></span>
            <span class="pf-txt"><b><?= e($label) ?></b><small><?= e($desc) ?></small></span>
            <span class="pf-lock" hidden>Plan limit reached</span>
            <input class="pf-input" type="checkbox" name="platforms[]" value="<?= e($k) ?>" <?= $on ? 'checked' : '' ?> role="switch" aria-label="<?= e($label) ?>">
            <span class="pf-switch" aria-hidden="true"><i></i></span>
          </label>
        <?php endforeach; ?>
        <p class="pf-hint" data-pf-hint hidden>To pick a different platform, switch one off first<?= $nextPlan ? ', or upgrade to ' . e($nextPlan[0]) . ' for more' : '' ?>.</p>
      </div>

      <?php if ($nextPlan): ?>
        <div class="pf-upsell">
          <div><b>Want more platforms?</b> <?= e($nextPlan[0]) ?> lets you switch on <?= $nextPlan[1] >= $all ? 'all ' . $all : $nextPlan[1] ?> social platforms<?= $nextPlan[0] === 'Pro' ? ' and schedule 30 posts a month' : ', with 150 AI drafts and automation' ?>.</div>
          <a href="<?= e(url('account')) ?>">Upgrade to <?= e($nextPlan[0]) ?> →</a>
        </div>
      <?php endif; ?>
      <div class="pf-save"><button class="ap-btn" type="submit">Save my platforms →</button></div>
    </form>
  </div>
</section>
