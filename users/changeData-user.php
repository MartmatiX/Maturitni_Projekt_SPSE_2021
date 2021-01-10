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
        <h1>Editace údajů o Vás</h1>
      </div>
      <div class="div_form">
        <form class="" method="post">
          <div class="form_data">
            <div class="form_username_surname">
              <div class="form_spacing">
                <h3>Jméno</h3>
                <input type="text" name="name" pattern="^[A-ZĚŠČŘŽÝÁÍÉÚ]{1}[a-zěščřžýáíéú]{1,25}$" value="<?php echo $_SESSION['name']; ?>">
              </div>
              <div class="form_spacing">
                <h3>Příjmení</h3>
                <input type="text" name="surname" pattern="^[A-ZĚŠČŘŽÝÁÍÉÚ]{1}[a-zěščřžýáíéúů]{1,25}$" value="<?php echo $_SESSION['surname']; ?>">
              </div>
            </div>
            <div class="form_email_username">
              <div class="form_spacing">
                <h3>E-mail</h3>
                <input type="text" name="email" pattern="^[a-zěščřžýáíéůúA-ZĚŠČŘŽÝÁÍÉÚ.-_1-9]{1,}[@][a-z]{1,}[.][a-z]{1,}$" value="<?php echo $_SESSION['email']; ?>">
              </div>
              <div class="form_spacing">
                <h3>Uživatelské jméno</h3>
                <input type="text" name="username" value="<?php echo $_SESSION['username']; ?>">
              </div>
            </div>
          </div>
            <div class="change_button">
              <input class="form_send" type="submit" name="submit" value="Změnit">
            </div>
        </form>
      </div>
    </div>
    <div class="div_edit_picture">
      <img src="../css/pictures/edit_picture.svg" alt="edit_picture" width="500px">
    </div>
  </div>
  <?php
    if (isset($_POST['submit'])) {

    }
   ?>
<?php endif; ?>

<?php require '../footer.php'; ?>
