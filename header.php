<?php require_once 'config/bootstrap.php'; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="/../webs/Maturitni_Projekt_New/css/master.css">
    <title>Objective Organizer</title>
  </head>
  <body>
    <header>
      <nav>
        <?php if (!isset($_SESSION['username'])): ?>
          <div class="header_wrapper">
            <div class="header_background">
              <div class="header_header">
                Objective Organizer
              </div>
              <div class="header_links">
                <a href="/../webs/Maturitni_Projekt_New/index.php">O projektu</a>
                <a href="/../webs/Maturitni_Projekt_New/users/login-user.php">Přihlásit se</a>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="header_wrapper">
            <div class="header_background">
              <div class="header_header">
                Objective Organizer
              </div>
              <div class="header_links">
                <a href="/../webs/Maturitni_Projekt_New/objective_organizer.php">Úkoly</a>
                <a href="/../webs/Maturitni_Projekt_New/teams/teams.php">Týmy</a>
                <a href="/../webs/Maturitni_Projekt_New/users/profile-user.php"><?php echo $_SESSION['name']." ".$_SESSION['surname']; ?></a>
                <?php if (isset($_SESSION['permission']) && $_SESSION['permission'] == 0): ?>
                    <a href="/../webs/Maturitni_Projekt_New/statistics/statistics.php">Statistiky</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endif; ?>
      </nav>
    </header>
