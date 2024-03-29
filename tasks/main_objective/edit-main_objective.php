<?php require_once '../../config/bootstrap.php'; ?>
<?php
  if (isset($_POST['submit'])) {
    $name = htmlspecialchars($name = $_POST['name']);
    $date = htmlspecialchars($date = $_POST['finish_date']);
    $urgent = 0;
    if (isset($_POST['urgent'])) {
      $urgent = 1;
    }
    if ($db->run("UPDATE main_objectives SET name = ?, finish_date = ?, urgent = ? WHERE id = ?", [$name, $date, $urgent, $_GET['id']])) {
      header("Location: ../../objective_organizer.php");
      exit();
    }else {
      echo "error";
    }
  }
?>
<?php require_once '../../header.php'; ?>
<?php $main_objective = $db->run("SELECT * FROM main_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ); ?>
<?php if (empty($main_objective) || $_SESSION['id'] != $main_objective->users_id): ?>
  <?php require_once '../../error_components/wrong_users.php'; ?>
<?php else: ?>

  <div class="div_backLink">
    <a href="../../objective_organizer.php"><button>Zpět</button></a>
  </div>
  <div class="form_wrapper">
    <div class="add_form">
      <div class="form_header">
        <h1>Editace úkolu</h1>
      </div>
      <div class="div_form">
        <form class="" method="post">
          <div class="form_spacing">
            <h3>Jméno úkolu</h3>
            <input type="text" name="name" value="<?php echo $main_objective->name; ?>">
          </div>
          <div class="form_spacing">
            <h3>Datum dokončení úkolu</h3>
            <input type="date" id="finish_date" name="finish_date" value="<?php echo $main_objective->finish_date; ?>">
          </div>
          <div class="form_spacing_urgent">
            <input type="text" id="urgent_value" value="<?php echo $main_objective->urgent; ?>" style="display: none;">
            <input type="checkbox" id="urgent" name="urgent">
            <h3>Urgentní</h3>
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
    let urgent_value = document.getElementById('urgent_value').value;
    let check = document.getElementById('urgent');
    if (urgent_value == 1) {
      document.getElementById('urgent').checked = true;
    }

    let today = new Date();
    let dd = today.getDate();
    let mm = today.getMonth()+1; //January is 0!
    let yyyy = today.getFullYear();
    if(dd < 10){
      dd = '0' + dd;
    }
    if(mm < 10){
      mm = '0' + mm;
    }
    today = yyyy+'-'+mm+'-'+dd;
    document.getElementById("finish_date").setAttribute("min", today);
  </script>
  <?php require_once "../../footer.php"; ?>
<?php endif; ?>
