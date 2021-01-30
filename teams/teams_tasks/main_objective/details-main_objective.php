<?php require_once '../../../config/bootstrap.php'; ?>
<?php
  $main_objective_id = $_GET['id'];
  if (isset($_POST['finish_medium'])) {
    if ($db->run("UPDATE teams_medium_objectives SET finished = 1 WHERE id = ?", [$_POST['medium_id']])) {
      $db->run("UPDATE teams_additional_objectives SET finished = 1 WHERE teams_medium_objectives_id = ?", [$_POST['medium_id']]);
      header("Location: details-main_objective.php?id=".$main_objective_id);
      exit();
    }else {

    }
  }

  if (isset($_POST['delete_medium'])) {
    if ($db->run("DELETE FROM teams_medium_objectives WHERE id = ?", [$_POST['medium_id']])) {
      header("Location: details-main_objective.php?id=".$main_objective_id);
      exit();
    }
  }

  if (isset($_POST['finish_additional'])) {
    if ($db->run("UPDATE teams_additional_objectives SET finished = 1 WHERE id = ?", [$_POST['additional_id']])) {
      header("Location: details-main_objective.php?id=".$main_objective_id);
      exit();
    }
  }

  if (isset($_POST['delete_additional'])) {
    if ($db->run("DELETE FROM teams_additional_objectives WHERE id = ?", [$_POST['additional_id']])) {
      header("Location: details-main_objective.php?id=".$main_objective_id);
      exit();
    }
  }
 ?>
<?php require_once '../../../header.php'; ?>
<main>

  <?php
    $main_objective = $db->run("SELECT * FROM teams_main_objectives WHERE id = ?", [$main_objective_id])->fetch(PDO::FETCH_OBJ);
    $medium_objective = $db->run("SELECT * FROM teams_medium_objectives WHERE teams_main_objectives_id = ?", [$_GET['id']])->fetchAll(PDO::FETCH_OBJ);
  ?>

  <?php $users_id = $db->run("SELECT users_id FROM main_objectives WHERE id = ?", [$_GET['id']])->fetch();?>
  <?php if (false): ?>
    <h1>error</h1>
  <?php else: ?>
    <div class="div_backLink">
      <a href="../../teams-main_objective_details.php?id=<?php echo $main_objective->teams_id; ?>"><button>Zpět</button></a>
    </div>

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
            $counter = $db->run("SELECT count(id) AS 'celkem' FROM teams_additional_objectives WHERE teams_medium_objectives_id = ?", [$medium_objective_data->id])->fetch(PDO::FETCH_OBJ);
            $counter_finished = $db->run("SELECT count(id) AS 'splneno' FROM teams_additional_objectives WHERE teams_medium_objectives_id = ? AND finished = 1", [$medium_objective_data->id])->fetch(PDO::FETCH_OBJ);
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
                <a href="../medium_objective/edit-medium_objective.php?id=<?php echo $medium_objective_data->id;?>"><img src="../../../css/pictures/icon_edit.png" alt="edit_icon" height="40px" width="40px"></a>
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
                <div class="details_card_form">
                  <div class="card_finish_delete">
                    <input class="form_finished" type="submit" name="finish_medium" value="">
                    <input class="form_delete" type="submit" name="delete_medium" value="">
                    <input name='medium_id' type="text" value="<?php echo $medium_objective_data->id ?>" style='display:none'>
                  </div>
                  <div class="">
                    <a href="../additional_objective/add-additional_objective.php?id=<?php echo $medium_objective_data->id; ?>"><img src="../../../css/pictures/icon_add.png" alt="icon_add" height="50px" width="50px"></a>
                  </div>
                </div>
              </form>
            </div>
          <?php
            $additional_objective = $db->run("SELECT * FROM teams_additional_objectives WHERE teams_medium_objectives_id = ?", [$medium_objective_data->id])->fetchAll(PDO::FETCH_OBJ);
          ?>
        <?php foreach ($additional_objective as $additional_objective_data): ?>
            <div class="details_card_additional">
              <div class="additional_wrapper">
                <div class="details_card_header">
                  <h5><?php echo $additional_objective_data->name; ?></h5>
                  <?php if ($additional_objective_data->finished == 0): ?>
                    <a href="../additional_objective/edit-additional_objective.php?id=<?php echo $additional_objective_data->id ?>"><img src="../../../css/pictures/icon_edit.png" alt="icon_add" height="40px" width="40px"></a>
                  <?php endif; ?>
                </div>
                <div class="additional_finish_date">
                  <h5><?php echo $additional_objective_data->finish_date; ?></h5>
                </div>
                <div class="additional_comment_wrapper">
                  <div class="additional_comment_div">
                    <p><?php echo $additional_objective_data->comment ?></p>
                  </div>
                  <div class="additional_form">
                    <form method="post" id="card_form">
                      <div class="card_form">
                        <?php if ($additional_objective_data->finished == 0): ?>
                          <div class="additional_card_buttons">
                            <input class="form_finished" type="submit" name="finish_additional" value="">
                            <input class="form_delete" type="submit" name="delete_additional" value="">
                            <input name='additional_id' type="text" value="<?php echo $additional_objective_data->id ?>" style='display:none'>
                          </div>
                        <?php else: ?>
                          <div class="additional_card_buttons">
                            <input class="form_delete" type="submit" name="delete_additional" value="">
                            <input name='additional_id' type="text" value="<?php echo $additional_objective_data->id ?>" style='display:none'>
                          </div>
                        <?php endif; ?>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        <?php endforeach; ?>
        </div>
     <?php endforeach; ?>
      </div>
    </div>
  <?php endif;?>
</main>
<?php require_once '../../../footer.php'; ?>
