

<?php  require_once '../header.php';?>

  <main>
      <?php if (!isset($_SESSION['username'])): ?>
        <form class="" method="post">
          <input type="text" name="username" placeholder="Uživatelské jméno">
          <input type="password" name="password" placeholder="Heslo">
          <input type="submit" name="login" value="Přihlásit se">
        </form>
      <?php endif ?>

      <?php if (isset($_SESSION['username'])) {
        require_once '../error_components/logged-in.php';
      } ?>
  </main>

<?php

  if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $existence = $db->run("SELECT * FROM users WHERE username = ?", [$username])->fetch(PDO::FETCH_OBJ);
    var_dump($existence);
    echo $existence->password;
    if (!empty($existence)) {
      $password = $existence->password;
      if (password_verify($_POST['password'], $existence->password)) {
        $_SESSION['username'] = $existence->username;
        $_SESSION['id'] = $existence->id;
        $_SESSION['permission'] = $existence->permision;
        header("Location: ../objective_organizer.php");
      }else {
        header("Location: login-user.php?wrongPassword");
      }
    }else{
      header("Location: login-user.php?wrongUsername");
    }
  }

?>

<?php require_once '../footer.php'; ?>
