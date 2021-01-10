<?php require_once '../../header.php'; ?>
<main>
  <?php if (!isset($_SESSION['id'])): ?>
    <?php require_once '../../error_components/not_logged-in.php'; ?>
  <?php else: ?>
    <?php $finished = $db->run("SELECT * FROM main_objectives WHERE users_id = ? AND finished = 1", [$_SESSION['id']])->fetchAll(PDO::FETCH_CLASS, 'MainObjective');?>
    <?php if (empty($finished)): ?>
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
          </div>
        <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>
</main>
