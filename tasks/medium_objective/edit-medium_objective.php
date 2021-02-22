<?php require_once '../../config/bootstrap.php'; ?>
<?php
$medium_objective = $db->run("SELECT main_objectives.users_id, main_objectives.id FROM medium_objectives JOIN main_objectives ON main_objectives.id = medium_objectives.main_objectives_id WHERE medium_objectives.id = ? AND main_objectives.finished = 0", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
$main_objective_id = $db->run("SELECT main_objectives_id FROM medium_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
$main_objective_finish_date = $db->run("SELECT finish_date FROM main_objectives WHERE id = ?", [$main_objective_id->main_objectives_id])->fetch(PDO::FETCH_OBJ);
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $finish_date = $_POST['finish_date'];
    if ($db->run("UPDATE medium_objectives SET name = ?, finish_date = ? WHERE id = ?", [$name, $finish_date, $_GET['id']])) {
      header("Location: ../main_objective/details-main_objective.php?id=$medium_objective->id");
      exit();
    }
  }
 ?>
<?php require_once '../../header.php'; ?>
<main>
  <?php if (empty($medium_objective) || $_SESSION['id'] != $medium_objective->users_id): ?>
    <?php require_once '../../error_components/wrong_users.php'; ?>
  <?php else: ?>
    <?php $data = $db->run("SELECT * FROM medium_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ); ?>
    <div class="div_backLink">
      <a href="../main_objective/details-main_objective.php?id=<?php echo $main_objective_id->main_objectives_id; ?>"><button>Zpět</button></a>
    </div>
    <div class="form_wrapper">
      <div class="add_form">
        <div class="form_header">
          <h1>Editace podúkolu</h1>
        </div>
        <div class="div_form">
          <form class="" method="post">
            <div class="form_spacing">
              <h3>Jméno podúkolu</h3>
              <input type="text" name="name" value="<?php echo $data->name ?>">
            </div>
            <div class="form_spacing">
              <h3>Datum splnění podúkolu</h3>
              <input type="date" id="finish_date" name="finish_date" value="<?php echo $data->finish_date ?>">
              <input type="text" id="main_finish_date" value="<?php echo $main_objective_finish_date->finish_date; ?>" style="display: none;">
            </div>
            <div class="form_spacing">
              <input class="form_send" type="submit" name="submit" value="Upravit">
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

      let main_finish = document.getElementById('main_finish_date').value;
      document.getElementById("finish_date").setAttribute("max", main_finish);
    </script>
  <?php endif; ?>
</main>
<?php require_once '../../footer.php'; ?>
