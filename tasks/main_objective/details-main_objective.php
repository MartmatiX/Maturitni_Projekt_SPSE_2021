<?php require_once "../../header.php"; ?>
<main>
  <?php $users_id = $db->run("SELECT users_id FROM main_objectives WHERE id = ?", [$_GET['id']])->fetch();?>
  <?php if (empty($users_id) || $_SESSION['id'] != $users_id['users_id']): ?>
    <?php require_once '../../error_components/wrong_users.php'; ?>
  <?php else: ?>
    <div class="div_backLink">
      <a href="../../objective_organizer.php"><button>Zpět</button></a>
    </div>
    <a href="../medium_objective/add-medium_objective.php?id=<?php echo"$main_objective_id"; ?>">Přidat</a>
    <?php
      $main_objective_id = $_GET['id'];
      $main_objective = $db->run("SELECT * FROM main_objectives WHERE id = ?", [$_GET['id']])->fetchAll(PDO::FETCH_CLASS, "MainObjective");
      $medium_objective = $db->run("SELECT * FROM medium_objectives WHERE main_objectives_id = ?", [$_GET['id']])->fetchAll(PDO::FETCH_CLASS, "MediumObjective");
      $additional_objective = $db->run("SELECT additional_objectives.name, additional_objectives.finished, additional_objectives.id AS 'medium_id', medium_objectives.id FROM additional_objectives JOIN medium_objectives ON additional_objectives.medium_objectives_id = medium_objectives.id WHERE medium_objectives.main_objectives_id = ?", [$_GET['id']])->fetchAll(PDO::FETCH_CLASS, "AdditionalObjective");
      foreach ($main_objective as $main_objective_data) {
        echo $main_objective_data->name;
      }
      ?>
      <br><br>
    <br><br>
    <?php
      if (!empty($medium_objective)) {
        foreach($medium_objective as $medium_objective_data){
          echo $medium_objective_data->name." ".$medium_objective_data->finish_date." ".$medium_objective_data->id." ".$medium_objective_data->finished;
          echo "<div>
          <form method='post'>
            <input type='submit' name='delete_medium' value='Smazat'>
            <input type='submit' name='finish_medium' value='Splnit'>
            <input value='$medium_objective_data->id' style='display:none' name='medium_id'>
          </form>";
          echo "<a href='../medium_objective/edit-medium_objective.php?id=$medium_objective_data->id'>Upravit</a>";
          echo "<a href='../additional_objective/add-additional_objective.php?id=$medium_objective_data->id'>Přidat</a>";
          $counter_all = $db->run("SELECT count(id) AS 'celkem' FROM additional_objectives WHERE medium_objectives_id = ?", [$medium_objective_data->id])->fetch(PDO::FETCH_OBJ);
          if ($counter_all->celkem == 0) {
            echo "Zatím nebyly přidány doplňující úkoly";
          }else {
            $counter_finished = $db->run("SELECT count(id) AS 'splneno' FROM additional_objectives WHERE finished = 1 AND medium_objectives_id = ?", [$medium_objective_data->id])->fetch(PDO::FETCH_OBJ);
            $percentage = intval(($counter_finished->splneno / $counter_all->celkem) * 100)."%";
            echo $percentage;
          }
          echo "</div>";
          echo "<br>";
        }
        if (isset($_POST['finish_medium'])) {
          if ($db->run("UPDATE medium_objectives SET finished = 1 WHERE id = ?", [$_POST['medium_id']])) {
            $db->run("UPDATE additional_objectives SET finished = 1 WHERE medium_objectives_id = ?", [$_POST['medium_id']]);
            header("Location: details-main_objective.php?id=".$_GET['id']);
          }
        }
        if (isset($_POST['delete_medium'])) {
          if ($db->run("DELETE FROM medium_objectives WHERE id = ?", [$_POST['medium_id']])) {
            header("Location: details-main_objective.php?id=".$_GET['id']);
          }
        }
        foreach($additional_objective as $additional_objective_data){
          echo "<br><br>";
          echo $additional_objective_data->name." ".$additional_objective_data->medium_objectives_id." ".$additional_objective_data->id." ".$additional_objective_data->finished;
          echo "<form method='post'>
            <input type='submit' value='Smazat' name='delete'>
            <input type='submit' value='Splnit' name='finish'>
            <input value='$additional_objective_data->medium_id' style='display:none' name='id'>
          </form>";
          echo "<a href='../additional_objective/edit-additional_objective.php?id=$additional_objective_data->medium_id'>Upravit</a>";
        }
      }
      if (isset($_POST['finish'])) {
        if ($db->run("UPDATE additional_objectives SET finished = 1 WHERE id = ?", [$_POST['id']])) {
          header("Location: details-main_objective.php?id=".$_GET['id']);
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
    <?php require_once '../../footer.php'; ?>
  <?php endif; ?>
</main>
