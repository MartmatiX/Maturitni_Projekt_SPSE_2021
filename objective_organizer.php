<?php require_once 'header.php'; ?>

<?php if (!isset($_SESSION['username'])): ?>
  <?php require_once 'error_components/not_logged-in.php'; ?>
<?php else: ?>
  <main>

    <?php
      $mainObjectives = $db->run("SELECT * FROM main_objectives WHERE users_id = ? AND finished = 0 ORDER BY urgent desc, finish_date asc", [$_SESSION['id']])->fetchAll(PDO::FETCH_CLASS, "MainObjective");
    ?>

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

    <div class="organizer_wrapper">
      <div class="main_wrapper">
        <div class="organizer_header">
          <?php if (empty($mainObjectives)): ?>
            <h1>Zatím nemáte žádné úkoly</h1>
          <?php else: ?>
            <h1>Trvající úkoly</h1>
          <?php endif; ?>
          <a href="tasks/main_objective/finished-main_objective.php">Splněné úkoly</a>
          <a href="#">Nesplněné úkoly</a>
        </div>
        <div class="organizer_add">
          <a href="tasks/main_objective/add-main_objective.php"><button>Přidat</button></a>
        </div>
      </div>

      <div class="flex_wrap">
      <?php foreach ($mainObjectives as $mainObjective): ?>
        <?php
            $counter = $db->run("SELECT count(id) AS 'celkem' FROM medium_objectives WHERE main_objectives_id = ?", [$mainObjective->id])->fetch(PDO::FETCH_OBJ);
            $counter_finished = $db->run("SELECT count(id) AS 'splneno' FROM medium_objectives WHERE main_objectives_id = ? AND finished = 1", [$mainObjective->id])->fetch(PDO::FETCH_OBJ);
            if ($counter->celkem == 0) {
              $text = "Žádné podúkoly";
              $percentage = 0;
            }elseif ($counter->celkem == 1) {
              $percentage = intval(($counter_finished->splneno/$counter->celkem) * 100);
              $text = $counter->celkem." podúkol";
            }elseif($counter->celkem > 1 && $counter->celkem < 5){
              $percentage = intval(($counter_finished->splneno/$counter->celkem) * 100);
              $text = $counter->celkem." podúkoly";
            }else {
              $percentage = intval(($counter_finished->splneno/$counter->celkem) * 100);
              $text = $counter->celkem . " podúkolů";
            }
            $czechArray = explode("-", $mainObjective->finish_date);
            $czechDate = $czechArray[2] . "." . $czechArray[1] . "." . $czechArray[0];
          ?>
        <div class="card_wrapper">
          <div class="card_header">
            <h4><?php echo $mainObjective->name ?></h4>
          </div>
          <div class="card_progressBar">
            <progress value="<?php echo $percentage?>" max="100"></progress>
          </div>
          <div class="card_counter_date">
            <div class="card_counter">
              <h5><?php echo $text;?></h5>
            </div>
            <div class="card_date">
              <h5><?php echo $czechDate; ?></h5>
            </div>
          </div>
            <form method="post" id="card_form">
              <div class="card_form">
                <div class="card_finish">
                  <button type="submit" form="card_form" name="finish"><img src="css/pictures/icon_finish.png" alt="icon_finish" height="60px" width="60px"></button>
                  <input name='main_id' value="<?php echo $mainObjective->id ?>" style='display:none'>
                </div>
                <div class="card_details">
                  <a href="tasks/main_objective/details-main_objective.php?id=<?php echo $mainObjective->id ?>"><img src="css/pictures/icon_details.png" alt="icon_details" height="40px" width="40px"></a>
                </div>
                <div class="card_edit">
                  <a href="tasks/main_objective/edit-main_objective.php?id=<?php echo $mainObjective->id ?>"><img src="css/pictures/icon_edit.png" alt="icon_edit" height="40px" width="40px"></a>
                </div>
                <div class="card_delete">
                  <button type="submit" form="card_form" name="delete"><img src="css/pictures/icon_delete.png" alt="icon_finish" height="60px" width="60px"></button>
                </div>
              </div>
            </form>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
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
