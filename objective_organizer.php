<?php require_once 'header.php'; ?>

<?php if (!isset($_SESSION['username'])): ?>
<main>
  <h1>Nejste přihlášeni!</h1>
</main>
<?php endif; ?>
<?php if (isset($_SESSION['username'])): ?>
  <main>
    <br><br>
    <?php
      $mainObjectives = $db->run("SELECT * FROM main_objectives WHERE users_id = ? AND finished = 0 ORDER BY urgent desc, finish_date asc", [$_SESSION['id']])->fetchAll(PDO::FETCH_CLASS, "MainObjective");
      foreach($mainObjectives as $mainObjective){
        echo "<div class='objective'>$mainObjective->name";
        echo "<a href='tasks/main_objective/details-main_objective.php?id=$mainObjective->id'>Podrobnosti</a>";
        echo "<a href='tasks/main_objective/edit-main_objective.php?id=$mainObjective->id'>Upravit</a>";
        echo "<input class='urgent' value='$mainObjective->urgent' style='display:none;'>";
        echo "<form method='post'><input type='submit' name='finish' value='Splnit'><input type='submit' name='delete' value='Odstranit'><input name='main_id' value='$mainObjective->id' style='display:none'></form>";
        echo "</div>";
      }

      if (isset($_POST['finish'])) {
        if ($db->run("UPDATE main_objectives SET finished = 1 WHERE id = ?", [$_POST['main_id']])) {
          $db->run("DELETE FROM medium_objectives WHERE main_objectives_id = ?", [$_POST['main_id']]);
          header("Location: tasks/main_objective/finished-main_objective.php");
        }else {
          echo "error";
        }
      }

      if (isset($_POST['delete'])) {
        if ($db->run("DELETE FROM main_objectives WHERE id = ?", [$_POST['main_id']])) {
          header("Location: objective_organizer.php");
        }else {
          echo "Location: objective_organizer.php?error";
        }
      }
    ?>
    <br><br>
    <a href="tasks/main_objective/add-main_objective.php">Přidat</a>
  </main>

  <script type="text/javascript">
  let array = document.getElementsByClassName('urgent');
  for (let i = 0; i < array.length; i++) {
    if (array[i].value == 1) {
      document.getElementsByClassName('objective')[i].style.border = "1px solid orange";
    }
  }
  </script>
<?php endif; ?>
<?php require_once 'footer.php'; ?>
