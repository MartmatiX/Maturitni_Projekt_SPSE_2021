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
    <?php
      $active_invitations = $db->run("SELECT * FROM teams_requests WHERE id_user = ?", [$_SESSION['id']])->fetchAll(PDO::FETCH_OBJ);
     ?>
     <?php if (empty($active_invitations)): ?>
       <h1>Nemáte žádné pozvánky do týmu</h1>
     <?php else: ?>
       <?php foreach ($active_invitations as $active_invitation): ?>
         <?php
            $teams_info = $db->run("SELECT * FROM teams JOIN teams_requests ON teams.id = teams_requests.id_team WHERE teams.id = ?", [$active_invitation->id])->fetchAll(PDO::FETCH_OBJ);
          ?>
          <?php foreach ($teams_info as $team_info): ?>
            <h3><?php echo $team_info->name; ?></h3>
            <form class="" method="post">
              <input type="submit" name="accept" value="Přidat se">
              <input type="submit" name="decline" value="Odmítnout">
              <input type="text" name="id_request" value="<?php echo $active_invitation->id; ?>" style="display:none">
              <input type="text" name="id_team" value="<?php echo "$team_info->id_team"; ?>" style="display:none">
            </form>
          <?php endforeach; ?>
       <?php endforeach; ?>
       <?php
          if (isset($_POST['decline'])) {
            if ($db->run("DELETE FROM teams_requests WHERE id = ?", [$_POST['id_request']])) {
              header("Location: teams.php?invitation=declined");
            }else{
              header("Location: teams_invitations.php?failure");
            }
          }
          if (isset($_POST['accept'])) {
            if ($db->run("INSERT INTO users_teams(id_users, id_teams) VALUES (?,?)", [$_SESSION['id'], $_POST['id_team']])) {
              $db->run("DELETE FROM teams_requests WHERE id = ?", [$_POST['id_request']]);
              header("Location: teams.php?invitation=accepted");
            }else{
              header("Location: teams_invitations.php?failure");
            }
          }
        ?>
     <?php endif; ?>
  <?php endif; ?>
</main>
<?php require_once '../footer.php'; ?>
