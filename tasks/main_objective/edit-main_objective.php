<?php require_once '../../header.php'; ?>
<?php $main_objective = $db->run("SELECT * FROM main_objectives WHERE id = ?", [$_GET['id']])->fetch(PDO::FETCH_OBJ); ?>
<?php if (empty($main_objective) || $_SESSION['id'] != $main_objective->users_id): ?>
  <?php require_once '../../error_components/wrong_users.php'; ?>
<?php else: ?>
  <form class="" method="post">
    <input type="text" name="name" value="<?php echo $main_objective->name; ?>">
    <input type="date" name="finish_date" value="<?php echo $main_objective->finish_date; ?>">
    <input type="checkbox" name="urgent" value="<?php if($main_objective->urgent == 1){echo 1;} ?>" id="urgent">
    <input type="submit" name="submit" value="Upravit">
  </form>

  <?php
    if (isset($_POST['submit'])) {
      $name = $_POST['name'];
      $date = $_POST['finish_date'];
      $urgent = 0;
      if (isset($_POST['urgent'])) {
        $urgent = 1;
      }
      var_dump($urgent);
      if ($db->run("UPDATE main_objectives SET name = ?, finish_date = ?, urgent = ? WHERE id = ?", [$name, $date, $urgent, $_GET['id']])) {
        header("Location: ../../objective_organizer.php");
      }else {
        echo "error";
      }
    }
  ?>

  <script type="text/javascript">
    // dodělat check u checkboxu, pokud je urgent
  </script>
<?php endif; ?>
