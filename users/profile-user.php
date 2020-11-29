<?php require_once '../header.php'; ?>

<main>
  <form class="" method="post">
    <input type="submit" name="logOut" value="Odhlásit se">
  </form>
</main>

<?php

  if (isset($_POST['logOut'])) {
    session_unset();
    header("Location: ../index.php");
  }

 ?>

<?php require_once '../footer.php'; ?>
