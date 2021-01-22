<?php require_once '../../header.php'; ?>
<main>
  <?php
    $medium_objective = $db->run("SELECT main_objectives.users_id, main_objectives.id FROM medium_objectives JOIN main_objectives ON main_objectives.id = medium_objectives.main_objectives_id WHERE medium_objectives.id = ? AND main_objectives.finished = 0", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
    $main_objective_id = $db->run("SELECT main_objectives_id FROM medium_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  ?>
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
              <input type="date" name="finish_date" value="<?php echo $data->finish_date ?>">
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
    <?php
      if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $finish_date = $_POST['finish_date'];
        if ($db->run("UPDATE medium_objectives SET name = ?, finish_date = ? WHERE id = ?", [$name, $finish_date, $_GET['id']])) {
          header("Location: ../main_objective/details-main_objective.php?id=$medium_objective->id");
        }
      }
     ?>
  <?php endif; ?>
</main>
<?php require_once '../../footer.php'; ?>
