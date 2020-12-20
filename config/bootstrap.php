<?php
require_once __DIR__ . '/../dbConn/dbConn.php';
require_once __DIR__ . '/../users/User.php';
require_once __DIR__ . '/../tasks/main_objective/MainObjective.php';
require_once __DIR__ . '/../tasks/medium_objective/MediumObjective.php';
require_once __DIR__ . '/../tasks/additional_objective/AdditionalObjective.php';

mb_internal_encoding("UTF-8");
session_start();

$db = new dbConn("malirma_1", "root", "");
$user = new User;
$main_objective = new MainObjective;
$medium_objective = new MediumObjective;
$additional_objective = new AdditionalObjective;

?>
