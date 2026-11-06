<section class="section-sm">
  <div class="container">
    <div class="dash-head">
      <div>
        <p class="kicker">Super admin</p>
        <h1><?= e(['overview' => 'Overview', 'members' => 'Members', 'requests' => 'Done-for-you requests'][$tab]) ?></h1>
      </div>
    </div>
    <?php if ($tab === 'overview'): ?>
    <div class="stats">
      <div class="stat"><b><?= count($users) ?></b><span>Total members</span></div>
      <?php foreach (PLANS as $k => $p): ?><div class="stat"><b><?= (int) $planCounts[$k] ?></b><span><?= e($p['name']) ?> members</span></div><?php endforeach; ?>
      <div class="stat"><b><?= e(money($planCounts['pro'] * PLANS['pro']['price'] + $planCounts['premium'] * PLANS['premium']['price'])) ?></b><span>Membership MRR (est.)</span></div>
      <div class="stat"><b><?= (int) $newCount ?></b><span>New done-for-you requests</span></div>
    </div>
    <?php endif; ?>

    <?php if ($tab !== 'members'): ?>
<?php if ($tab === 'overview'): ?><div class="sec-head"><h2>Latest done-for-you requests</h2><a href="<?= e(url('superadmin?view=requests')) ?>">View all →</a></div><?php endif; ?>
    <div class="table-wrap">
      <table class="data">
        <thead><tr><th>Date</th><th>Package</th><th>Contact</th><th>Business</th><th>Message</th><th>Status</th></tr></thead>
        <tbody>
        <?php if (!$requests): ?><tr><td colspan="6" class="muted">No requests yet.</td></tr><?php endif; ?>
        <?php foreach ($tab === 'overview' ? array_slice($requests, 0, 5) : $requests as $r): ?>
          <tr>
            <td><?= e(date('M j', strtotime($r['created_at']))) ?></td>
            <td><?= e(PACKAGES[$r['package']]['name'] ?? $r['package']) ?></td>
            <td><?= e($r['name']) ?><br><a href="mailto:<?= e($r['email']) ?>"><?= e($r['email']) ?></a><br><?= e($r['phone']) ?></td>
            <td><?= e($r['business']) ?></td>
            <td class="small"><?= nl2br(e($r['message'])) ?></td>
            <td>
              <form method="post" class="inline-form">
                <?= csrf_field() ?><input type="hidden" name="action" value="request"><input type="hidden" name="request_id" value="<?= (int) $r['id'] ?>">
                <select name="status" onchange="this.form.submit()"><?php foreach (['new', 'contacted', 'active', 'closed'] as $s): ?><option <?= $r['status'] === $s ? 'selected' : '' ?>><?= $s ?></option><?php endforeach; ?></select>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?php endif; ?>

    <?php if ($tab !== 'requests'): ?>
    <?php if ($tab === 'overview'): ?><div class="sec-head"><h2>Newest members</h2><a href="<?= e(url('superadmin?view=members')) ?>">View all →</a></div><?php endif; ?>
    <div class="table-wrap">
      <table class="data">
        <thead><tr><th>Member</th><th>Business</th><th>Joined</th><th>Content</th><th>Used this month</th><th>Plan</th></tr></thead>
        <tbody>
        <?php foreach ($tab === 'overview' ? array_slice($users, 0, 8) : $users as $u): ?>
          <tr>
            <td><?= e($u['name']) ?><?= $u['role'] === 'admin' ? ' <span class="chip">admin</span>' : '' ?><br><span class="small muted"><?= e($u['email']) ?></span></td>
            <td><?= e($u['business_name']) ?></td>
            <td><?= e(date('M j, Y', strtotime($u['created_at']))) ?></td>
            <td><?= (int) $u['items'] ?></td>
            <td><?= (int) $u['used'] ?>/<?= (int) (PLANS[$u['plan']]['generations'] ?? 0) ?></td>
            <td>
              <form method="post" class="inline-form">
                <?= csrf_field() ?><input type="hidden" name="action" value="plan"><input type="hidden" name="user_id" value="<?= (int) $u['id'] ?>">
                <select name="plan" onchange="this.form.submit()"><?php foreach (PLANS as $k => $p): ?><option value="<?= e($k) ?>" <?= $u['plan'] === $k ? 'selected' : '' ?>><?= e($p['name']) ?></option><?php endforeach; ?></select>
              </form>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>
</section>
