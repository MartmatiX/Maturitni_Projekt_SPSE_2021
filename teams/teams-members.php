<?php require_once '../config/bootstrap.php'; ?>

<?php require_once '../header.php'; ?>
<?php
$team = $db->run("SELECT * FROM teams WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
   if (isset($_POST['add'])) {
     if ($db->run("INSERT INTO teams_requests(id_user, id_team) VALUES (?,?)", [$_POST['id'], $_GET['id']])) {
       header("Location: teams-members.php?id=".$_GET['id']);
       exit();
     }else{
       header("Location: teams-members.php?id=".$_GET['id']);
       exit();
     }
   }
 ?>
<main>
  <?php if ($team->id_creator != $_SESSION['id']): ?>
    <h1>K zobrazení tohoto obsahu nemáte dostatečná oprávnění</h1>
    <div class="div_backLink">
      <a href="teams.php"><button>Zpět</button></a>
    </div>
  <?php else: ?>
    <div class="div_backLink">
      <a href="teams-creators_details.php?id=<?php echo $_GET['id']; ?>"><button>Zpět</button></a>
    </div>
    <form class=""  method="post">
      <input type="text" name="username" placeholder="Uživatelské jméno">
      <input type="submit" name="search" value="Hledat">
    </form>
    <?php if (isset($_POST['search'])): ?>
      <?php
        $username = htmlspecialchars($_POST['username']);
        $users = $db->run("SELECT * FROM users WHERE username = ?", [$username])->fetchAll(PDO::FETCH_OBJ);
       ?>
       <?php foreach ($users as $user): ?>
         <h3><?php echo $user->name ?></h3>
         <form class="" method="post">
           <input type="text" name="id" value="<?php echo $user->id ?>" style='display:none'>
           <input type="submit" name="add" value="Přidat">
         </form>
       <?php endforeach; ?>
    <?php endif; ?>
  <?php endif; ?>
</main>
<?php require_once '../footer.php'; ?>
