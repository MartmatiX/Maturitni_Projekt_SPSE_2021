<?php
require_once "./dbConn/dbConn.php";

mb_internal_encoding("UTF-8");
session_start();

$db = new dbConn("maturitni_projekt", "root", "");
