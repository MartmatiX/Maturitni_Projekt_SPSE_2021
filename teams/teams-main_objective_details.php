<?php require_once '../config/bootstrap.php'; ?>

<?php

$users_teams = $db->run("SELECT * FROM users_teams WHERE id_users = ?", [$_SESSION['id']])->fetchAll(PDO::FETCH_OBJ);
$inTeam = array();
foreach($users_teams as $arrayData){
  array_push($inTeam, $arrayData->id_users);
}

$team = $db->run("SELECT * FROM teams WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
if (isset($_POST['finish'])) {
  if ($db->run("UPDATE teams_main_objectives SET finished = 1 WHERE id = ?", [$_POST['main_id']])) {
    $db->run("DELETE FROM teams_medium_objectives WHERE teams_main_objectives_id = ?", [$_POST['main_id']]);
    header("Location: teams-main_objective_details.php?id=".$_GET['id']);
  }else {
    echo "error";
  }
}
if (isset($_POST['delete'])) {
  if ($db->run("DELETE FROM teams_main_objectives WHERE id = ?", [$_POST['main_id']])) {
    header("Location: teams-main_objective_details.php?id=".$_GET['id']);
  }else {
    header("Location: teams-main_objective_details.php?id=".$_GET['id']);
  }
}
?>
<?php require_once '../header.php'; ?>
<main>
   <?php if (!in_array($_SESSION['id'], $inTeam) && $_SESSION['id'] != $team->id_creator): ?>
     <h1>K zobrazení tohoto obsahu nemáte dostatečná oprávnění</h1>
     <div class="div_backLink">
       <a href="teams.php"><button>Zpět</button></a>
     </div>
   <?php else: ?>
     <div class="div_backLink">
       <a href="teams.php"><button>Zpět</button></a>
     </div>

     <div class="organizer_wrapper">
     <h1><?php echo $team->name; ?></h1>
     <?php if ($_SESSION['id'] == $team->id_creator): ?>
       <div class="organizer_header_links">
         <a href="teams-members.php?id=<?php echo $team->id; ?>" style="padding-bottom:30px;">Členi</a>
       </div>
     <?php endif; ?>

     <?php
        $objectives = $db->run("SELECT * FROM teams_main_objectives WHERE teams_id = ? AND finished = 0 ORDER BY urgent desc, finish_date asc", [$_GET['id']])->fetchAll(PDO::FETCH_OBJ);
      ?>

        <div class="main_wrapper">
          <div class="organizer_header">
            <?php if (empty($objectives)): ?>
              <h1>Žádné běžící úkoly</h1>
            <?php else: ?>
              <h1>Trvající úkoly</h1>
            <?php endif; ?>
            <div class="organizer_header_links">
              <a href="teams_tasks/main_objective/finished-main_objective.php?id=<?php echo $_GET['id']; ?>" class="link_spacing_right">Splněné úkoly</a>
              <p>|</p>
              <a href="#" class="link_spacing_left">Nesplněné úkoly</a>
            </div>
          </div>
          <?php if ($_SESSION['id'] == $team->id_creator): ?>
            <div class="organizer_add">
              <a href="teams_tasks/main_objective/add-main_objective.php?id=<?php echo $_GET['id']; ?>"><button>Přidat</button></a>
            </div>
          <?php else: ?>
            <div class="organizer_add">
              <h3>Přidat úkol může pouze zakladatel</h3>
            </div>
          <?php endif; ?>
        </div>

        <div class="flex_wrap">
          <?php if (!empty($objectives)): ?>
        <?php foreach ($objectives as $mainObjective): ?>
          <?php
              $counter = $db->run("SELECT count(id) AS 'celkem' FROM teams_medium_objectives WHERE teams_main_objectives_id = ?", [$mainObjective->id])->fetch(PDO::FETCH_OBJ);
              $counter_finished = $db->run("SELECT count(id) AS 'splneno' FROM teams_medium_objectives WHERE teams_main_objectives_id = ? AND finished = 1", [$mainObjective->id])->fetch(PDO::FETCH_OBJ);
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
                    <input class="form_finished" type="submit" name="finish" value="">
                    <input name='main_id' type="text" value="<?php echo $mainObjective->id ?>" style='display:none'>
                    <input class="urgent" value="<?php echo $mainObjective->urgent ?>" style='display:none'>
                  </div>
                  <div class="card_details">
                    <a href="teams_tasks/main_objective/details-main_objective.php?id=<?php echo $mainObjective->id ?>"><img src="../css/pictures/icon_details.png" alt="icon_details" height="40px" width="40px"></a>
                  </div>
                  <div class="card_edit">
                    <a href="teams_tasks/main_objective/edit-main_objective.php?id=<?php echo $mainObjective->id ?>"><img src="../css/pictures/icon_edit.png" alt="icon_edit" height="40px" width="40px"></a>
                  </div>
                  <?php if ($_SESSION['id'] == $team->id_creator): ?>
                    <div class="card_delete">
                      <input class="form_delete" type="submit" name="delete" value="">
                    </div>
                  <?php endif; ?>
                </div>
              </form>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <?php endif; ?>

    <script type="text/javascript">
      let array = document.getElementsByClassName('urgent');
      for (let i = 0; i < array.length; i++) {
        if (array[i].value == 1) {
          document.getElementsByClassName('card_wrapper')[i].style.border = " 3px solid orange";
        }
      }
    </script>

   <?php endif; ?>
</main>
<?php require_once '../footer.php'; ?>
