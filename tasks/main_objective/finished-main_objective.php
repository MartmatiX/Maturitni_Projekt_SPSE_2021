<?php require_once '../../header.php'; ?>
<main>
  <?php if (!isset($_SESSION['id'])): ?>
    <?php require_once '../../error_components/not_logged-in.php'; ?>
  <?php else: ?>
    <?php $finished = $db->run("SELECT * FROM main_objectives WHERE users_id = ? AND finished = 1", [$_SESSION['id']])->fetchAll(PDO::FETCH_CLASS, 'MainObjective');
      foreach($finished as $finish){
        echo $finish->name;
      }
    ?>
  <?php endif; ?>
</main>
