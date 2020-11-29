<?php require_once '../header.php'; ?>

  <main>
    <?php if (!isset($_SESSION['username'])): ?>
      <form class="" method="post">
        <input type="text" name="name" placeholder="Jméno">
        <input type="text" name="surname" placeholder="Příjmení">
        <input type="text" name="username" placeholder="Uživatelké jméno">
        <input type="password" name="password" placeholder="Heslo">
        <input type="password" name="password_repeat" placeholder="Heslo znovu">
        <input type="text" name="email" placeholder="E-mail">
        <input type="submit" name="register" value="Registrovat se">
      </form>
    <?php endif; ?>

    <?php if (isset($_SESSION['username'])) {
      require_once '../error_components/logged-in.php';
    } ?>
  </main>

<?php

if (isset($_POST['register'])) {
  $username = $_POST['username'];
  $existence = $db->run("SELECT username FROM users WHERE username = ?", [$username])->fetch();
  if (empty($existence)) {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    if ($db->run("INSERT INTO users(name, surname, username, password, email) VALUES (?,?,?,?,?)", [$name, $surname, $username, $password, $email])) {
      header("Location: login-user.php");
    }else {
      header("Location: register-user.php?dberror");
    }
  }else {
    header("Location: register-user.php?existence=true");
  }

}

 ?>

<?php require_once '../footer.php'; ?>
