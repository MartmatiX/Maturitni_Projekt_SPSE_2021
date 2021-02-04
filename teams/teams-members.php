<?php require_once '../config/bootstrap.php'; ?>

<?php require_once '../header.php'; ?>
<?php
$team = $db->run("SELECT * FROM teams WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
   if (isset($_POST['add'])) {
     if ($db->run("INSERT INTO teams_requests(id_user, id_team) VALUES (?,?)", [$_POST['id'], $_GET['id']])) {
       header("Location: teams-main_objective_details.php?id=".$_GET['id']);
       exit();
     }else{
       header("Location: teams-main_objective_details.php?id=".$_GET['id']);
       exit();
     }
   }

   if (isset($_POST['delete'])) {
     if ($db->run("DELETE FROM users_teams WHERE id_users = ? AND id_teams = ?", [$_POST['user_id'], $_GET['id']])) {
       header("Location: teams-members.php?id=".$_GET['id']);
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
      <a href="teams-main_objective_details.php?id=<?php echo $_GET['id']; ?>"><button>Zpět</button></a>
    </div>

    <div class="organizer_wrapper">
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

      <div class="teams_table_wrapper">
        <div class="teams_table">
          <?php $usersInTeam = $db->run("SELECT * FROM users JOIN users_teams ON users.id = users_teams.id_users WHERE users_teams.id_teams = ?", [$_GET['id']])->fetchAll(PDO::FETCH_OBJ); ?>
          <table>
            <th><h2>Jméno</h2></th>
            <th><h2>Příjmení</h2></th>
            <th><h2>Uživatelské jméno</h2></th>
            <?php foreach ($usersInTeam as $userInTeam): ?>
              <tr>
                <td>
                  <h3><?php echo $userInTeam->name; ?></h3>
                </td>
                <td>
                  <h3><?php echo $userInTeam->surname; ?></h3>
                </td>
                <td>
                  <h3><?php echo $userInTeam->username; ?></h3>
                </td>
                <td>
                  <form class=""method="post">
                    <input type="text" name="user_id" value="<?php echo $userInTeam->id; ?>" style="display:none;">
                    <input class="form_delete" style="background-color: darkred; border-radius:5px;" type="submit" name="delete" value="">
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>
  <?php endif; ?>
</main>
<?php require_once '../footer.php'; ?>
