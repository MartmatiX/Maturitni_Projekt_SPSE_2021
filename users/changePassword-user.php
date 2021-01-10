<?php require '../header.php'; ?>

<?php if (!isset($_SESSION['username'])): ?>
  <h1>Vyskytla se chyba</h1>
  <a href="../objective_organizer.php">zpět</a>
<?php else: ?>
  <div class="div_backLink">
    <a href="profile-user.php"><button>Zpět</button></a>
  </div>

  <div class="form_wrapper">
    <div class="add_form">
      <div class="form_header">
        <h1>Změna hesla</h1>
      </div>
      <div class="div_form">
        <form class="" method="post">
          <div class="form_spacing">
            <h3>Staré heslo</h3>
            <input type="password" name="old_password" placeholder="**********">
          </div>
          <div class="form_spacing">
            <h3>Nové heslo</h3>
            <input type="password" name="new_password" placeholder="**********">
          </div>
          <div class="form_spacing">
            <h3>Ověření nového hesla</h3>
            <input type="password" name="new_password_checker" placeholder="**********">
          </div>
          <div class="form_spacing">
            <input class="form_send" type="submit" name="submit" value="Změnit">
            <p>Po změně hesla se musíte znovu přihlásit</p>
          </div>
        </form>
      </div>
    </div>
    <div class="div_edit_picture">
      <img class="image_responsive" src="../css/pictures/change_password_picture.svg" alt="change_password_picture">
    </div>
  </div>
  <?php
    if (isset($_POST['submit'])) {
      $old_password = htmlspecialchars($_POST['old_password']);
      $new_password = htmlspecialchars($_POST['new_password']);
      $new_password_checker = htmlspecialchars($_POST['new_password_checker']);
      if (!password_verify($old_password, $_SESSION['password'])) {
        header("Location: changePassword-user.php?change=wrongOldPassword");
      }elseif ($new_password != $new_password_checker) {
        header("Location: changePassword-user.php?change=passwordsDoesntMatch");
      }else{
        $password = password_hash($new_password, PASSWORD_DEFAULT);
        if ($db->run("UPDATE users SET password = ? WHERE id = ?", [$password, $_SESSION['id']])) {
          session_unset();
          session_destroy();
          header("Location: login-user.php?change=success");
        }else{
          header("Location: login-user.php?change=failure");
        }
      }
    }
   ?>
<?php endif; ?>

<?php require '../footer.php'; ?>
