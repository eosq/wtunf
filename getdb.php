<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require "twitteroauth2/autoload.php";
require "config.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$checklim   = 0;
$connection = new TwitterOAuth($CONSUMER_KEY[$checklim], $CONSUMER_SECRET[$checklim], $oauth_tok[$checklim], $oauth_sec[$checklim]);
$mysqli     = new mysqli(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BD);
if (mysqli_connect_errno())
    exit();
$mysqli->set_charset("utf8mb4");

$query = "TRUNCATE TABLE unfoll";
$stmt  = $mysqli->query($query);
echo '<div aling="center" class="well"><p>очистили таблицу</p>';
$cursor     = -1;
$friendsArr = array();

do {

    $friends = $connection->get('friends/ids', array(
        'cursor' => $cursor,
        'count' => 5000
    ));
    if (isset($friends->errors)) {
        echo '<h1>error:' . $friends->errors->message . '</h1>';
        exit();
    }
    $friendsArr = array_merge($friendsArr, $friends->ids);
    $cursor     = $friends->next_cursor;
} while ($friends->next_cursor != 0);
for ($i = 0; $i < count($friendsArr); $i++) {
    $query = "INSERT INTO unfoll(user_id) VALUES('$friendsArr[$i]') ";
    $stmt  = $mysqli->query($query);
}

echo '<p>заполнили все id</p>';
$cursor = -1;

$followersArr = array();
do {
    // для followers
    $followers = $connection->get('followers/ids', array(
        'cursor' => $cursor
    ));
    if (isset($followers->errors)) {
        echo '<h1>error:' . $followers->errors['message'] . '</h1>';
        exit();
    }
    array(
        $followers->ids
    );
    $followersArr = array_merge($followersArr, $followers->ids);

    $cursor = $followers->next_cursor;
} while ($followers->next_cursor != 0);

$notFollowArr = array_diff($friendsArr, $followersArr);
$notfollow100 = array_chunk($friendsArr, 100);
$u            = -1;
$t            = 0;
do {
    $u++;
    if (count($notfollow100[$u]) == 100) {
        $notfollow = implode(',', $notfollow100[$u]);
    } else {
        $notfollow = implode(',', $notfollow100[$u]);
    }
    $lookup = $connection->get('users/lookup', array(
        'user_id' => $notfollow
    ));
    if (isset($lookup->errors)) {
        echo '<h1>error:' . $lookup->errors['message'] . '</h1>';
        exit();
    }
    foreach ($lookup as $look) {
        $friend_count = $look->friends_count == 0 ? 1 : $look->friends_count;
        $Follonwer    = round($look->followers_count / $friend_count, 2);
        $id           = $look->id;

        if (isset($look->entities->url->urls[0]->expanded_url)) {
            $url = $look->entities->url->urls[0]->expanded_url;
        } else {
            $url = null;
        }

        $name        = $mysqli->real_escape_string(htmlspecialchars(trim(strip_tags(stripslashes($look->name)))));
        $description = $mysqli->real_escape_string(htmlspecialchars(trim(strip_tags(stripslashes($look->description)))));
        $location    = $mysqli->real_escape_string(htmlspecialchars(trim(strip_tags(stripslashes($look->location)))));
        if (in_array($id, $notFollowArr)) {
            $followme = 0;
        } else {
            $followme = 1;
        }
        if (isset($look->status->created_at)) {
            $status_created_at = htmlspecialchars(trim(strip_tags(stripslashes($look->status->created_at))));
        }
        if (isset($look->status->text)) {
            $status = $mysqli->real_escape_string(htmlspecialchars(trim(strip_tags(stripslashes($look->status->text)))));
        } else {
            $status = NULL;
        }


        $query = "UPDATE unfoll SET
name='$name',
display_url='$url',
location='$location',
screen_name='$look->screen_name',
last_status='$status',
description='$description',
time_zone='$look->time_zone',
statuses_count='$look->statuses_count',
lang='$look->lang',
protected='$look->protected',
followers_count='$look->followers_count',
friends_count='$look->friends_count',
listed_count='$look->listed_count',
created_at='$look->created_at',
favourites_count='$look->favourites_count',
is_translator='$look->is_translator',
profile_background_color='$look->profile_background_color',
profile_image_url='$look->profile_image_url_https',
profile_background_image_url='$look->profile_background_image_url',
profile_use_background_image='$look->profile_use_background_image',
default_profile='$look->default_profile',
default_profile_image='$look->default_profile_image',
status_created_at='$status_created_at',
Follonwer='$Follonwer',
followme='$followme',
images=NULL,
links=NULL,
rts=NULL,
mentions=NULL,
jtweets=NULL
  WHERE user_id='$id'";
        $stmt  = $mysqli->query($query);

        $t++;
    }
} while (count($notfollow100[$u]) == 100);

echo '<p>' . $t . ' записей сделано. заполнили данные. таблица готова.</p></div>';
$mysqli->close();
?>
