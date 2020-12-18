<?php require_once '../../header.php'; ?>
<main>
  <?php if (isset($_SESSION['username'])): ?>
    <form class="" method="post">
      <input type="text" name="name" placeholder="Jméno úkolu">
      <input type="date" name="finish_date" placeholder="Datum">
      <input type="checkbox" name="urgent" id="urgent">
      <label for="urgent">Urgentní</label>
      <input type="submit" name="submit" value="Přidat">
    </form>
    <?php
      if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $finish_date = $_POST['finish_date'];
        if (isset($_POST['urgent'])) {
          $urgent = 1;
        }else {
          $urgent = 0;
        }
        if ($db->run("INSERT INTO main_objectives(name, finish_date, urgent, users_id) VALUES(?,?,?,?)", [$name, $finish_date, $urgent, $_SESSION['id']])) {
          header("Location: ../../objective_organizer.php");
        }
        else {
          header("Location: add-main_objective.php");
        }
      }
     ?>
  <?php else:?>
    <?php require_once "../../error_components/not_logged-in.php"; ?>
  <?php endif; ?>
</main>
