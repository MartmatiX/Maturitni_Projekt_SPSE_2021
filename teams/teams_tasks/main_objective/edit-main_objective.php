<?php require_once '../../../config/bootstrap.php'; ?>
<?php
  $main_objective_id = $db->run("SELECT * FROM teams_main_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  if (isset($_POST['submit'])) {
    $name = htmlspecialchars($name = $_POST['name']);
    $date = htmlspecialchars($date = $_POST['finish_date']);
    $urgent = 0;
    if (isset($_POST['urgent'])) {
      $urgent = 1;
    }
    if ($db->run("UPDATE teams_main_objectives SET name = ?, finish_date = ?, urgent = ? WHERE id = ?", [$name, $date, $urgent, $_GET['id']])) {
      header("Location: ../../teams-main_objective_details.php?id=".$main_objective_id->teams_id);
      exit();
    }else {
      echo "error";
    }
  }
?>
<?php require_once '../../../header.php'; ?>
<?php $main_objective = $db->run("SELECT * FROM teams_main_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ); ?>
<?php if (empty($main_objective)): ?>
  <?php require_once '../../../error_components/wrong_users.php'; ?>
<?php else: ?>

  <div class="div_backLink">
    <a href="../../teams-main_objective_details.php?id=<?php echo $main_objective_id->teams_id; ?>"><button>Zpět</button></a>
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
            <h3>Datum úkolu</h3>
            <input type="date" name="finish_date" value="<?php echo $main_objective->finish_date; ?>">
          </div>
          <div class="form_spacing_urgent">
            <input type="checkbox" name="urgent" value="<?php if($main_objective->urgent == 1){echo 1;} ?>" id="urgent">
            <h3>Urgentní</h3>
          </div>
          <div class="form_spacing">
            <input class="form_send" type="submit" name="submit" value="Upravit">
          </div>
        </form>
      </div>
    </div>
    <div class="div_edit_picture">
      <img class="image_responsive" src="../../../css/pictures/edit_picture.svg" alt="picture_edit" width="500px">
    </div>
  </div>

  <script type="text/javascript">
    // dodělat check u checkboxu, pokud je urgent
  </script>
  <?php require_once "../../../footer.php"; ?>
<?php endif; ?>
