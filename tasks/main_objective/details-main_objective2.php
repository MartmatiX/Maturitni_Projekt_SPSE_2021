<?php require_once '../../header.php'; ?>
<main>
  <?php $users_id = $db->run("SELECT users_id FROM main_objectives WHERE id = ?", [$_GET['id']])->fetch();?>
  <?php if (empty($users_id) || $_SESSION['id'] != $users_id['users_id']): ?>
    <?php require_once '../../error_components/wrong_users.php'; ?>
  <?php else: ?>
    <div class="div_backLink">
      <a href="../../objective_organizer.php"><button>Zpět</button></a>
    </div>

    <?php
      $main_objective_id = $_GET['id'];
      $main_objective = $db->run("SELECT * FROM main_objectives WHERE id = ?", [$main_objective_id])->fetch(PDO::FETCH_OBJ);
      $medium_objective = $db->run("SELECT * FROM medium_objectives WHERE main_objectives_id = ?", [$_GET['id']])->fetchAll(PDO::FETCH_CLASS, "MediumObjective");
    ?>

    <div class="organizer_wrapper">
      <div class="main_wrapper">
        <div class="organizer_header">
          <h1><?php echo $main_objective->name; ?></h1>
        </div>
        <div class="organizer_add">
          <a href="../medium_objective/add-medium_objective.php?id=<?php echo"$main_objective_id"; ?>"><button>Přidat</button></a>
        </div>
      </div>
    </div>



    <div class="organizer_wrapper">

      <div class="flex_wrap">
      <?php foreach ($medium_objective as $medium_objective_data): ?>
        <?php
            $counter = $db->run("SELECT count(id) AS 'celkem' FROM additional_objectives WHERE medium_objectives_id = ?", [$medium_objective_data->id])->fetch(PDO::FETCH_OBJ);
            $counter_finished = $db->run("SELECT count(id) AS 'splneno' FROM additional_objectives WHERE medium_objectives_id = ? AND finished = 1", [$medium_objective_data->id])->fetch(PDO::FETCH_OBJ);
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
            $czechArray = explode("-", $medium_objective_data->finish_date);
            $czechDate = $czechArray[2] . "." . $czechArray[1] . "." . $czechArray[0];
          ?>
          <div class="details_card_wrapper">
            <div class="details_card_medium">
              <div class="details_card_header">
                <h4><?php echo $medium_objective_data->name; ?></h4>
                <a href="../medium_objective/edit-medium_objective.php?id=<?php echo $medium_objective_data->id;?>"><img src="../../css/pictures/icon_edit.png" alt="edit_icon" height="40px" width="40px"></a>
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
                  <div class="card_delete">
                    <input class="form_delete" type="submit" name="delete" value="">
                  </div>
                  <div class="">
                    <a href="../additional_objective/add-additional_objective.php?id=<?php echo $medium_objective_data->id; ?>"><img src="../../css/pictures/icon_add.png" alt="icon_add" height="40px" width="40px"></a>
                  </div>
                </div>
              </form>
            </div>
          <?php
            $additional_objective = $db->run("SELECT * FROM additional_objectives WHERE medium_objectives_id = ?", [$medium_objective_data->id])->fetchAll(PDO::FETCH_CLASS, "AdditionalObjective");
          ?>
        <?php foreach ($additional_objective as $additional_objective_data): ?>
          <div class="">
            <h4><?php echo $additional_objective_data->name; ?></h4>
          </div>
        <?php endforeach; ?>
        </div>
     <?php endforeach; ?>
      </div>
    </div>


  <?php endif;?>
</main>
<?php require_once '../../footer.php'; ?>
