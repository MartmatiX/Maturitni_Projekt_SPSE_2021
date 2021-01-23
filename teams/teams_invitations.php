<?php require_once '../header.php'; ?>
<main>
  <?php if (!isset($_SESSION['id'])): ?>
    <h1>Nejste přihlášeni</h1>
    <div class="div_backLink">
      <a href="../users/login-user.php"><button>Zpět</button></a>
    </div>
  <?php else: ?>
    <div class="div_backLink">
      <a href="teams.php"><button>Zpět</button></a>
    </div>
    <?php
      $active_invitations = $db->run("SELECT * FROM teams_requests WHERE id_user = ?", [$_SESSION['id']])->fetchAll(PDO::FETCH_OBJ);
     ?>
     <?php if (empty($active_invitations)): ?>
       <h1>Nemáte žádné pozvánky do týmu</h1>
     <?php else: ?>
       <?php foreach ($active_invitations as $active_invitation): ?>
         <h3><?php echo $active_invitation->id; ?></h3>
       <?php endforeach; ?>
     <?php endif; ?>
  <?php endif; ?>
</main>
<?php require_once '../footer.php'; ?>
