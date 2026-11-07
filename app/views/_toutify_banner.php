<?php
/** Members dashboard: compact Toutify membership banner (full plan journey lives on My plan) */
$firstName = trim(strtok((string) $user['name'], ' ')) ?: 'there';
$cur = plan_of($user);
$planLabel = $cur['name'] === 'Starter' ? 'Free' : $cur['name'];
$toolsActive = ['starter' => 7, 'pro' => 12, 'premium' => 15][$user['plan']] ?? 7;
$siteCount = !empty($user['toutify_sub']) ? count(toutify_member_websites($user['toutify_sub'])) : 0;
$business = $profile['business_name'] !== '' ? $profile['business_name'] : 'Your business marketing workspace';
?>
<section class="tb" aria-label="Your Toutify membership">
  <div class="tb-main">
    <span class="tb-kicker"><i></i> Toutify member</span>
    <h1>Welcome back, <?= e($firstName) ?></h1>
    <p><?= e($business) ?> · ContentVendor is included with your Toutify membership.</p>
    <ul class="tb-chips">
      <li><span>Plan</span><b><?= e($planLabel) ?> · <?= e(money($cur['price'])) ?>/mo</b></li>
      <li><span>Websites</span><b><?= (int) $siteCount ?></b></li>
      <li><span>Tools active</span><b><?= (int) $toolsActive ?> of 15</b></li>
    </ul>
  </div>
  <div class="tb-actions">
    <a class="tb-btn" href="<?= e(url('account')) ?>"><?= $user['plan'] === 'premium' ? 'My plan' : 'Upgrade my plan' ?> <span aria-hidden="true">→</span></a>
    <a class="tb-btn ghost" href="<?= e(toutify_issuer() . '/members/') ?>" target="_blank" rel="noopener">Toutify dashboard ↗</a>
  </div>
</section>
