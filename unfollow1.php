<?php
session_start();
require "twitteroauth2/autoload.php";
require "config.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$checklim   = 0;
$connection = new TwitterOAuth($CONSUMER_KEY[$checklim], $CONSUMER_SECRET[$checklim], $oauth_tok[$checklim], $oauth_sec[$checklim]);
$user_id    = htmlspecialchars(trim(strip_tags(stripslashes($_POST['user_id']))));
$unfollow   = $connection->post('friendships/destroy', array(
    'user_id' => $user_id
));
if (isset($unfollow->errors)) {
    echo '<h1>error:' . $unfollow->errors['message'] . '</h1>';
} else {

    $mysqli = new mysqli(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BD);
    if (mysqli_connect_errno())
        exit();
    $query = "DELETE FROM unfoll WHERE user_id='$user_id'";
    $stmt  = $mysqli->query($query);
}


?>
