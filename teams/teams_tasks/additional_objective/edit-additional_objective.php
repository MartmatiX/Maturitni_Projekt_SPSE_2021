<?php require_once '../../../config/bootstrap.php'; ?>
<?php
  $main_objective = $db->run("SELECT teams_id, teams_main_objectives.id FROM teams_additional_objectives JOIN teams_medium_objectives ON teams_additional_objectives.teams_medium_objectives_id = teams_medium_objectives.id JOIN teams_main_objectives ON teams_medium_objectives.teams_main_objectives_id = teams_main_objectives.id WHERE teams_additional_objectives.id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  $data = $db->run("SELECT * FROM teams_additional_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  $medium_objective_finish_date = $db->run("SELECT finish_date FROM teams_medium_objectives WHERE id = ?", [$data->teams_medium_objectives_id])->fetch(PDO::FETCH_OBJ);
  if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $finish_date = htmlspecialchars($_POST['finish_date']);
    $comment = htmlspecialchars($_POST['comment']);
    if ($db->run("UPDATE teams_additional_objectives SET name = ?, finish_date = ?, comment = ? WHERE id = ?", [$name, $finish_date, $comment, $data->id])) {
      header("Location: ../main_objective/details-main_objective.php?id=$main_objective->id");
      exit();
    }else {
      header("Location edit-additional_objective.php?id=$data->id");
      exit();
    }
  }
 ?>
<?php require_once '../../../header.php'; ?>
<main>
  <?php if (false): ?>
    <?php require_once '../../error_components/wrong_users.php'; ?>
  <?php else: ?>
    <div class="div_backLink">
      <a href="../main_objective/details-main_objective.php?id=<?php echo $main_objective->id; ?>"><button>Zpět</button></a>
    </div>
    <div class="form_wrapper">
      <div class="add_form">
        <div class="form_header">
          <h1>Editace dodatkového úkolu</h1>
        </div>
        <div class="div_form">
          <form class="" method="post">
            <div class="form_spacing">
              <h3>Jméno dodatkového úkolu</h3>
              <input type="text" name="name" value="<?php echo $data->name ?>">
            </div>
            <div class="form_spacing">
              <h3>Datum dodatkového úkolu</h3>
              <input type="date" name="finish_date" id="finish_date" value="<?php echo $data->finish_date ?>">
              <input type="text" id="medium_finish_date" value="<?php echo $medium_objective_finish_date->finish_date; ?>" style="display:none;">
            </div>
            <div class="form_spacing">
              <h3>Popisek</h3>
              <textarea name="comment" rows="8" cols="80"><?php echo $data->comment ?></textarea>
            </div>
            <div class="form_spacing">
              <input class="form_send" type="submit" name="submit" value="Změnit">
            </div>
          </form>
        </div>
      </div>
      <div class="div_edit_picture">
        <img class="image_responsive" src="../../../css/pictures/edit_picture.svg" alt="picture_edit" width="500px">
      </div>
    </div>
    <script type="text/javascript">
      let today = new Date();
      let dd = today.getDate();
      let mm = today.getMonth()+1;
      let yyyy = today.getFullYear();
      if(dd < 10){
        dd = '0' + dd;
      }
      if(mm < 10){
        mm = '0' + mm;
      }
      today = yyyy+'-'+mm+'-'+dd;
      document.getElementById("finish_date").setAttribute("min", today);

      let medium_finish = document.getElementById('medium_finish_date').value;
      document.getElementById("finish_date").setAttribute("max", medium_finish);
    </script>
  <?php endif; ?>
</main>
<?php require_once '../../../footer.php'; ?>
