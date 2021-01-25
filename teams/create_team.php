<?php require_once '../header.php'; ?>
<main>
  <?php if (!isset($_SESSION['id'])): ?>
    <h1>Nejste přihlášen</h1>
    <div class="div_backLink">
      <a href="../users/login-user.php"><button>Zpět</button></a>
    </div>
  <?php else: ?>
    <div class="div_backLink">
      <a href="teams.php"><button>Zpět</button></a>
    </div>
    <form class="" method="post">
      <input type="text" name="team_name" placeholder="Jméno týmu">
      <input type="submit" name="submit" value="Založit">
    </form>
    <?php
      if (isset($_POST['submit'])) {
        $team_name = htmlspecialchars($_POST['team_name']);
        if ($db->run("INSERT INTO teams(name, id_creator) VALUES (?,?)", [$team_name, $_SESSION['id']])) {
          header("Location: teams.php?creation=success");
        }else {
          header("Location: create_team.php?creation=failure");
        }
      }
     ?>
  <?php endif; ?>
</main>
<?php require_once '../footer.php'; ?>
