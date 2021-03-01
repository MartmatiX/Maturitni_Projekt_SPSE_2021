<?php require_once '../config/bootstrap.php'; ?>

<?php
  if (isset($_POST['leave'])) {
    if ($db->run("DELETE FROM users_teams WHERE id_teams = ?", [$_POST['team_id']])) {
      header("Location: teams.php?left");
      exit();
    }
  }
  if (isset($_POST['disbandon'])) {
    if ($db->run("DELETE FROM teams WHERE id = ?", [$_POST['created_team_id']])) {
      header("Location: teams.php?disbanded");
      exit();
    }
  }
 ?>

<?php require_once '../header.php'; ?>
<main>
  <div class="organizer_wrapper">
  <?php if (!isset($_SESSION['id'])): ?>
    <h1>Nejste přihlášen</h1>
    <div class="div_backLink">
      <a href="../users/login-user.php"><button>Zpět</button></a>
    </div>
  <?php else: ?>
    <?php
      $createdTeams = $db->run("SELECT * FROM teams WHERE id_creator = ?", [$_SESSION['id']])->fetchAll(PDO::FETCH_OBJ);

      $count = $db->run("SELECT count('id') AS pocet FROM teams_requests WHERE id_user = ?", [$_SESSION['id']])->fetch(PDO::FETCH_OBJ);
     ?>
     <div class="main_wrapper">
       <div class="organizer_header">
         <?php if (empty($createdTeams)): ?>
          <h1>Nejste zakladatel žádného týmu</h1>
          <div class="organizer_header_links">
            <a href="create_team.php" class="link_spacing_right">Založit nový</a>
            <p>|</p>
            <a href="teams_invitations.php" class="link_spacing_left">Pozvánky (<?php echo $count->pocet ?>)</a>
          </div>
        <?php else: ?>
          <h1>Vámi založené týmy:</h1>
          <div class="organizer_header_links">
            <a href="create_team.php" class="link_spacing_right">Založit nový</a>
          </div>
       </div>
     </div>


      <div class="flex_wrap">
       <?php foreach ($createdTeams as $createdTeam): ?>
         <div class="card_wrapper">
           <div class="card_header">
             <h4><?php echo $createdTeam->name; ?></h4>
           </div>
           <div class="card_progressBar"></div>
           <div class="card_counter_date">
             <?php
              $tasks_counter = $db->run("SELECT count(id) AS pocet FROM teams_main_objectives WHERE teams_id = ?", [$createdTeam->id])->fetch(PDO::FETCH_OBJ);
              $user_counter = $db->run("SELECT count(id_users) AS pocet_uzivatelu FROM users_teams WHERE id_teams = ?", [$createdTeam->id])->fetch(PDO::FETCH_OBJ);
             ?>
             <div class="card_counter">
               <h5><?php echo $tasks_counter->pocet; ?> úkolů</h5>
             </div>
             <div class="card_date">
               <h5><?php echo $user_counter->pocet_uzivatelu; ?> uživatelů</h5>
             </div>
           </div>
           <div class="detail_div">
             <a href="teams-main_objective_details.php?id=<?php echo $createdTeam->id ?>"><img src="../css/pictures/icon_edit.png" alt="icon_edit" height="40px" width="40px"></a>
             <form class="" method="post">
               <input style="float: right;" type="submit" class="form_delete" name="disbandon" value="">
               <input type="text" style="display:none;" name="created_team_id" value="<?php echo $createdTeam->id; ?>">
             </form>
           </div>
         </div>
       <?php endforeach; ?>
       </div>
    <?php endif; ?>

    <?php
      $teams = $db->run("SELECT * FROM teams JOIN users_teams ON teams.id = users_teams.id_teams WHERE users_teams.id_users = ?", [$_SESSION['id']])->fetchAll(PDO::FETCH_OBJ);
    ?>

      <div style="padding-top: 20px;" class="organizer_header">
        <?php if (empty($teams)): ?>
          <h1>Nejste členem žádného týmu</h1>
          <div class="organizer_header_links">
            <a href="teams_invitations.php" class="link_spacing_left">Pozvánky (<?php echo $count->pocet; ?>)</a>
          </div>
        <?php else: ?>
          <h1>Ostatní týmy:</h1>
          <div style="padding-bottom: 40px;" class="organizer_header_links">
            <a href="teams_invitations.php" class="link_spacing_left">Pozvánky (<?php echo $count->pocet; ?>)</a>
          </div>
      </div>
      <div class="flex_wrap">
        <?php foreach ($teams as $team): ?>
          <?php
            $creator = $db->run("SELECT username FROM users WHERE id = ?", [$team->id_creator])->fetch(PDO::FETCH_OBJ);
            $pocet_ukolu = $db->run("SELECT count('id') AS pocet FROM teams_main_objectives WHERE teams_id = ?", [$team->id_teams])->fetch(PDO::FETCH_OBJ);
          ?>
          <div class="card_wrapper">
            <div class="card_header">
              <h4><?php echo $team->name; ?></h4>
            </div>
            <div class="card_progressBar"></div>
            <div class="card_counter_date">
              <div class="card_counter">
                <h5>Zakladatel: <?php echo $creator->username; ?></h5>
              </div>
              <div class="card_date">
                <h5>Úkoly: <?php echo $pocet_ukolu->pocet; ?></h5>
              </div>
            </div>
            <div class="detail_div">
              <div class="">
                <a href="teams-main_objective_details.php?id=<?php echo $team->id ?>"><img src="../css/pictures/icon_details.png" alt="icon_details" height="40px" width="40px"></a>
              </div>
              <div class="">
                <form class="" method="post">
                  <input style="float: right;" type="submit" class="form_delete" name="leave" value="">
                  <input type="text" style="display:none;" name="team_id" value="<?php echo $team->id; ?>">
                </form>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    <?php endif; ?>
    </div>
</main>
<?php require_once '../footer.php'; ?>
