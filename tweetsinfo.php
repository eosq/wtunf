<?php
ini_set('error_reporting', E_ALL);
set_time_limit(400);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require "twitteroauth/autoload.php";
require "config.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$arrids   =   $protected  = array();
$checklim   = 0;
$connection = new TwitterOAuth($CONSUMER_KEY[$checklim], $CONSUMER_SECRET[$checklim]);
$connprotect = new TwitterOAuth($CONSUMER_KEY[$checklim], $CONSUMER_SECRET[$checklim], $oauth_tok[$checklim], $oauth_sec[$checklim]);
try {
    $dbh = new PDO("mysql:host=$MYSQL_HOST;dbname=$MYSQL_BD;charset=utf8mb4", $MYSQL_LOGIN, $MYSQL_PASS);
    $query = 'SELECT * FROM '.$MYSQL_TABLE.' WHERE images is NULL';
    echo $query;
    $sth=$dbh->prepare($query);
    $sth->execute();
    $count = $sth->rowCount();
    $result = $sth->fetchAll();
    foreach ($result as $l) {
        $arrids[] = $l["user_id"];
        $protected[]=$l["protected"];
    }
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}

if (count($arrids)<0) {
    echo '<h1>Конец таблицы</h1>';
    exit;
}
for ($i=0;$i<count($arrids);$i++) {
    if ($protected[$i]==0) {
        $timeline = $connection->get('statuses/user_timeline', array(
        'user_id' => $arrids[$i],
        'include_rts' => 'true',
        'count' => 100,
        'contributor_details' => 'false',
        'trim_user' => 'true'
    ));
    } elseif ($protected[$i]==1) {
        $timeline = $connprotect->get('statuses/user_timeline', array(
          'user_id' => $arrids[$i],
          'include_rts' => 'true',
          'count' => 100,
          'contributor_details' => 'false',
          'trim_user' => 'true'
      ));
    } else {
        continue;
    }
    if (isset($timeline->errors)) {
        $checklim++;
        if ($checklim == count($CONSUMER_KEY)-1) {
            echo '<h1>error</h1>';
            exit;
        }
    }
    $retweets_count = $links_count = $image_count = $mention_count = $jtweets = 0;
    $tweet_count    = count($timeline);

    foreach ($timeline as $statuses) {
        if (isset($statuses->retweeted_status)) {
            if ($statuses->retweeted_status!= null) {
                $retweets_count++;
            }
        } // RTs

if (isset($statuses->entities->urls[0]) && !isset($statuses->entities->media[0]->media_url) && !isset($statuses->retweeted_status)) {
    if ($statuses->entities->urls[0] != null) {
        foreach ($statuses->entities->urls as $key) {
            $links_count++;
        }
    } // tweets with links
}

        if (isset($statuses->extended_entities) && !isset($statuses->retweeted_status)) {
            foreach ($statuses->extended_entities->media as $url) {
                $image_count++;
            } // tweets with images
        }
        if (!isset($statuses->retweeted_status)) {
            if (isset($statuses->entities->user_mentions[0]) || isset($statuses->in_reply_to_status_id) || isset($statuses->in_reply_to_user_id)) {
                $mention_count++;
            }
        } // tweets with mentions

if (!isset($statuses->in_reply_to_status_id) && isset($statuses->entities->urls) && !(isset($statuses->entities->media[0]->media_url)) &&
    !(isset($statuses->retweeted_status)) && !isset($statuses->in_reply_to_user_id)) {
    $jtweets++;
} //jtweets
    }
    $query = "UPDATE unfoll SET
  images='$image_count',
  links='$links_count',
  rts='$retweets_count',
  mentions='$mention_count',
  jtweets='$jtweets'
  WHERE user_id='$arrids[$i]'";
    try {
        $sth=$dbh->prepare($query);
        $sth->execute();
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}
echo '<h3>Updated ' . $i . ' public accounts</h3>';
