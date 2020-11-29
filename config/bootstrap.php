<?php
require_once __DIR__ . '/../dbConn/dbConn.php';
require_once __DIR__ . '/../users/User.php';

mb_internal_encoding("UTF-8");
session_start();

$db = new dbConn("maturitni_projekt", "root", "");
$user = new User;

?>
