<?php require_once 'config/bootstrap.php'; ?>
<?php
if (isset($_POST['finish'])) {
  if ($db->run("UPDATE main_objectives SET finished = 1 WHERE id = ?", [$_POST['main_id']])) {
    $db->run("DELETE FROM medium_objectives WHERE main_objectives_id = ?", [$_POST['main_id']]);
    header("Location: tasks/main_objective/finished-main_objective.php");
    exit();
  }else {
    echo "error";
  }
}
if (isset($_POST['delete'])) {
  if ($db->run("DELETE FROM main_objectives WHERE id = ?", [$_POST['main_id']])) {
    header("Location: objective_organizer.php");
    exit();
  }else {
    header("Location: objective_organizer.php?error");
    exit();
  }
}
?>
<?php require_once 'header.php'; ?>

<?php if (!isset($_SESSION['username'])): ?>
  <?php require_once 'error_components/not_logged-in.php'; ?>
<?php else: ?>
  <main>

    <?php
      $mainObjectives = $db->run("SELECT * FROM main_objectives WHERE users_id = ? AND finished = 0 OR finished = 3 ORDER BY urgent desc, finish_date asc", [$_SESSION['id']])->fetchAll(PDO::FETCH_CLASS, "MainObjective");
    ?>

    <div class="organizer_wrapper">
      <div class="main_wrapper">
        <div class="organizer_header">
          <?php if (empty($mainObjectives)): ?>
            <h1>Žádné běžící úkoly</h1>
          <?php else: ?>
            <h1>Trvající úkoly</h1>
          <?php endif; ?>
          <div class="organizer_header_links">
            <a href="tasks/main_objective/finished-main_objective.php" class="link_spacing_right">Splněné úkoly</a>
            <p>|</p>
            <a href="tasks/main_objective/not_finished-main_objective.php" class="link_spacing_left">Nesplněné úkoly</a>
          </div>
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
            <progress class="percentage" value="<?php echo $percentage?>" max="100"></progress>
          </div>
          <div class="card_counter_date">
            <div class="card_counter">
              <h5><?php echo $text;?></h5>
            </div>
            <div class="card_date">
              <h5><?php echo $czechDate; ?></h5>
              <input type="text" name="" style="display:none" class="finish_date_class" value="<?php echo $mainObjective->finish_date; ?>">
            </div>
          </div>
          <input type="text" name="" style="display:none" class="finished_class" value="<?php echo $mainObjective->finished; ?>">
            <form method="post">
              <div class="card_form">
                <div class="card_finish">
                  <input class="form_finished" type="submit" name="finish" value="">
                  <input name='main_id' type="text" value="<?php echo $mainObjective->id ?>" style='display:none'>
                  <input class="urgent" value="<?php echo $mainObjective->urgent ?>" style='display:none'>
                </div>
                <div class="card_details">
                  <a href="tasks/main_objective/details-main_objective.php?id=<?php echo $mainObjective->id ?>"><img src="css/pictures/icon_details.png" alt="icon_details" height="40px" width="40px"></a>
                </div>
                <div class="card_edit">
                  <a href="tasks/main_objective/edit-main_objective.php?id=<?php echo $mainObjective->id ?>"><img src="css/pictures/icon_edit.png" alt="icon_edit" height="40px" width="40px"></a>
                </div>
                <div class="card_delete">
                  <input class="form_delete" type="submit" name="delete" value="">
                </div>
              </div>
            </form>
        </div>
        <?php
          $currentDate = date("Y-m-d");
          $finish_date = $mainObjective->finish_date;
          if ($currentDate > $finish_date) {
            $db->run("UPDATE main_objectives SET finished = 2 WHERE id = ?", [$mainObjective->id]);
          }
         ?>
      <?php endforeach; ?>
    </div>
  </div>
  </main>

  <script type="text/javascript">
  let array = document.getElementsByClassName('urgent');
  for (let i = 0; i < array.length; i++) {
    if (array[i].value == 1) {
      document.getElementsByClassName('card_wrapper')[i].style.border = "3px solid orange";
    }
  }

  let array_finished = document.getElementsByClassName('finished_class');
  for (var i = 0; i < array_finished.length; i++) {
    if (array_finished[i].value == 3) {
      document.getElementsByClassName('card_wrapper')[i].style.border = "3px solid purple";
      console.log(1);
    }
  }

  let array_percentage = document.getElementsByClassName('percentage');
  console.log(array_percentage[0].value);
  let array_danger = document.getElementsByClassName('finish_date_class');
  let date = new Date();
  let today = date.getTime();
  let daysLater = today + 259200000;
  let danger_date = 0;
  for (var i = 0; i < array_danger.length; i++) {
    danger_date = Date.parse(array_danger[i].value);
    if (danger_date < daysLater && array_percentage[i].value < 50) {
      document.getElementsByClassName('card_wrapper')[i].style.boxShadow = "5px 10px darkred";
    }
  }
  </script>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
