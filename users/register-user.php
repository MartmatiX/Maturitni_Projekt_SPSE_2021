<?php require_once '../config/bootstrap.php'; ?>

<?php
  if (isset($_POST['register'])) {
    $username = htmlspecialchars($username = $_POST['username']);
    $existence = $db->run("SELECT username FROM users WHERE username = ?", [$username])->fetch();
    if (empty($existence)) {
      $name = htmlspecialchars($name = $_POST['name']);
      $surname = htmlspecialchars($surname = $_POST['surname']);
      $password = htmlspecialchars($password = password_hash($_POST['password'], PASSWORD_DEFAULT));
      $email = htmlspecialchars($email = $_POST['email']);
      if ($db->run("INSERT INTO users(name, surname, username, password, email) VALUES (?,?,?,?,?)", [$name, $surname, $username, $password, $email])) {
        header("Location: login-user.php");
        exit();
      }else {
        header("Location: register-user.php?dberror");
        exit();
      }
    }else {
      header("Location: register-user.php?existence=true");
      exit();
    }

  }
?>

<?php require_once '../header.php'; ?>

  <main>
    <?php if (!isset($_SESSION['username'])): ?>
      <div class="form_wrapper">
        <div class="register_register">
          <div class="form_header">
            <h1>Registrace</h1>
          </div>
          <div class="div_form">
            <form class="" method="post">
              <div class="div_input">
                <div class="">
                  <div class="form_spacing">
                    <h3>Jméno</h3>
                    <input type="text" name="name" placeholder="Jméno" pattern="^[A-ZĚŠČŘŽÝÁÍÉÚ]{1}[a-zěščřžýáíéú]{1,25}$" required>
                  </div>
                  <div class="form_spacing">
                    <h3>Příjmení</h3>
                    <input type="text" name="surname" placeholder="Příjmení" pattern="^[A-ZĚŠČŘŽÝÁÍÉÚ]{1}[a-zěščřžýáíéúů]{1,25}$" required>
                  </div>
                  <div class="form_spacing">
                    <h3>E-mailová adresa</h3>
                    <input type="text" name="email" placeholder="E-mail" pattern="^[a-zěščřžýáíéůúA-ZĚŠČŘŽÝÁÍÉÚ.-_1-9]{1,}[@][a-z]{1,}[.][a-z]{1,}$" required>
                  </div>
                </div>
                <div class="input_spacing">
                  <div class="form_spacing">
                    <h3>Uživatelské jméno</h3>
                    <input type="text" name="username" placeholder="Uživatelké jméno" required>
                  </div>
                  <div class="form_spacing">
                    <h3>Heslo</h3>
                    <input type="password" name="password" placeholder="Heslo" required>
                  </div>
                  <div class="form_spacing">
                    <h3>Ověření hesla</h3>
                    <input type="password" name="password_repeat" placeholder="Heslo znovu" required>
                  </div>
                </div>
              </div>
              <div class="register_submit">
                <input class="form_send" type="submit" name="register" value="Registrovat se">
              </div>
            </form>
          </div>
        </div>
        <div class="register_picture">
          <img class="image_responsive" src="../css/pictures/register_picture.svg" alt="register_picture" width="500px">
        </div>
      </div>

    <?php endif; ?>

    <?php if (isset($_SESSION['username'])) {
      require_once '../error_components/logged-in.php';
    } ?>
  </main>

<?php require_once '../footer.php'; ?>
