<?php require_once '../../header.php'; ?>
<main>
  <?php
    $medium_objective = $db->run("SELECT main_objectives.users_id, main_objectives.id FROM medium_objectives JOIN main_objectives ON main_objectives.id = medium_objectives.main_objectives_id WHERE medium_objectives.id = ? AND main_objectives.finished = 0", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  ?>
  <?php if (empty($medium_objective) || $_SESSION['id'] != $medium_objective->users_id): // dodelat ?>
    <?php require_once '../../error_components/wrong_users.php'; ?>
  <?php else: ?>
    <?php $data = $db->run("SELECT * FROM medium_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ); ?>
    <form class="" method="post">
      <input type="text" name="name" value="<?php echo $data->name ?>">
      <input type="date" name="finish_date" value="<?php echo $data->finish_date ?>">
      <input type="submit" name="submit" value="Upravit">
    </form>
    <?php
      if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $finish_date = $_POST['finish_date'];
        if ($db->run("UPDATE medium_objectives SET name = ?, finish_date = ? WHERE id = ?", [$name, $finish_date, $_GET['id']])) {
          header("Location: ../main_objective/details-main_objective.php?id=$medium_objective->id");
        }
      }
     ?>
  <?php endif; ?>
</main>
