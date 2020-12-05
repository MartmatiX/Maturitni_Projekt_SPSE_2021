<?php require_once 'header.php'; ?>

<?php if (!isset($_SESSION['username'])): ?>
<main>
  <h1>Nejste přihlášeni!</h1>
</main>
<?php endif; ?>
<?php if (isset($_SESSION['username'])): ?>
  <main>
    <?php
      $mainObjectives = $db->run("SELECT * FROM main_objectives WHERE users_id = ?", [$_SESSION['id']])->fetchAll(PDO::FETCH_CLASS, "MainObjective");
      foreach($mainObjectives as $mainObjective){
        echo $mainObjective->name . " ";
      }
    ?>
  </main>
<?php endif; ?>

<?php require_once 'footer.php'; ?>
