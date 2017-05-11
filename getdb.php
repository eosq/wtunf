<?php
require "twitteroauth/autoload.php";
require "config.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$checklim   = 0;
$connection = new TwitterOAuth($CONSUMER_KEY[$checklim], $CONSUMER_SECRET[$checklim], $oauth_tok[$checklim], $oauth_sec[$checklim]);

try {
    $dbh = new PDO("mysql:host=$MYSQL_HOST;dbname=$MYSQL_BD;charset=utf8mb4", $MYSQL_LOGIN, $MYSQL_PASS);
    $query = "TRUNCATE TABLE unfoll";
    $sth=$dbh->prepare($query);
    $sth->execute();
    $sth=null;
    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

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

    try {
        $dbh = new PDO("mysql:host=$MYSQL_HOST;dbname=$MYSQL_BD;charset=utf8mb4", $MYSQL_LOGIN, $MYSQL_PASS);
        $sth=$dbh->prepare($query);
        $sth->execute();
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
$sth=$dbh=null;
echo '<p>заполнили все id</p>';
$cursor = -1;

$followersArr = array();
$y=0;
do {
    $y++;
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
} while ($followers->next_cursor != 0|| $y<2);

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

        $name        = htmlspecialchars(trim(strip_tags(stripslashes($look->name))));
        $description = htmlspecialchars(trim(strip_tags(stripslashes($look->description))));
        $location    = htmlspecialchars(trim(strip_tags(stripslashes($look->location))));
        if (in_array($id, $notFollowArr)) {
            $followme = 0;
        } else {
            $followme = 1;
        }
        if (isset($look->status->created_at)) {
            $status_created_at = $look->status->created_at;
        }
        if (isset($look->status->text)) {
            $status = htmlspecialchars(trim(strip_tags(stripslashes($look->status->text))));
        } else {
            $status = null;
        }
        if (isset($look->protected)&& $look->protected==1) {
            $protected = 1;
        } else {
            $protected = 0;
        }
        if (isset($look->is_translator)&& $look->is_translator==1) {
            $is_translator = 1;
        } else {
            $is_translator = 0;
        }
        if (isset($look->default_profile)&& $look->default_profile==1) {
            $default_profile = 1;
        } else {
            $default_profile = 0;
        }
        if (isset($look->default_profile_image)&& $look->default_profile_image==1) {
            $default_profile_image = 1;
        } else {
            $default_profile_image = 0;
        }
        if (isset($look->profile_use_background_image)&& $look->profile_use_background_image==1) {
            $profile_use_background_image = 1;
        } else {
            $profile_use_background_image = 0;
        }


        $query = "UPDATE unfoll SET
                    name = :name,
                    display_url = :display_url,
                    location = :location,
                    screen_name = :screen_name,
                    last_status = :last_status,
                    description = :description,
                    time_zone = :time_zone,
                    statuses_count = :statuses_count,
                    lang = :lang,
                    protected = :protected,
                    followers_count = :followers_count,
                    friends_count = :friends_count,
                    listed_count = :listed_count,
                    created_at = :created_at,
                    favourites_count = :favourites_count,
                    is_translator = :is_translator,
                    profile_background_color = :profile_background_color,
                    profile_image_url = :profile_image_url,
                    profile_background_image_url = :profile_background_image_url,
                    profile_use_background_image = :profile_use_background_image,
                    default_profile = :default_profile,
                    default_profile_image = :default_profile_image,
                    status_created_at = :status_created_at,
                    Follonwer = :Follonwer,
                    followme = :followme
                    WHERE user_id = :user_id";
        try {
            $dbh = new PDO("mysql:host=$MYSQL_HOST;dbname=$MYSQL_BD;charset=utf8mb4", $MYSQL_LOGIN, $MYSQL_PASS);

            $sth=$dbh->prepare($query);

            $sth->bindValue(':name', $name);
            $sth->bindValue(':display_url', $url);
            $sth->bindValue(':location', $location);
            $sth->bindValue(':screen_name', $look->screen_name);
            $sth->bindValue(':last_status', $status);
            $sth->bindValue(':description', $description);
            $sth->bindValue(':time_zone', $look->time_zone);
            $sth->bindValue(':statuses_count', $look->statuses_count);
            $sth->bindValue(':lang', $look->lang);
            $sth->bindValue(':protected', $protected);
            $sth->bindValue(':followers_count', $look->followers_count);
            $sth->bindValue(':friends_count', $look->friends_count);
            $sth->bindValue(':listed_count', $look->listed_count);
            $sth->bindValue(':created_at', $look->created_at);
            $sth->bindValue(':favourites_count', $look->favourites_count);
            $sth->bindValue(':is_translator', $is_translator);
            $sth->bindValue(':profile_background_color', $look->profile_background_color);
            $sth->bindValue(':profile_image_url', $look->profile_image_url_https);
            $sth->bindValue(':profile_background_image_url', $look->profile_background_image_url);
            $sth->bindValue(':profile_use_background_image', $profile_use_background_image);
            $sth->bindValue(':default_profile', $default_profile);
            $sth->bindValue(':default_profile_image', $default_profile_image);
            $sth->bindValue(':status_created_at', $status_created_at);
            $sth->bindValue(':Follonwer', $Follonwer);
            $sth->bindValue(':followme', $followme);
            $sth->bindParam(':user_id', $id);
            
            $sth->execute();
            $sth=null;
            $t++;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }
} while (count($notfollow100[$u]) == 100);


echo '<p>' . $t . ' записей сделано. заполнили данные. таблица готова.</p></div>';
$sth=$dbh=null;
