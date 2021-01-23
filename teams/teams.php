<?php require_once '../header.php'; ?>
<main>
  <?php if (!isset($_SESSION['id'])): ?>
    <h1>Nejste přihlášeni</h1>
  <?php else: ?>
    <a href="create_team.php">Založit nový</a>
    <a href="teams_invitations.php">Pozvánky</a>
    <h1>Vámi založené týmy:</h1>
    <?php
      $createdTeams = $db->run("SELECT * FROM teams WHERE id_creator = ?", [$_SESSION['id']])->fetchAll(PDO::FETCH_OBJ);
     ?>
     <?php foreach ($createdTeams as $teams): ?>
       <h3><?php echo $teams->name; ?></h3>
     <?php endforeach; ?>
     <h1>Ostatní týmy:</h1>
     <?php
      ?>
  <?php endif; ?>
</main>
<?php require_once '../footer.php'; ?>
