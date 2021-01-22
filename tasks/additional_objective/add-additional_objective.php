<?php require_once '../../header.php'; ?>
<main>
  <?php
  $medium_objective = $db->run("SELECT main_objectives.users_id, main_objectives.id FROM medium_objectives JOIN main_objectives ON main_objectives.id = medium_objectives.main_objectives_id WHERE medium_objectives.id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  $main_objective_id = $db->run("SELECT main_objectives_id FROM medium_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
  ?>
  <?php if (empty($medium_objective) || $_SESSION['id'] != $medium_objective->users_id): ?>
    <?php require_once '../../error_components/wrong_users.php'; ?>
  <?php else: ?>
    <div class="div_backLink">
      <a href="../main_objective/details-main_objective.php?id=<?php echo $main_objective_id->main_objectives_id; ?>"><button>Zpět</button></a>
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
        <img class="image_responsive" src="../../css/pictures/add_picture.svg" alt="add_picture" width="500px">
      </div>
    </div>
    <?php
      if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $date = $_POST['finish_date'];
        $comment = $_POST['comment'];
        if ($db->run("INSERT INTO additional_objectives(name, finish_date, comment, medium_objectives_id) VALUES(?,?,?,?)", [$name, $date, $comment, $_GET['id']])) {
          header("Location: ../main_objective/details-main_objective.php?id=$medium_objective->id");
        }
      }
     ?>
  <?php endif; ?>
</main>
<?php require_once '../../footer.php'; ?>
