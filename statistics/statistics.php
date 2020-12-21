<?php require_once '../header.php'; ?>
  <main>
    <?php if (!isset($_SESSION['permission']) || $_SESSION['permission'] != 0): ?>
      <?php require_once '../error_components/wrong_users.php'; ?>
    <?php else: ?>
      <?php
        $counter_mainObjectives = $db->run("SELECT count(id) AS 'pocet_main' FROM main_objectives", [])->fetch(PDO::FETCH_OBJ);
        $counter_mediumObjectives = $db->run("SELECT count(id) AS 'pocet_medium' FROM medium_objectives", [])->fetch(PDO::FETCH_OBJ);
        $counter_additionalObjectives = $db->run("SELECT count(id) AS 'pocet_additional' FROM additional_objectives", [])->fetch(PDO::FETCH_OBJ);
        $counter_finishedMain = $db->run("SELECT count(id) AS 'finished_main' FROM main_objectives WHERE finished = 1", [])->fetch(PDO::FETCH_OBJ);

        $counter_users = $db->run("SELECT count(id) AS 'pocet_users' FROM users", [])->fetch(PDO::FETCH_OBJ);
      ?>
      <h1>Počet úkolů: <?php echo $counter_mainObjectives->pocet_main ?></h1>
      <h2>Počet vedlejších úkolů: <?php echo $counter_mediumObjectives->pocet_medium; ?></h2>
      <h3>Počet doplňujících úkolů: <?php echo $counter_additionalObjectives->pocet_additional; ?></h3>
      <h3>Celkem splněno: <?php echo intval(($counter_finishedMain->finished_main / $counter_mainObjectives->pocet_main) * 100);?>% úkolů</h3>
      <br>
      <h1>Počet uživatelů: <?php echo $counter_users->pocet_users; ?></h1>
    <?php endif; ?>
  </main>
