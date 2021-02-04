<?php require_once '../config/bootstrap.php'; ?>

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
     ?>
     <div class="main_wrapper">
       <div class="organizer_header">
         <?php if (empty($createdTeams)): ?>
          <h1>Nejste zakladatel žádného týmu</h1>
          <div class="organizer_header_links">
            <a href="create_team.php" class="link_spacing_right">Založit nový</a>
            <p>|</p>
            <a href="teams_invitations.php" class="link_spacing_left">Pozvánky</a>
          </div>
        <?php else: ?>
          <h1>Vámi založené týmy:</h1>
          <div class="organizer_header_links">
            <a href="create_team.php" class="link_spacing_right">Založit nový</a>
            <p>|</p>
            <a href="teams_invitations.php" class="link_spacing_left">Pozvánky</a>
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
           <a href="teams-main_objective_details.php?id=<?php echo $createdTeam->id ?>">Detaily</a>
         </div>
       <?php endforeach; ?>
       </div>
    <?php endif; ?>

    <?php
      $teams = $db->run("SELECT * FROM teams JOIN users_teams ON teams.id = users_teams.id_teams WHERE users_teams.id_users = ?", [$_SESSION['id']])->fetchAll(PDO::FETCH_OBJ);
     ?>

      <div class="organizer_header">
        <?php if (empty($teams)): ?>
          <h1>Nejste členem žádného týmu</h1>
        <?php else: ?>
          <h1>Ostatní týmy:</h1>
      </div>
      <div class="flex_wrap">
        <?php foreach ($teams as $team): ?>
          <div class="card_wrapper">
            <div class="card_header">
              <h4><?php echo $team->name; ?></h4>
            </div>
            <a href="teams-main_objective_details.php?id=<?php echo $team->id ?>">Zobrazit</a>
          </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    <?php endif; ?>
    </div>
</main>
<?php require_once '../footer.php'; ?>
