<?php require_once '../header.php'; ?>
<main>
  <?php
    $team = $db->run("SELECT * FROM teams WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
   ?>
   <?php if ($team->id_creator != $_SESSION['id']): ?>
     <h1>K zobrazení tohoto obsahu nemáte dostatečná oprávnění</h1>
     <div class="div_backLink">
       <a href="teams.php"><button>Zpět</button></a>
     </div>
   <?php else: ?>
     <div class="div_backLink">
       <a href="teams.php"><button>Zpět</button></a>
     </div>
     <a href="teams-members.php?id=<?php echo $team->id; ?>">Členi</a>
     <a href="teams-delete_team.php?id=<?php echo $team->id; ?>">Odstranění týmu</a>
     <h3><?php echo $team->name; ?></h3>
   <?php endif; ?>
</main>
<?php require_once '../footer.php'; ?>
