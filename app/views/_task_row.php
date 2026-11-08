<?php /** One daily task. Expects $t (plan_tasks row) and $back ('members'|'planner'). */
$pl = PLAN_PLATFORMS[$t['platform']] ?? [ucfirst($t['platform']), 'facebook', 10]; ?>
<div class="tk tk-<?= e($t['status']) ?>">
  <form method="post" action="<?= e(url('planner')) ?>" class="tk-check">
    <?= csrf_field() ?><input type="hidden" name="action" value="task"><input type="hidden" name="task_id" value="<?= (int) $t['id'] ?>"><input type="hidden" name="back" value="<?= e($back) ?>">
    <input type="hidden" name="status" value="<?= $t['status'] === 'done' ? 'todo' : 'done' ?>">
    <button type="submit" aria-label="<?= $t['status'] === 'done' ? 'Mark as not done' : 'Mark as done' ?>"><?= $t['status'] === 'done' ? '✓' : '' ?></button>
  </form>
  <div class="tk-body">
    <div class="tk-meta"><span class="tk-pl tk-pl-<?= e($t['platform']) ?>"><?= e($pl[0]) ?></span><span><?= e(GOALS[$t['goal']] ?? '') ?></span><span>~<?= (int) $pl[2] ?> min</span><?php if (isset(POSTING_GUIDE[$t['platform']])): ?><a class="tk-guide" href="<?= e(guide_url($t['platform'])) ?>">📘 How to post on <?= e(POSTING_GUIDE[$t['platform']]['title']) ?></a><?php endif; ?></div>
    <p><?= e($t['idea']) ?></p>
  </div>
  <div class="tk-actions">
    <?php if ($t['status'] === 'todo'): ?>
      <a class="tk-go" href="<?= e(url('create?task=' . $t['id'])) ?>">Do it now →</a>
      <form method="post" action="<?= e(url('planner')) ?>">
        <?= csrf_field() ?><input type="hidden" name="action" value="task"><input type="hidden" name="task_id" value="<?= (int) $t['id'] ?>"><input type="hidden" name="back" value="<?= e($back) ?>"><input type="hidden" name="status" value="skipped">
        <button class="tk-skip" type="submit">Skip</button>
      </form>
    <?php elseif ($t['status'] === 'done'): ?>
      <?php if ($t['item_id']): ?><a class="tk-view" href="<?= e(url('item?id=' . $t['item_id'])) ?>">View post</a><?php else: ?><span class="tk-done">Done</span><?php endif; ?>
    <?php else: ?>
      <span class="tk-done muted">Skipped</span>
    <?php endif; ?>
  </div>
</div>
