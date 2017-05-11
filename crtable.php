<?php
require "config.php";
try {
    $dbh = new PDO("mysql:host=$MYSQL_HOST;dbname=$MYSQL_BD;charset=utf8mb4", $MYSQL_LOGIN, $MYSQL_PASS);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql ="CREATE table $MYSQL_TABLE(
       id int(11) PRIMARY KEY AUTO_INCREMENT,
       user_id bigint(100) NOT NULL,
       name char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       screen_name char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       location char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       description char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       display_url char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       protected char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       followers_count int(20) DEFAULT NULL,
       friends_count int(12) DEFAULT NULL,
       listed_count int(6) DEFAULT NULL,
       created_at char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       favourites_count int(10) DEFAULT NULL,
       time_zone char(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       statuses_count int(11) DEFAULT NULL,
       lang char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       last_status char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       is_translator char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       profile_background_color char(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       profile_image_url char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       profile_background_image_url char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       profile_use_background_image char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       default_profile char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       default_profile_image char(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       Follonwer float DEFAULT NULL COMMENT 'followers/friends',
       status_created_at char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
       images int(10) DEFAULT NULL,
       links int(10) DEFAULT NULL,
       rts int(10) DEFAULT NULL,
       mentions int(10) DEFAULT NULL,
       jtweets int(10) DEFAULT NULL,
       followed int(11) DEFAULT NULL,
       wlist int(11) DEFAULT '0',
       updated int(11) DEFAULT NULL,
       followme int(11) DEFAULT NULL);";
    $dbh->exec($sql);
    echo '<div class="alert alert-success alert-dismissible fade in" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">×</span></button> <strong>Created '.$MYSQL_TABLE.' Table</strong></div>';
} catch (PDOException $e) {
    echo '<div class="alert alert-danger alert-dismissible fade in" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">×</span></button> <strong>'. $e->getMessage() .'</strong></div>';



    die();
}
