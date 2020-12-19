<?php require_once '../../header.php'; ?>
<main>
  <?php $medium_objective = $db->run("SELECT * FROM medium_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ); ?>
  <?php if (empty($medium_objective)): // dodelat ?>
    <?php require_once '../../error_components/wrong_users.php'; ?>
  <?php else: ?>

  <?php endif; ?>
</main>
