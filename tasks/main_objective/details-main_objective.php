<?php require_once "../../header.php"; ?>
<main>
  <?php $users_id = $db->run("SELECT users_id FROM main_objectives WHERE id = ?", [$_GET['id']])->fetch();
  ?>
  <?php if ($_SESSION['id'] != $users_id['users_id']): ?>
    <?php require_once '../../error_components/wrong_users.php'; ?>
  <?php else: ?>
    <?php
      $main_objective_id = $_GET['id'];
      $main_objective = $db->run("SELECT * FROM main_objectives WHERE id = ?", [$_GET['id']])->fetchAll(PDO::FETCH_CLASS, "MainObjective");
      $medium_objective = $db->run("SELECT * FROM medium_objectives WHERE main_objectives_id = ?", [$_GET['id']]);
      foreach ($main_objective as $main_objective_data) {
        echo $main_objective_data->name;
      }
      ?>
      <br><br>
    <a href="../medium_objective/add-medium_objective.php?id=<?php echo"$main_objective_id"; ?>">Přidat</a>
    <?php
      foreach($medium_objective as $medium_objective_data){
        echo $medium_objective_data->name;
      }
    ?>
  <?php endif; ?>
</main>
