<?php
require "config.php";
$user_id = htmlspecialchars(trim(strip_tags(stripslashes($_POST['user_id']))));
$mysqli  = new mysqli(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BD);
if (mysqli_connect_errno())
    exit();
$mysqli->set_charset("utf8mb4");
$query = "UPDATE unfoll SET wlist='1' WHERE user_id='$user_id'";
$stmt  = $mysqli->query($query);
?>
