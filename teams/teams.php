<?php require_once '../config/bootstrap.php'; ?>

<?php require_once '../header.php'; ?>
<main>
  <?php if (!isset($_SESSION['id'])): ?>
    <h1>Nejste přihlášen</h1>
    <div class="div_backLink">
      <a href="../users/login-user.php"><button>Zpět</button></a>
    </div>
  <?php else: ?>
    <a href="create_team.php">Založit nový</a>
    <a href="teams_invitations.php">Pozvánky</a>
    <?php
      $createdTeams = $db->run("SELECT * FROM teams WHERE id_creator = ?", [$_SESSION['id']])->fetchAll(PDO::FETCH_OBJ);
     ?>
    <?php if (empty($createdTeams)): ?>
      <h1>Nejste zakladatel žádného týmu</h1>
    <?php else: ?>
      <h1>Vámi založené týmy:</h1>
       <?php foreach ($createdTeams as $createdTeam): ?>
         <h3><?php echo $createdTeam->name; ?></h3>
         <a href="teams-main_objective_details.php?id=<?php echo $createdTeam->id ?>">Zobrazit</a>
       <?php endforeach; ?>
    <?php endif; ?>

    <?php
      $teams = $db->run("SELECT * FROM teams JOIN users_teams ON teams.id = users_teams.id_teams WHERE users_teams.id_users = ?", [$_SESSION['id']])->fetchAll(PDO::FETCH_OBJ);
     ?>
    <?php if (empty($teams)): ?>
      <h1>Nejste členem žádného týmu</h1>
    <?php else: ?>
      <h1>Ostatní týmy</h1>
      <?php foreach ($teams as $team): ?>
        <h3><?php echo $team->name; ?></h3>
        <a href="teams-main_objective_details.php?id=<?php echo $team->id ?>">Zobrazit</a>
      <?php endforeach; ?>
    <?php endif; ?>
  <?php endif; ?>
</main>
<?php require_once '../footer.php'; ?>
