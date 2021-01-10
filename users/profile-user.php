<?php require_once '../header.php'; ?>

<main>

  <?php if (!isset($_SESSION['username'])): ?>
    <?php require_once '../error_components/not_logged-in.php'; ?>
  <?php else: ?>
    <div class="profile_wrapper">
      <div class="profile_profile">
        <div class="form_header">
          <h1>Profil</h1>
        </div>
        <div class="profile_data">
          <h1><?php echo $_SESSION['name']." ".$_SESSION['surname']; ?></h1>
          <h3><?php echo $_SESSION['email'] ?></h3>
          <h2><?php echo $_SESSION['username'] ?></h2>
          <div class="change_data">
            <div class="change_user_data">
              <a href="changeData-user.php">Změnit údaje</a>
            </div>
            <div class="change_user_password">
              <a href="changePassword-user.php">Změnit heslo</a>
            </div>
          </div>
        </div>
        <div class="logOut_form">
          <form class="" method="post">
            <input class="form_send" type="submit" name="logOut" value="Odhlásit se">
          </form>
        </div>
      </div>
      <div class="div_edit_picture">
        <img src="../css/pictures/profile_picture.svg" alt="profile_picture" width="600px">
      </div>
    </div>
  <?php endif; ?>

  <?php
    if (isset($_POST['logOut'])) {
      session_unset();
      header("Location: ../index.php");
    }
   ?>
</main>

<?php require_once '../footer.php'; ?>
