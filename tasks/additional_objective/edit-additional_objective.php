<?php require_once '../../header.php'; ?>
<main>
  <?php
    $main_objective = $db->run("SELECT users_id, main_objectives.id FROM additional_objectives JOIN medium_objectives ON additional_objectives.medium_objectives_id = medium_objectives.id JOIN main_objectives ON medium_objectives.main_objectives_id = main_objectives.id WHERE additional_objectives.id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  ?>
  <?php if (empty($main_objective) || $_SESSION['id'] != $main_objective->users_id): ?>
    <?php require_once '../../error_components/wrong_users.php'; ?>
  <?php else: ?>
    <?php $data = $db->run("SELECT * FROM additional_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ); ?>
    <form class="" method="post">
      <input type="text" name="name" value="<?php echo $data->name ?>">
      <input type="date" name="finish_date" value="<?php echo $data->finish_date ?>">
      <input type="text" name="comment" value="<?php echo $data->comment ?>">
      <input type="submit" name="submit" value="Změnit">
    </form>
    <?php
      if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $finish_date = $_POST['finish_date'];
        $comment = $_POST['comment'];
        if ($db->run("UPDATE additional_objectives SET name = ?, finish_date = ?, comment = ? WHERE id = ?", [$name, $finish_date, $comment, $data->id])) {
          header("Location: ../main_objective/details-main_objective.php?id=$main_objective->id");
        }else {
          header("Location edit-additional_objective.php?id=$data->id");
        }
      }
     ?>
  <?php endif; ?>
</main>
