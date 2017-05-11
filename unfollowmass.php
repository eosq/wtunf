<?php
session_start();
require "twitteroauth/autoload.php";
require "config.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$checklim   = 0;
$connection = new TwitterOAuth($CONSUMER_KEY[$checklim], $CONSUMER_SECRET[$checklim], $oauth_tok[$checklim], $oauth_sec[$checklim]);
$user_id    = htmlspecialchars(trim(strip_tags(stripslashes($_POST['user_id']))));

$userarr=explode(',', $user_id);
$i=0;
foreach ($userarr as $user) {
    $unfollow   = $connection->post('friendships/destroy', array(
    'user_id' => $user
));

    if (isset($unfollow->errors)) {
        $checklim++;
        if ($checklim == count($CONSUMER_KEY)-1) {
            echo '<h1>error:' . $unfollow->errors['message'] . '</h1>';
            break;
        }
    } else {
        try {
            $dbh = new PDO("mysql:host=$MYSQL_HOST;dbname=$MYSQL_BD;charset=utf8mb4", $MYSQL_LOGIN, $MYSQL_PASS);
            $query = 'DELETE FROM '.$MYSQL_TABLE.' WHERE user_id='.$user;
            $sth=$dbh->prepare($query);
            $sth->execute();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
    $i++;
}
echo '<h1>Unfollowed ' . $i . ' users</h1>';
