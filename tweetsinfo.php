<?php
ini_set('error_reporting', E_ALL);
set_time_limit(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require "twitteroauth2/autoload.php";
require "config.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$arrids     = array();
$checklim   = 0;
$connection = new TwitterOAuth($CONSUMER_KEY[$checklim], $CONSUMER_SECRET[$checklim]);
$mysqli     = new mysqli(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BD);
if (mysqli_connect_errno())
    exit();
$mysqli->set_charset("utf8mb4");
$query = "SELECT * FROM unfoll WHERE protected IN (0) AND images is NULL";

$stmt    = $mysqli->query($query);
$row_cnt = $stmt->num_rows;
while ($l = $stmt->fetch_assoc()) {
    $arrids[] = $l["user_id"];
}
$i = 0;
$t = 0;
do {
    $timeline = $connection->get('statuses/user_timeline', array(
        'user_id' => $arrids[$i],
        'include_rts' => 'true',
        'count' => 200,
        'contributor_details' => 'false',
        'trim_user' => 'true'
    ));
    while (isset($timeline->errors)) {
        $checklim++;
        if ($checklim == count($CONSUMER_KEY)-1) {
            echo '<h1>error</h1>';
            exit;
        }
        $connection = new TwitterOAuth($CONSUMER_KEY[$checklim], $CONSUMER_SECRET[$checklim]);
        $timeline   = $connection->get('statuses/user_timeline', array(
            'user_id' => $arrids[$i],
            'include_rts' => 'true',
            'count' => 200,
            'contributor_details' => 'false',
            'trim_user' => 'true'
        ));
    }

    $retweets_count = $links_count = $image_count = $mention_count = $jtweets = 0;
    $tweet_count    = count($timeline);

    foreach ($timeline as $statuses) {
        if ($statuses->retweeted_status != null) {
            $retweets_count++;
        } // RTs

        if ($statuses->entities->urls[0] != null && $statuses->entities->media[0]->media_url == null) {
            foreach ($statuses->entities->urls as $key) {
                $links_count++;
            }
        } // tweets with links


        if (isset($statuses->extended_entities)) {
            foreach ($statuses->extended_entities->media as $url) {
                $image_count++;
            } // tweets with images
        }

        if ($statuses->in_reply_to_status_id != null && $statuses->retweeted_status == null) {
            $mention_count++;
        } // tweets with mentions

        if ($statuses->in_reply_to_status_id == null && $statuses->entities->urls == null && $statuses->entities->media[0]->media_url == null && $statuses->retweeted_status == null) {
            $jtweets++;
        }
    }

    $query = "UPDATE unfoll SET
  images='$image_count',
  links='$links_count',
  rts='$retweets_count',
  mentions='$mention_count',
  jtweets='$jtweets'
  WHERE user_id='$arrids[$i]'";
    $stmt  = $mysqli->query($query);

    $i++;
    $t++;

} while ($t < $row_cnt);

echo '<h3>Updated ' . $i . 'public accounts. left ' . $row_cnt . '</h3>';

$checklim   = 0;
$connection = new TwitterOAuth($CONSUMER_KEY[$checklim], $CONSUMER_SECRET[$checklim], $oauth_tok[$checklim], $oauth_sec[$checklim]);
$query      = "SELECT * FROM unfoll WHERE protected IN (1) AND images is NULL";
$stmt       = $mysqli->query($query);
$row_cnt    = $stmt->num_rows;
if ($row_cnt == 0) {
    exit();
}
while ($l = $stmt->fetch_assoc()) {
    $arrids[] = $l["user_id"];
}
$i = 0;
$t = 0;
do {
    $timeline = $connection->get('statuses/user_timeline', array(
        'user_id' => $arrids[$i],
        'include_rts' => 'true',
        'count' => 200,
        'contributor_details' => 'false',
        'trim_user' => 'true'
    ));
    while (isset($timeline->errors)) {
        $checklim++;
        if ($checklim == count($CONSUMER_KEY)-1) {
            echo '<h1>error</h1>';
            exit;
        }
        $connection = new TwitterOAuth($CONSUMER_KEY[$checklim], $CONSUMER_SECRET[$checklim], $oauth_tok[$checklim], $oauth_sec[$checklim]);
        $timeline   = $connection->get('statuses/user_timeline', array(
            'user_id' => $arrids[$i],
            'include_rts' => 'true',
            'count' => 200,
            'contributor_details' => 'false',
            'trim_user' => 'true'
        ));
    }

    $retweets_count  = $links_count = $image_count = $mention_count = $jtweets = 0;
    $tweet_count     = count($timeline);
    $retweets_tweets = $links_tweets = $image_tweets = $mention_tweets = $txt_tweets = $txt_all_tweets = array();

    foreach ($timeline as $statuses) {
        if ($statuses->retweeted_status != null) {
            $retweets_count++;
        } // RTs

        if ($statuses->entities->urls[0] != null && $statuses->entities->media[0]->media_url == null) {
            foreach ($statuses->entities->urls as $key) {
                $links_count++;
            }
        } // tweets with links

        if (isset($statuses->extended_entities)) {
            foreach ($statuses->extended_entities->media as $url) {
                $image_count++;
            } // tweets with images
        }

        if ($statuses->in_reply_to_status_id != null && $statuses->retweeted_status == null) {
            $mention_count++;
        } // tweets with mentions

        if ($statuses->in_reply_to_status_id == null && $statuses->entities->urls == null && $statuses->entities->media[0]->media_url == null && $statuses->retweeted_status == null) {
            $jtweets++;
        }
    }

  $query = "UPDATE unfoll SET
  images='$image_count',
  links='$links_count',
  rts='$retweets_count',
  mentions='$mention_count',
  jtweets='$jtweets'
  WHERE user_id='$arrids[$i]'";
    $stmt  = $mysqli->query($query);

    $i++;
    $t++;


} while ($t < $row_cnt);
echo '<h3>Updated ' . $i . ' protected accounts. left ' . $row_cnt-$i . '</h3>';
?>
