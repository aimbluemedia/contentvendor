<?php if (!empty($errors)): ?>
  <div class="flash flash-error" role="alert">
    <?php foreach ($errors as $err): ?><div><?= e($err) ?></div><?php endforeach; ?>
  </div>
<?php endif; ?>
