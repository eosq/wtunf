<?php
session_start();
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);

function addWhere($where, $add, $and = true)
{
    if ($where) {
        if ($and)
            $where .= " AND $add";
        else
            $where .= " OR $add";
    } else
        $where = $add;
    return $where;
}

    $where = "";
    if ($_POST["followers_count_start"]) $where = addWhere($where, "followers_count >= '".htmlspecialchars($_POST["followers_count_start"]))."'";
    if ($_POST["followers_count_end"]) $where = addWhere($where, "followers_count <= '".htmlspecialchars($_POST["followers_count_end"]))."'";
    if ($_POST["friends_count_start"]) $where = addWhere($where, "friends_count >= '".htmlspecialchars($_POST["friends_count_start"]))."'";
    if ($_POST["friends_count_end"]) $where = addWhere($where, "friends_count <= '".htmlspecialchars($_POST["friends_count_end"]))."'";
    if ($_POST["Follonwer_count_start"]) $where = addWhere($where, "Follonwer >= '".htmlspecialchars($_POST["Follonwer_count_start"]))."'";
    if ($_POST["Follonwer_count_end"]) $where = addWhere($where, "Follonwer <= '".htmlspecialchars($_POST["Follonwer_count_end"]))."'";
    if ($_POST["images_start"]) $where = addWhere($where, "images >= '".htmlspecialchars($_POST["images_start"]))."'";
    if ($_POST["images_end"]) $where = addWhere($where, "images <= '".htmlspecialchars($_POST["images_end"]))."'";
    if ($_POST["links_start"]) $where = addWhere($where, "links >= '".htmlspecialchars($_POST["links_start"]))."'";
    if ($_POST["links_end"]) $where = addWhere($where, "links <= '".htmlspecialchars($_POST["links_end"]))."'";
    if ($_POST["rts_start"]) $where = addWhere($where, "rts >= '".htmlspecialchars($_POST["rts_start"]))."'";
    if ($_POST["rts_end"]) $where = addWhere($where, "rts <= '".htmlspecialchars($_POST["rts_end"]))."'";
    if ($_POST["mentions_start"]) $where = addWhere($where, "mentions >= '".htmlspecialchars($_POST["mentions_start"]))."'";
    if ($_POST["mentions_end"]) $where = addWhere($where, "mentions <= '".htmlspecialchars($_POST["mentions_end"]))."'";
    if ($_POST["jtweets_start"]) $where = addWhere($where, "jtweets >= '".htmlspecialchars($_POST["jtweets_start"]))."'";
    if ($_POST["jtweets_end"]) $where = addWhere($where, "jtweets <= '".htmlspecialchars($_POST["jtweets_end"]))."'";
    if ($_POST["statuses_count_start"]) $where = addWhere($where, "statuses_count >= '".htmlspecialchars($_POST["statuses_count_start"]))."'";
    if ($_POST["statuses_count_end"]) $where = addWhere($where, "statuses_count <= '".htmlspecialchars($_POST["statuses_count_end"]))."'";
    if ($_POST["listed_count_start"]) $where = addWhere($where, "listed_count >= '".htmlspecialchars($_POST["listed_count_start"]))."'";
    if ($_POST["listed_count_end"]) $where = addWhere($where, "listed_count <= '".htmlspecialchars($_POST["listed_count_end"]))."'";
    if ($_POST["favourites_count_start"]) $where = addWhere($where, "favourites_count >= '".htmlspecialchars($_POST["favourites_count_start"]))."'";
    if ($_POST["favourites_count_end"]) $where = addWhere($where, "favourites_count <= '".htmlspecialchars($_POST["favourites_count_end"]))."'";
    if ($_POST["followme"]) $where = addWhere($where, "followme IN (".htmlspecialchars(implode(",", $_POST["followme"])).")");
    if ($_POST["protected"]) $where = addWhere($where, "protected IN (".htmlspecialchars(implode(",", $_POST["protected"])).")");
    if ($_POST["is_translator"]) $where = addWhere($where, "is_translator IN (".htmlspecialchars(implode(",", $_POST["is_translator"])).")");
    if ($_POST["default_profile"]) $where = addWhere($where, "default_profile IN (".htmlspecialchars(implode(",", $_POST["default_profile"])).")");
    if ($_POST["default_profile_image"]) $where = addWhere($where, "default_profile_image IN (".htmlspecialchars(implode(",", $_POST["default_profile_image"])).")");
    if ($_POST["location"]) $where = addWhere($where, "location = ''");
    if ($_POST["description"]) $where = addWhere($where, "description = ''");
    if ($_POST["display_url"]) $where = addWhere($where, "display_url = ''");
    if ($_POST["time_zone"]) $where = addWhere($where, "time_zone = ''");
    if ($_POST["location1"]) $where = addWhere($where, "location != ''");
    if ($_POST["description1"]) $where = addWhere($where, "description != ''");
    if ($_POST["display_url1"]) $where = addWhere($where, "display_url != ''");
    if ($_POST["time_zone1"]) $where = addWhere($where, "time_zone != ''");

  if ($_POST["wlist"]) $where = addWhere($where, "wlist IN (".htmlspecialchars(implode(",", $_POST["wlist"])).")");
  $query = "SELECT * FROM unfoll";
  if ($where) $query .= " WHERE $where";
  echo $query;
?>
<script>
function FormClick1 (userID) {
$.post("unfollow1.php", {user_id:userID});
}
function wlistadd (userID) {
$.post("wlistadd.php", {user_id:userID});
}
</script>
  <div style="padding-right:2%;padding-left:2%;">
    <table class="sort table-bordered table table-hover"  align="center" id="myTable">
    <thead>
    <tr>
    <td>#</td>
    <td>Image</td>
    <td>Name</td>
    <td>Followers/Following</td>
    <td>Followng</td>
    <td>Followers</td>
    <td>Tweets</td>
    <td>Lists</td>
    <td>Lang</td>
    <td>Wlist</td>
    <td>unfollow</td>
    <td>last status</td>
    <td>description</td>
    <td>display url</td>
    <td>location</td>
    <td>time zone</td>
    <td>protected</td>
    <td>favourites count</td>
    <td>is translator</td>
    <td>default profile</td>
    <td>default_profile image</td>
    <td>followme</td>
    <td>images</td>
    <td>links</td>
    <td>rts</td>
    <td>mentions</td>
    <td>jtweets</td>
    <td>user created at</td>
    <td>status created at</td>
    </tr></thead><tbody>
    <?php
$i = 1;
require_once('config.php');
$mysqli = new mysqli(MYSQL_HOST, MYSQL_LOGIN, MYSQL_PASS, MYSQL_BD);
if (mysqli_connect_errno())
  exit();
$mysqli->set_charset("utf8");

$stmt    = $mysqli->query($query);
$row_cnt = $stmt->num_rows;
echo '<h3>Найдено ' . $row_cnt . ' человек</h3>';
$tweet_texts = array();
while ($l = $stmt->fetch_assoc()) {


  echo '
      <tr id="' . $i . '">
      <td>' . ($i) . '</td>
      <td><img src="' . $l["profile_image_url"] . '"></td>
      <td >' . $l["name"] . '<br><a target="_blank" href="http://twitter.com/' . $l["screen_name"] . '">' . $l["screen_name"] . '</a><p>' . $l["user_id"] . '</p></td>
      <td>' . $l["Follonwer"] . '</td>
      <td>' . $l["friends_count"] . '</td>
      <td>' . $l["followers_count"] . '</td>
      <td>' . $l["statuses_count"] . '</td>
      <td>' . $l["listed_count"] . '</td>
      <td>' . $l["lang"] . '</td>
      <td id="myTable3">
      <button id="delet" value="Wlist"    onclick="wlistadd(\'' . $l["user_id"] . '\'); var element = document.getElementById(\'' . $i . '\'); while (element.firstChild) {  element.removeChild(element.firstChild);}" class="btn btn-success" >Wlist</button>
      </td>

      <td id="myTable2">
     <button id="input_1" value="Unfollow"    onclick="FormClick1(\'' . $l["user_id"] . '\'); var element = document.getElementById(\'' . $i . '\'); while (element.firstChild) {  element.removeChild(element.firstChild);}" class="btn btn-danger" >Unfollow</button>

     </td>
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

$mysqli->close();
echo '</tbody></table></div>';
?>

<script>var img_dir="twitteroauth2/";var sort_case_sensitive=false;function _sort(a,b){var a=a[0];var b=b[0];var _a=(a+'').replace(/,/,'.');var _b=(b+'').replace(/,/,'.');if(parseFloat(_a)&&parseFloat(_b))return sort_numbers(parseFloat(_a),parseFloat(_b));else if(!sort_case_sensitive)return sort_insensitive(a,b);else return sort_sensitive(a,b);}
function sort_numbers(a,b){return a-b;}
function sort_insensitive(a,b){var anew=a.toLowerCase();var bnew=b.toLowerCase();if(anew<bnew)return-1;if(anew>bnew)return 1;return 0;}
function sort_sensitive(a,b){if(a<b)return-1;if(a>b)return 1;return 0;}
function getConcatenedTextContent(node){var _result="";if(node==null){return _result;}
var childrens=node.childNodes;var i=0;while(i<childrens.length){var child=childrens.item(i);switch(child.nodeType){case 1:case 5:_result+=getConcatenedTextContent(child);break;case 3:case 2:case 4:_result+=child.nodeValue;break;case 6:case 7:case 8:case 9:case 10:case 11:case 12:break;}
i++;}
return _result;}
function sort(e){var el=window.event?window.event.srcElement:e.currentTarget;while(el.tagName.toLowerCase()!="td")el=el.parentNode;var a=new Array();var name=el.lastChild.nodeValue;var dad=el.parentNode;var table=dad.parentNode.parentNode;var up=table.up;var node,arrow,curcol;for(var i=0;(node=dad.getElementsByTagName("td").item(i));i++){if(node.lastChild.nodeValue==name){curcol=i;if(node.className=="curcol"){arrow=node.firstChild;table.up=Number(!up);}else{node.className="curcol";arrow=node.insertBefore(document.createElement("img"),node.firstChild);table.up=0;}
arrow.src=img_dir+table.up+".gif";arrow.alt="";}else{if(node.className=="curcol"){node.className="";if(node.firstChild)node.removeChild(node.firstChild);}}}
var tbody=table.getElementsByTagName("tbody").item(0);for(var i=0;(node=tbody.getElementsByTagName("tr").item(i));i++){a[i]=new Array();a[i][0]=getConcatenedTextContent(node.getElementsByTagName("td").item(curcol));a[i][1]=getConcatenedTextContent(node.getElementsByTagName("td").item(1));a[i][2]=getConcatenedTextContent(node.getElementsByTagName("td").item(0));a[i][3]=node;}
a.sort(_sort);if(table.up)a.reverse();for(var i=0;i<a.length;i++){tbody.appendChild(a[i][3]);}}
function init(e){if(!document.getElementsByTagName)return;for(var j=0;(thead=document.getElementsByTagName("thead").item(j));j++){var node;for(var i=0;(node=thead.getElementsByTagName("td").item(i));i++){if(node.addEventListener)node.addEventListener("click",sort,false);else if(node.attachEvent)node.attachEvent("onclick",sort);node.title="Нажмите на заголовок, чтобы отсортировать колонку";}
thead.parentNode.up=0;if(typeof(initial_sort_id)!="undefined"){td_for_event=thead.getElementsByTagName("td").item(initial_sort_id);if(document.createEvent){var evt=document.createEvent("MouseEvents");evt.initMouseEvent("click",false,false,window,1,0,0,0,0,0,0,0,0,1,td_for_event);td_for_event.dispatchEvent(evt);}else if(td_for_event.fireEvent)td_for_event.fireEvent("onclick");if(typeof(initial_sort_up)!="undefined"&&initial_sort_up){if(td_for_event.dispatchEvent)td_for_event.dispatchEvent(evt);else if(td_for_event.fireEvent)td_for_event.fireEvent("onclick");}}}}
var root=window.addEventListener||window.attachEvent?window:document.addEventListener?document:null;if(root){if(root.addEventListener)root.addEventListener("load",init,false);else if(root.attachEvent)root.attachEvent("onload",init);}
init(document.getElementById("myTable"));</script>
