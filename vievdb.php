<?php
session_start();
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once('config.php');
function addWhere($where, $add, $and = true)
{
    if ($where) {
        if ($and) {
            $where .= " AND $add";
        } else {
            $where .= " OR $add";
        }
    } else {
        $where = $add;
    }
    return $where;
}
try {
    $dbh = new PDO("mysql:host=$MYSQL_HOST;dbname=$MYSQL_BD;charset=utf8mb4", $MYSQL_LOGIN, $MYSQL_PASS);
    $where = "";
    if ($_POST["followers_count_start"]) {
        $where = addWhere($where, "followers_count >= ".$dbh->quote($_POST["followers_count_start"]))."";
    }
    if ($_POST["followers_count_end"]) {
        $where = addWhere($where, "followers_count <= ".$dbh->quote($_POST["followers_count_end"]))."";
    }
    if ($_POST["friends_count_start"]) {
        $where = addWhere($where, "friends_count >= ".$dbh->quote($_POST["friends_count_start"]))."";
    }
    if ($_POST["friends_count_end"]) {
        $where = addWhere($where, "friends_count <= ".$dbh->quote($_POST["friends_count_end"]))."";
    }
    if ($_POST["Follonwer_count_start"]) {
        $where = addWhere($where, "Follonwer >= ".$dbh->quote($_POST["Follonwer_count_start"]))."";
    }
    if ($_POST["Follonwer_count_end"]) {
        $where = addWhere($where, "Follonwer <= ".$dbh->quote($_POST["Follonwer_count_end"]))."";
    }
    if ($_POST["images_start"]) {
        $where = addWhere($where, "images >= ".$dbh->quote($_POST["images_start"]))."";
    }
    if ($_POST["images_end"]) {
        $where = addWhere($where, "images <= ".$dbh->quote($_POST["images_end"]))."";
    }
    if ($_POST["links_start"]) {
        $where = addWhere($where, "links >= ".$dbh->quote($_POST["links_start"]))."";
    }
    if ($_POST["links_end"]) {
        $where = addWhere($where, "links <= ".$dbh->quote($_POST["links_end"]))."";
    }
    if ($_POST["rts_start"]) {
        $where = addWhere($where, "rts >= ".$dbh->quote($_POST["rts_start"]))."";
    }
    if ($_POST["rts_end"]) {
        $where = addWhere($where, "rts <= ".$dbh->quote($_POST["rts_end"]))."";
    }
    if ($_POST["mentions_start"]) {
        $where = addWhere($where, "mentions >= ".$dbh->quote($_POST["mentions_start"]))."";
    }
    if ($_POST["mentions_end"]) {
        $where = addWhere($where, "mentions <= ".$dbh->quote($_POST["mentions_end"]))."";
    }
    if ($_POST["jtweets_start"]) {
        $where = addWhere($where, "jtweets >= ".$dbh->quote($_POST["jtweets_start"]))."";
    }
    if ($_POST["jtweets_end"]) {
        $where = addWhere($where, "jtweets <= ".$dbh->quote($_POST["jtweets_end"]))."";
    }
    if ($_POST["statuses_count_start"]) {
        $where = addWhere($where, "statuses_count >= ".$dbh->quote($_POST["statuses_count_start"]))."";
    }
    if ($_POST["statuses_count_end"]) {
        $where = addWhere($where, "statuses_count <= ".$dbh->quote($_POST["statuses_count_end"]))."";
    }
    if ($_POST["listed_count_start"]) {
        $where = addWhere($where, "listed_count >= ".$dbh->quote($_POST["listed_count_start"]))."";
    }
    if ($_POST["listed_count_end"]) {
        $where = addWhere($where, "listed_count <= ".$dbh->quote($_POST["listed_count_end"]))."";
    }
    if ($_POST["favourites_count_start"]) {
        $where = addWhere($where, "favourites_count >= ".$dbh->quote($_POST["favourites_count_start"]))."";
    }
    if ($_POST["favourites_count_end"]) {
        $where = addWhere($where, "favourites_count <= ".$dbh->quote($_POST["favourites_count_end"]))."";
    }
    if (isset($_POST["followme"])) {
        $where = addWhere($where, "followme IN (".$dbh->quote(implode(",", $_POST["followme"])).")");
    }
    if (isset($_POST["protected"])) {
        $where = addWhere($where, "protected IN (".$dbh->quote(implode(",", $_POST["protected"])).")");
    }
    if (isset($_POST["is_translator"])) {
        $where = addWhere($where, "is_translator IN (".$dbh->quote(implode(",", $_POST["is_translator"])).")");
    }
    if (isset($_POST["default_profile"])) {
        $where = addWhere($where, "default_profile IN (".$dbh->quote(implode(",", $_POST["default_profile"])).")");
    }
    if (isset($_POST["default_profile_image"])) {
        $where = addWhere($where, "default_profile_image IN (".$dbh->quote(implode(",", $_POST["default_profile_image"])).")");
    }
    if (isset($_POST["location"])) {
        $where = addWhere($where, "location = ''");
    }
    if (isset($_POST["description"])) {
        $where = addWhere($where, "description = ''");
    }
    if (isset($_POST["display_url"])) {
        $where = addWhere($where, "display_url = ''");
    }
    if (isset($_POST["time_zone"])) {
        $where = addWhere($where, "time_zone = ''");
    }
    if (isset($_POST["location1"])) {
        $where = addWhere($where, "location != ''");
    }
    if (isset($_POST["description1"])) {
        $where = addWhere($where, "description != ''");
    }
    if (isset($_POST["display_url1"])) {
        $where = addWhere($where, "display_url != ''");
    }
    if (isset($_POST["time_zone1"])) {
        $where = addWhere($where, "time_zone != ''");
    }

    if (isset($_POST["wlist"])) {
        $where = addWhere($where, "wlist IN (".$dbh->quote(implode(",", $_POST["wlist"])).")");
    }

    $query = 'SELECT * FROM '. $MYSQL_TABLE;
    if ($where) {
        $query .= " WHERE $where";
    }
    echo $query; ?>
<script>
function FormClick1 (userID) {
$.post("unfollow.php", {user_id:userID});
}
function wlistadd (userID) {
$.post("wlistadd.php", {user_id:userID});
}
function UnfMass2 (userID) {
var str = $("#Unfollow2").serialize();
$.post("unfollowmass.php",  {user_id:userID}, function(data) {
  $("#twit").html(data);
});
}
</script>

<script>
  $(function() {
     $('.table-responsive').responsiveTable();
  });
</script>
  <div style="padding-right:2%;padding-left:2%;">

    <?php
$i = 1;

    $sth=$dbh->prepare($query);
    $sth->execute();
    $count = $sth->rowCount();
    $result = $sth->fetchAll();
    echo '<h3>Find ' . $count . ' users. ';
    if ($count==0) {
        exit;
    }
    foreach ($result as $l) {
        $arrids[] = $l["user_id"];
    }
    $arrids=implode(',', $arrids);
    echo 'Unfollow all from search resultat
 <input id="Unfollow2" class="btn btn-danger btn-xs" onclick="UnfMass2(\''.$arrids.'\');
  return false;" type="button" value="Unfollow">
 </h3>';
 ?>

 <div class="table-responsive"  data-pattern="priority-columns">
<table class="tablesorter table table-small-font table-bordered table-striped" align="center" id="myTable" >
<thead>
<tr>
<th data-priority="1">#</th>
<th data-priority="1">Image</th>
<th data-priority="1">Name</th>
<th data-priority="1">Followers/Following</th>
<th data-priority="1">Followng</th>
<th data-priority="1">Followers</th>
<th data-priority="1">Tweets</th>
<th data-priority="1">Wlist</th>
<th data-priority="1">Unfollow</th>
<th data-priority="1"	>Lists</th>
<th data-priority="1"	>Lang</th>
<th data-priority="0">last status</th>
<th  data-priority="0">description</th>
<th data-priority="0"	>display url</th>
<th data-priority="0"	>location</th>
<th data-priority="0"	>time zone</th>
<th data-priority="0"	>protected</th>
<th data-priority="1"	>favourites count</th>
<th data-priority="0"	>is translator</th>
<th data-priority="0"	>default profile</th>
<th data-priority="0"	>default_profile image</th>
<th data-priority="0"	>followme</th>
<th data-priority="1"	>images</th>
<th data-priority="1"	>links</th>
<th data-priority="1"	>rts</th>
<th data-priority="1"	>mentions</th>
<th data-priority="1"	>jtweets</th>
<th data-priority="0"	>user created at</th>
<th data-priority="0"	>status created at</th>
</tr></thead><tbody> <?php
$tweet_texts = array();

    foreach ($result as $l) {
        echo '
      <tr id="' . $i . '">
      <td>' . ($i) . '</td>
      <td><img src="' . $l["profile_image_url"] . '"></td>
      <td >' . $l["name"] . '<br><a target="_blank" href="http://twitter.com/' . $l["screen_name"] . '">' . $l["screen_name"] . '</a><p>' . $l["user_id"] . '</p></td>
      <td>' . $l["Follonwer"] . '</td>
      <td>' . $l["friends_count"] . '</td>
      <td>' . $l["followers_count"] . '</td>
      <td>' . $l["statuses_count"] . '</td>
            <td id="myTable3">
      <button id="delet" value="Wlist"    onclick="wlistadd(\'' . $l["user_id"] . '\'); var element = document.getElementById(\'' . $i . '\'); while (element.firstChild) {  element.removeChild(element.firstChild);}" class="btn btn-success" >Wlist</button>
      </td>

      <td id="myTable2">
     <button id="input_1" value="Unfollow"    onclick="FormClick1(\'' . $l["user_id"] . '\'); var element = document.getElementById(\'' . $i . '\'); while (element.firstChild) {  element.removeChild(element.firstChild);}" class="btn btn-danger" >Unfollow</button>

     </td>
     <td>' . $l["listed_count"] . '</td>
     <td>' . $l["lang"] . '</td>
      <td>' . $l["last_status"] . '</td>
      <td>' . $l["description"] . '</td>
      <td><a href="' . $l["display_url"] . '">' . $l["display_url"] . '</a></td>
      <td>' . $l["location"] . '</td>
      <td>' . $l["time_zone"] . '</td>
      <td>' . $l["protected"] . '</td>
      <td>' . $l["favourites_count"] . '</td>
      <td>' . $l["is_translator"] . '</td>
      <td>' . $l["default_profile"] . '</td>
      <td>' . $l["default_profile_image"] . '</td>
      <td>' . $l["followme"] . '</td>
      <td>' . $l["images"] . '</td>
      <td>' . $l["links"] . '</td>
      <td>' . $l["rts"] . '</td>
      <td>' . $l["mentions"] . '</td>
      <td>' . $l["jtweets"] . '</td>
      <td>' . date("Ymd", strtotime($l["created_at"])) . '</td>
      <td>' . date("Ymd", strtotime($l["status_created_at"])) . '</td>
      </tr>';
        $i++;
    }


    $dbh = null;
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
echo '</tbody></table></div></div>';
?>


<script>$(document).ready(function()
    {
        $("#myTable").tablesorter();
    }
);
    </script>
