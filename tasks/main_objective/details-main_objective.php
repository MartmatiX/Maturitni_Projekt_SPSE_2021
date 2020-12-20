<?php require_once "../../header.php"; ?>
<main>
  <?php $users_id = $db->run("SELECT users_id FROM main_objectives WHERE id = ?", [$_GET['id']])->fetch();
  ?>
  <?php if (empty($users_id) || $_SESSION['id'] != $users_id['users_id']): ?>
    <?php require_once '../../error_components/wrong_users.php'; ?>
  <?php else: ?>
    <?php
      $main_objective_id = $_GET['id'];
      $main_objective = $db->run("SELECT * FROM main_objectives WHERE id = ?", [$_GET['id']])->fetchAll(PDO::FETCH_CLASS, "MainObjective");
      $medium_objective = $db->run("SELECT * FROM medium_objectives WHERE main_objectives_id = ?", [$_GET['id']])->fetchAll(PDO::FETCH_CLASS, "MediumObjective");
      $additional_objective = $db->run("SELECT additional_objectives.name, additional_objectives.id AS 'medium_id', medium_objectives.id FROM additional_objectives JOIN medium_objectives ON additional_objectives.medium_objectives_id = medium_objectives.id WHERE medium_objectives.main_objectives_id = ?", [$_GET['id']])->fetchAll(PDO::FETCH_CLASS, "AdditionalObjective");
      foreach ($main_objective as $main_objective_data) {
        echo $main_objective_data->name;
      }
      ?>
      <br><br>
    <a href="../medium_objective/add-medium_objective.php?id=<?php echo"$main_objective_id"; ?>">Přidat</a>
    <br><br>
    <?php
      if (!empty($medium_objective)) {
        foreach($medium_objective as $medium_objective_data){
          echo $medium_objective_data->name." ".$medium_objective_data->finish_date." ".$medium_objective_data->id;
          echo "<a href='../medium_objective/edit-medium_objective.php?id=$medium_objective_data->id'>Upravit</a>";
          echo "<a href='../additional_objective/add-additional_objective.php?id=$medium_objective_data->id'>Přidat</a>";
        }
        foreach($additional_objective as $additional_objective_data){
          echo "<br><br>";
          echo $additional_objective_data->name." ".$additional_objective_data->medium_objectives_id." ".$additional_objective_data->id;
          echo "<form method='post'>
            <input type='submit' value='Smazat' name='delete'>
            <input value='$additional_objective_data->medium_id' style='display:none' name='id'>
          </form>";
          echo "<a href='../additional_objective/edit-additional_objective.php'>Upravit</a>";
        }
      }
      if (isset($_POST['delete'])) {
        if ($db->run("DELETE FROM additional_objectives WHERE id = ?", [$_POST['id']])) {
          header("Location: details-main_objective.php?id=".$_GET['id']);
        }else{
          header("Location: details-main_objective.php?id=".$_GET['id']);
        }
      }
    ?>
  <?php endif; ?>
</main>
