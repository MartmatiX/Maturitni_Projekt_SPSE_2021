<?php require_once '../../header.php'; ?>
<main>
  <?php
    $main_objective = $db->run("SELECT * FROM main_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
   ?>
   <?php if (empty($main_objective) || $_SESSION['id'] != $main_objective->users_id): ?>
     <?php require_once '../../error_components/wrong_users.php'; ?>
   <?php else: ?>
     <form class="" method="post">
       <input type="text" name="name" placeholder="Jméno">
       <input type="date" name="finish_date" placeholder="Datum splnění">
       <input type="submit" name="submit" value="Přidat">
     </form>
     <?php
        if (isset($_POST['submit'])) {
          $name = $_POST['name'];
          $finish_date = $_POST['finish_date'];
          if ($db->run("INSERT INTO medium_objectives(name, finish_date, main_objectives_id) VALUES (?,?,?)", [$name, $finish_date, $_GET['id']])) {
            header("Location: ../main_objective/details-main_objective.php?id=".$_GET['id']);
          }
        }
      ?>
   <?php endif; ?>
</main>
