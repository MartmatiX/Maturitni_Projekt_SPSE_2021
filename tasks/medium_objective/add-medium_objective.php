<?php require_once '../../config/bootstrap.php'; ?>
<?php
   if (isset($_POST['submit'])) {
     $name = $_POST['name'];
     $finish_date = $_POST['finish_date'];
     if ($db->run("INSERT INTO medium_objectives(name, finish_date, main_objectives_id) VALUES (?,?,?)", [$name, $finish_date, $_GET['id']])) {
       header("Location: ../main_objective/details-main_objective.php?id=".$_GET['id']);
       exit();
     }
   }
 ?>
<?php require_once '../../header.php'; ?>
<main>
  <?php
    $main_objective = $db->run("SELECT * FROM main_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ);
   ?>
   <?php if (empty($main_objective) || $_SESSION['id'] != $main_objective->users_id): ?>
     <?php require_once '../../error_components/wrong_users.php'; ?>
   <?php else: ?>
     <div class="div_backLink">
       <a href="../main_objective/details-main_objective.php?id=<?php echo $_GET['id']; ?>"><button>Zpět</button></a>
     </div>
     <div class="form_wrapper">
       <div class="add_form">
         <div class="form_header">
           <h1>Přidání podúkolu</h1>
         </div>
         <div class="div_form">
           <form class="" method="post">
             <div class="form_spacing">
               <h3>Jméno podúkolu</h3>
               <input type="text" name="name" placeholder="Jméno">
             </div>
             <div class="form_spacing">
               <h3>Datum podúkolu</h3>
               <input type="date" name="finish_date" placeholder="Datum splnění">
             </div>
             <div class="form_spacing">
               <input class="form_send" type="submit" name="submit" value="Přidat">
             </div>
           </form>
         </div>
       </div>
       <div class="div_add_picture">
         <img class="image_responsive" src="../../css/pictures/add_picture.svg" alt="add_picture" width="500px">
       </div>
     </div>
   <?php endif; ?>
</main>
<?php require_once '../../footer.php'; ?>
