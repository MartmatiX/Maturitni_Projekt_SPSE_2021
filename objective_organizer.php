<?php require_once 'header.php'; ?>

<?php if (!isset($_SESSION['username'])): ?>
  <?php require_once 'error_components/not_logged-in.php'; ?>
<?php else: ?>
  <main>

    <div class="organizer_wrapper">
      <div class="main_wrapper">
        <div class="organizer_header">
          <h1>Trvající úkoly</h1>
          <a href="#">Splněné úkoly</a>
          <a href="#">Nesplněné úkoly</a>
        </div>
        <div class="organizer_add">
          <button><a href="tasks/main_objective/add-main_objective.php">Přidat</a></button>
        </div>
      </div>


    <br><br>
    <?php
      $mainObjectives = $db->run("SELECT * FROM main_objectives WHERE users_id = ? AND finished = 0 ORDER BY urgent desc, finish_date asc", [$_SESSION['id']])->fetchAll(PDO::FETCH_CLASS, "MainObjective");

      foreach($mainObjectives as $mainObjective){
        echo $mainObjective->name;
        echo "<a href='tasks/main_objective/details-main_objective.php?id=$mainObjective->id'>Podrobnosti</a>";
        echo "<a href='tasks/main_objective/edit-main_objective.php?id=$mainObjective->id'>Upravit</a>";
        echo "<input class='urgent' value='$mainObjective->urgent' style='display:none;'>";
        echo "<form method='post'>
          <input type='submit' name='finish' value='Splněno'>
          <input type='submit' name='delete' value='Odstranit'>
          <input name='main_id' value='$mainObjective->id' style='display:none'>
          </form>";

        $counter = $db->run("SELECT count(id) AS 'celkem' FROM medium_objectives WHERE main_objectives_id = ?", [$mainObjective->id])->fetch(PDO::FETCH_OBJ);
        if ($counter->celkem == 0) {
          echo "Zatím nebyly přidány další podúkoly";
        }else {
          $counter_finished = $db->run("SELECT count(id) AS 'splneno' FROM medium_objectives WHERE main_objectives_id = ? AND finished = 1", [$mainObjective->id])->fetch(PDO::FETCH_OBJ);
          $percentage = intval(($counter_finished->splneno / $counter->celkem) * 100)."%";
          echo "Spněno: ".$percentage;
        }
      }
      ?>

      <?php foreach ($mainObjectives as $mainObjective): ?>
        <div class="card_wrapper">
          <h4><?php echo $mainObjective->name ?></h4>
        </div>
      <?php endforeach; ?>

</div>

      <?php
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
