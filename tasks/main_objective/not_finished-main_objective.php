<?php require_once '../../config/bootstrap.php'; ?>
<?php
  if (isset($_POST['delete'])) {
    if ($db->run("DELETE FROM main_objectives WHERE id = ?", [$_POST['finished_id']])) {
      header("Location: finished-main_objective.php");
      exit();
    }
  }
 ?>
<?php require_once '../../header.php'; ?>
<main>
  <?php if (!isset($_SESSION['id'])): ?>
    <?php require_once '../../error_components/not_logged-in.php'; ?>
  <?php else: ?>
    <?php $finished = $db->run("SELECT * FROM main_objectives WHERE users_id = ? AND finished = 2", [$_SESSION['id']])->fetchAll(PDO::FETCH_CLASS, 'MainObjective');?>
    <?php if (empty($finished)): ?>
      <div class="div_backLink">
        <a href="../../objective_organizer.php"><button>Zpět</button></a>
      </div>
      <h1>Žádné splněné úkoly v historii</h1>
    <?php else: ?>
        <div class="div_backLink">
          <a href="../../objective_organizer.php"><button>Zpět</button></a>
        </div>
      <div class="finished_wrapper">
        <div class="flex_wrap">
        <?php foreach ($finished as $finished_objective): ?>
          <div class="card_wrapper">
            <div class="card_header">
              <h4><?php echo $finished_objective->name ?></h4>
            </div>
            <div class="finished_form">
              <form class="" method="post">
                <input class="form_delete" type="submit" name="delete" value="">
                <input type="text" name="finished_id" value="<?php echo $finished_objective->id ?>" style="display:none;">
              </form>
            </div>
          </div>
        <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</main>
<?php require_once '../../footer.php'; ?>
