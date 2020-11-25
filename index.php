<?php require_once "header.php"; ?>

  <main>
    <h1></h1>
    <?php
      $data = $db->run("SELECT * FROM users")->fetchAll();
      var_dump($data);
     ?>
  </main>

<?php require_once "footer.php"; ?>
