<?php require '../header.php'; ?>

<?php if (!isset($_SESSION['username'])): ?>
  <h1>Vyskytla se chyba</h1>
  <a href="../objective_organizer.php">zpět</a>
<?php else: ?>
  <div class="div_backLink">
    <a href="profile-user.php"><button>Zpět</button></a>
  </div>
<?php endif; ?>

<?php require '../footer.php'; ?>
