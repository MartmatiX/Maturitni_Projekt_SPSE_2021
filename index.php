<?php require_once "header.php"; ?>

  <main>
    <?php
      $data = $db->run("SELECT * FROM users")->fetchAll();
      var_dump($data);
     ?>
  </main>

<?php require_once "footer.php"; ?>
