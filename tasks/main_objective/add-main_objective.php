<?php require_once '../../header.php'; ?>
<main>
  <?php if (isset($_SESSION['username'])): ?>
    <div class="div_backLink">
      <a href="../../objective_organizer.php"><button>Zpět</button></a>
    </div>
    <div class="form_wrapper">
      <div class="add_form">
        <div class="form_header">
          <h1>Přidání úkolu</h1>
        </div>
        <div class="div_form">
          <form class="" method="post">
            <div class="form_spacing">
              <h3>Jméno úkolu</h3>
              <input type="text" name="name" placeholder="Jméno úkolu" required>
            </div>
            <div class="form_spacing">
              <h3>Datum dokončení úkolu</h3>
              <input type="text" name="finish_date" id="finish_date" placeholder="Datum" onfocus="(this.type='date')" onfocusout="(this.type='text')" required>
            </div>
            <div class="form_spacing_urgent">
              <input type="checkbox" name="urgent" id="urgent">
              <h3>Urgentní úkol</h3>
            </div>
            <div class="form_spacing">
              <input class="form_send" type="submit" name="submit" value="Přidat">
            </div>
          </form>
        </div>
      </div>
      <div class="div_add_picture">
        <img src="../../css/pictures/add_picture.svg" alt="add_picture" width="500px">
      </div>
    </div>
    <?php
      if (isset($_POST['submit'])) {
        $name = htmlspecialchars($name = $_POST['name']);
        $finish_date = htmlspecialchars($finish_date = $_POST['finish_date']);
        if (isset($_POST['urgent'])) {
          $urgent = 1;
        }else {
          $urgent = 0;
        }
        if ($db->run("INSERT INTO main_objectives(name, finish_date, urgent, users_id) VALUES(?,?,?,?)", [$name, $finish_date, $urgent, $_SESSION['id']])) {
          header("Location: ../../objective_organizer.php");
        }
        else {
          header("Location: add-main_objective.php");
        }
      }
     ?>
     <script type="text/javascript">
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd < 10){
          dd = '0' + dd;
        }
        if(mm < 10){
          mm = '0' + mm;
        }
        today = yyyy+'-'+mm+'-'+dd;
        document.getElementById("finish_date").setAttribute("min", today);
     </script>
  <?php else:?>
    <?php require_once "../../error_components/not_logged-in.php"; ?>
  <?php endif; ?>
  <?php require_once '../../footer.php'; ?>
</main>
