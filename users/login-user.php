<?php  require_once '../header.php';?>


  <main>
      <?php if (!isset($_SESSION['username'])): ?>
        <form class="" method="post">
          <input type="text" name="username" placeholder="Uživatelské jméno">
          <input type="text" name="username" placeholder="Heslo">
          <input type="submit" name="login" value="Přihlásit se">
        </form>
      <?php endif ?>

      <?php if (isset($_SESSION['username'])) {
        require_once '../error_components/logged-in.php';
      } ?>
  </main>

<?php

  

 ?>


<?php require_once '../footer.php'; ?>
