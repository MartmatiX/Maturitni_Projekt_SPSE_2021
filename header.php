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
          <a href="users/login-user.php">Přihlásit se</a>
          <a href="users/register-user.php">Registrovat se</a>
        <?php else: ?>
          <a href="objective_organizer.php">Objective Organizer</a>
          <a href="users/profile-user.php"><?php echo $_SESSION['username']; ?></a>
        <?php endif; ?>
      </nav>
    </header>
