<?php require_once '../../config/bootstrap.php'; ?>
<?php
  $main_objective = $db->run("SELECT users_id, main_objectives.id FROM additional_objectives JOIN medium_objectives ON additional_objectives.medium_objectives_id = medium_objectives.id JOIN main_objectives ON medium_objectives.main_objectives_id = main_objectives.id WHERE additional_objectives.id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  $data = $db->run("SELECT * FROM additional_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  $medium_objective_finish_date = $db->run("SELECT finish_date FROM medium_objectives WHERE id = ?", [$data->medium_objectives_id])->fetch(PDO::FETCH_OBJ);
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $finish_date = $_POST['finish_date'];
    $comment = $_POST['comment'];
    if ($db->run("UPDATE additional_objectives SET name = ?, finish_date = ?, comment = ? WHERE id = ?", [$name, $finish_date, $comment, $data->id])) {
      header("Location: ../main_objective/details-main_objective.php?id=$main_objective->id");
      exit();
    }else {
      header("Location edit-additional_objective.php?id=$data->id");
      exit();
    }
  }
 ?>
<?php require_once '../../header.php'; ?>
<main>
  <?php if (empty($main_objective) || $_SESSION['id'] != $main_objective->users_id): ?>
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
        <img class="image_responsive" src="../../css/pictures/edit_picture.svg" alt="picture_edit" width="500px">
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
<?php require_once '../../footer.php'; ?>
