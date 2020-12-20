<?php require_once '../../header.php'; ?>
<main>
  <?php
  $medium_objective = $db->run("SELECT main_objectives.users_id, main_objectives.id FROM medium_objectives JOIN main_objectives ON main_objectives.id = medium_objectives.main_objectives_id WHERE medium_objectives.id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  ?>
  <?php if (empty($medium_objective) || $_SESSION['id'] != $medium_objective->users_id): ?>
    <?php require_once '../../error_components/wrong_users.php'; ?>
  <?php else: ?>
    <form class="" method="post">
      <input type="text" name="name" placeholder="Jméno">
      <input type="date" name="finish_date" placeholder="datum">
      <input type="text" name="comment" placeholder="Popisek">
      <input type="submit" name="submit" value="Přidat">
    </form>
    <?php
      if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $date = $_POST['finish_date'];
        $comment = $_POST['comment'];
        if ($db->run("INSERT INTO additional_objectives(name, finish_date, comment, medium_objectives_id) VALUES(?,?,?,?)", [$name, $date, $comment, $_GET['id']])) {
          header("Location: ../main_objective/details-main_objective.php?id=$medium_objective->id");
        }
      }
     ?>
  <?php endif; ?>
</main>
