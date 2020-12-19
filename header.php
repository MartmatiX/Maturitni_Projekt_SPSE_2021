<?php require_once 'config/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <header>
      <nav>
        <?php if (!isset($_SESSION['username'])): ?>
          <a href="/../webs/Maturitni_Projekt_New/users/login-user.php">Přihlásit se</a>
          <a href="/../webs/Maturitni_Projekt_New/users/register-user.php">Registrovat se</a>
        <?php else: ?>
          <a href="/../webs/Maturitni_Projekt_New/objective_organizer.php">Objective Organizer</a>
          <a href="/../webs/Maturitni_Projekt_New/users/profile-user.php"><?php echo $_SESSION['username']; ?></a>
        <?php endif; ?>
      </nav>
    </header>
