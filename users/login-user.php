<?php require_once '../config/bootstrap.php'; ?>
<?php
  if (isset($_POST['login'])) {
    $username = htmlspecialchars($username = $_POST['username']);
    $existence = $db->run("SELECT * FROM users WHERE username = ?", [$username])->fetch(PDO::FETCH_OBJ);
    if (!empty($existence)) {
      $password = $existence->password;
      if (password_verify($_POST['password'], $existence->password)) {
        $_SESSION['name'] = $existence->name;
        $_SESSION['surname'] = $existence->surname;
        $_SESSION['username'] = $existence->username;
        $_SESSION['id'] = $existence->id;
        $_SESSION['password'] = $existence->password;
        $_SESSION['email'] = $existence->email;
        $_SESSION['permission'] = $existence->permision;
        header("Location: ../objective_organizer.php");
        exit();
      }else {
        header("Location: login-user.php?wrongPassword");
        exit();
      }
    }else{
      header("Location: login-user.php?wrongUsername");
      exit();
    }
  }
?>
<?php  require_once '../header.php';?>

  <main>
      <?php if (!isset($_SESSION['username'])): ?>
        <div class="form_wrapper">
          <div class="login_login">
            <div class="form_header">
              <h1>Přihlášení</h1>
            </div>
            <div class="div_form">
              <form class="" method="post">
                <div class="form_spacing">
                  <h3>Uživatelské jméno</h3>
                  <input type="text" name="username" placeholder="username">
                </div>
                <div class="form_spacing">
                  <h3>Heslo</h3>
                  <input type="password" name="password" placeholder="**********">
                </div>
                <div class="login_submit">
                  <input class="form_send" type="submit" name="login" value="Přihlásit se">
                  <p>Pokud nemáte účet, můžete se zaregistrovat <a href="/../webs/Maturitni_Projekt_New/users/register-user.php">ZDE</a></p>
                </div>
              </form>
            </div>
          </div>
          <div class="login_picture">
            <img class="image_responsive" src="../css/pictures/login_picture.svg" alt="login_picture" width="700px;">
          </div>
        </div>
      <?php endif ?>

      <?php if (isset($_SESSION['username'])) {
        require_once '../error_components/logged-in.php';
      } ?>
  </main>

<?php require_once '../footer.php'; ?>
