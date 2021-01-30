<?php require_once '../../../config/bootstrap.php'; ?>
<?php
  $medium_objective = $db->run("SELECT teams_main_objectives.teams_id, teams_main_objectives.id FROM teams_medium_objectives JOIN teams_main_objectives ON teams_main_objectives.id = teams_medium_objectives.teams_main_objectives_id WHERE teams_medium_objectives.id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  $main_objective_id = $db->run("SELECT teams_main_objectives_id FROM teams_medium_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $date = $_POST['finish_date'];
    $comment = $_POST['comment'];
    if ($db->run("INSERT INTO teams_additional_objectives(name, finish_date, comment, teams_medium_objectives_id) VALUES(?,?,?,?)", [$name, $date, $comment, $_GET['id']])) {
      header("Location: ../main_objective/details-main_objective.php?id=$medium_objective->id");
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
      <a href="../main_objective/details-main_objective.php?id=<?php echo $main_objective_id->teams_main_objectives_id; ?>"><button>Zpět</button></a>
    </div>
    <div class="form_wrapper">
      <div class="add_form">
        <div class="form_header">
          <h1>Přidání dodatkového úkolu</h1>
        </div>
        <div class="div_form">
          <form class="" method="post">
            <div class="form_spacing">
              <h3>Jméno dodatkového úkolu</h3>
              <input type="text" name="name" placeholder="Jméno">
            </div>
            <div class="form_spacing">
              <h3>Datum dodatkového úkolu</h3>
              <input type="date" name="finish_date" placeholder="datum">
            </div>
            <div class="form_spacing">
              <h3>Popisek</h3>
              <textarea name="comment" rows="8" cols="80"></textarea>
            </div>
            <div class="form_spacing">
              <input class="form_send" type="submit" name="submit" value="Přidat">
            </div>
          </form>
        </div>
      </div>
      <div class="div_add_picture">
        <img class="image_responsive" src="../../../css/pictures/add_picture.svg" alt="add_picture" width="500px">
      </div>
    </div>
  <?php endif; ?>
</main>
<?php require_once '../../../footer.php'; ?>
