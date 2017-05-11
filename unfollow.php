<?php
session_start();
require "twitteroauth/autoload.php";
require "config.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$checklim   = 1;
$connection = new TwitterOAuth($CONSUMER_KEY[$checklim], $CONSUMER_SECRET[$checklim], $oauth_tok[$checklim], $oauth_sec[$checklim]);
$user_id    = htmlspecialchars(trim(strip_tags(stripslashes($_POST['user_id']))));
$unfollow   = $connection->post('friendships/destroy', array(
    'user_id' => $user_id
));
if (isset($unfollow->errors)) {
    echo '<h1>error:' . $unfollow->errors['message'] . '</h1>';
} elseif (isset($unfollow->following) && $unfollow->following==false) {
    try {
        $dbh = new PDO("mysql:host=$MYSQL_HOST;dbname=$MYSQL_BD;charset=utf8mb4", $MYSQL_LOGIN, $MYSQL_PASS);
        $query = 'DELETE FROM '.$MYSQL_TABLE.' WHERE user_id='.$user_id;
        $sth=$dbh->prepare($query);
        $sth->execute();
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
} else {
    echo '<h1>error:</h1>';
    print_r($unfollow);
}
