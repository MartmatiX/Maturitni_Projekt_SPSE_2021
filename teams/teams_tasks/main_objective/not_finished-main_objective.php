<?php require_once '../../../config/bootstrap.php'; ?>
<?php
  if (isset($_POST['delete'])) {
    if ($db->run("DELETE FROM teams_main_objectives WHERE id = ?", [htmlspecialchars($_POST['not_finished_id'])])) {
      header("Location: not_finished-main_objective.php?id=".$_GET['id']);
      exit();
    }
  }
  if (isset($_POST['set_new_date'])) {
    if ($db->run("UPDATE teams_main_objectives SET finish_date = ? WHERE id = ?", [$_POST['new_date'], $_POST['not_finished_id']])) {
      $db->run("UPDATE teams_main_objectives SET finished = 3 WHERE id = ?", [$_POST['not_finished_id']]);
      header("Location: ../../../objective_organizer.php?success");
      exit();
    }
  }
 ?>
<?php require_once '../../../header.php'; ?>
<main>
  <?php if (!isset($_SESSION['id'])): ?>
    <h1>Nejste přihlášeni!</h1>
  <?php else: ?>
    <?php $not_finished = $db->run("SELECT * FROM teams_main_objectives WHERE teams_id = ? AND finished = 2", [$_GET['id']])->fetchAll(PDO::FETCH_CLASS, 'MainObjective');?>
    <?php if (empty($not_finished)): ?>
      <div class="div_backLink">
        <a href="../../teams-main_objective_details.php?id=<?php echo $_GET['id']; ?>"><button>Zpět</button></a>
      </div>
      <h1>Žádné nesplněné úkoly v historii</h1>
    <?php else: ?>
        <div class="div_backLink">
          <a href="../../teams-main_objective_details.php?id=<?php echo $_GET['id']; ?>"><button>Zpět</button></a>
        </div>
      <div class="finished_wrapper">
        <div class="flex_wrap">
        <?php foreach ($not_finished as $not_finished_objective): ?>
          <div class="card_wrapper">
            <div class="card_header">
              <h4><?php echo $not_finished_objective->name ?></h4>
            </div>
            <div class="new_date">
              <form class="" method="post">
                <input style="width: 100%; margin-top: 20px;" type="text" class="finish_date" name="new_date" onfocus="(this.type='date')" onfocusout="(this.type='text')" placeholder="Datum">
                <input style="margin-top: 30px; margin-left: 35%;" type="submit" class="form_send" name="set_new_date" value="Nový datum">
                <input type="text" name="not_finished_id" value="<?php echo $not_finished_objective->id ?>" style="display:none;">
              </form>
            </div>
            <div class="finished_form">
              <form class="" method="post">
                <input class="form_delete" type="submit" name="delete" value="">
                <input type="text" name="not_finished_id" value="<?php echo $not_finished_objective->id ?>" style="display:none;">
              </form>
            </div>
          </div>
        <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>
  <script type="text/javascript">
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

  let objectives_array = document.getElementsByClassName("finish_date");
  console.log(objectives_array);
  for (var i = 0; i < objectives_array.length; i++) {
    objectives_array[i].setAttribute("min", today);
  }
  </script>
</main>
<?php require_once '../../../footer.php'; ?>
