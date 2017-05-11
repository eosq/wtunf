<?php
require "config.php";
$user_id = htmlspecialchars(trim(strip_tags(stripslashes($_POST['user_id']))));
try {
    $dbh = new PDO("mysql:host=$MYSQL_HOST;dbname=$MYSQL_BD;charset=utf8mb4", $MYSQL_LOGIN, $MYSQL_PASS);

    $query = 'UPDATE '.$MYSQL_TABLE.' SET wlist="1" WHERE user_id='.$user_id;
    $sth=$dbh->prepare($query);
    $sth->execute();
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
