<?php
   session_start();
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Twitter - Who to unfollow</title>
      <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
      <link rel="stylesheet" href="style/css/bootstrap.css">
      <link href="style/css/cover.css" rel="stylesheet">
      <script src="style/js/jquery.min.js"></script>
      <script src="style/js/bootstrap.min.js"></script>
      <link href="https://abs.twimg.com/favicons/favicon.ico" rel="icon" type="image/x-icon">
      <script>
         function FormClick () {
           var str = $("#twi").serialize();
           $.post("vievdb1.php", str, function(data) {
             $("#twit").html(data);
           });
         }
         function UpdateDb () {
         var str = $("#db").serialize();
         $.post("getdb.php", str, function(data) {
           $("#twit").html(data);
         });
         }
         function UpdateTweets () {
         var str = $("#tweetinf").serialize();
         $.post("tweetsinfo.php", str, function(data) {
           $("#twit").html(data);
         });
         }
      </script>
   </head>
   <body>
      <div class="container">
         <div class="header">
            <ul class="nav nav-pills pull-right">
               <li class="active">  <a href="/wtunf">wtunf</a></li>

            </ul>
            <h3 class="text-muted"><a href="/">Dexwe</a></h3>
         </div>
         <div  class="col-md-12">
            <ul class="nav nav-pills">
               <li><input id="db" class="btn btn-default btn-lg" onclick="UpdateDb(); return false;" type="button" value="Update DB"></li>
               <li><input id="tweetinf" class="btn btn-default btn-lg" onclick="UpdateTweets(); return false;" type="button" value="Update Tweets"> </li>
            </ul>
            <br />
         </div>
         <div  class=" col-md-12"></div>
         <div  class="well col-md-12">
            <form class="form-inline" id="twi" role="form">
               <div class="form-group col-md-6">
                  <p> Followers:</p>
                  <input type="text" class="form-control" name="followers_count_start" />
                  -
                  <input type="text" class="form-control" name="followers_count_end" /><br />
               </div>
               <div class="form-group col-md-6">
                  <p>   Friends:</p>
                  <input type="text" class="form-control" name="friends_count_start" />
                  -
                  <input type="text" class="form-control" name="friends_count_end" /><br />
               </div>
               <div class="form-group col-md-6">
                  <p> Follonwer</p>
                  <input type="text" class="form-control" name="Follonwer_count_start" />
                  -
                  <input type="text" class="form-control" name="Follonwer_count_end" /><br />
               </div>
               <div class="form-group col-md-6">
                  <p>   Tweets:</p>
                  <input type="text" class="form-control" name="statuses_count_start" />
                  -
                  <input type="text" class="form-control" name="statuses_count_end" /><br />
               </div>
               <div class="form-group col-md-6">
                  <p>   Lists:</p>
                  <input type="text" class="form-control" name="listed_count_start" />
                  -
                  <input type="text" class="form-control" name="listed_count_end" /><br />
               </div>
               <div class="form-group col-md-6">
                  <p> Likes:</p>
                  <input type="text" class="form-control" name="favourites_count_start" />
                  -
                  <input type="text" class="form-control" name="favourites_count_end" /><br />
               </div>
               <div class="form-group col-md-6">
                  <p> images in 200:</p>
                  <input type="text" class="form-control" name="images_start" />
                  -
                  <input type="text" class="form-control" name="images_end" /><br />
               </div>
               <div class="form-group col-md-6">
                  <p> links in 200:</p>
                  <input type="text" class="form-control" name="links_start" />
                  -
                  <input type="text" class="form-control" name="links_end" /><br />
               </div>
               <div class="form-group col-md-6">
                  <p> rts in 200:</p>
                  <input type="text" class="form-control" name="rts_start" />
                  -
                  <input type="text" class="form-control" name="rts_end" /><br />
               </div>
               <div class="form-group col-md-6">
                  <p> mentions in 200:</p>
                  <input type="text" class="form-control" name="mentions_start" />
                  -
                  <input type="text" class="form-control" name="mentions_end" /><br />
               </div>
               <div class="form-group col-md-6">
                  <p> text in 200:</p>
                  <input type="text" class="form-control" name="jtweets_start" />
                  -
                  <input type="text" class="form-control" name="jtweets_end" /><br />
               </div>
               <div class="form-group col-md-12">
                  <div class="form-group col-md-3">
                     <p>Follow me?
                     <p>
                        Yes         <input type="checkbox" name="followme[]" value="1" />
                        No <input type="checkbox" name="followme[]" value="0" /><br>
                  </div>
                  <div class="form-group col-md-3">
                     <p>Is translator?
                     <p>
                        Yes         <input type="checkbox" name="is_translator[]" value="1" />
                        No<input type="checkbox" name="is_translator[]" value="0" /><br>
                  </div>
                  <div class="form-group col-md-3">
                     <p>Default profile?
                     <p>
                        Yes         <input type="checkbox" name="default_profile[]" value="1" />
                        No<input type="checkbox" name="default_profile[]" value="0" /><br>
                  </div>
                  <div class="form-group col-md-3">
                     <p>Default profile image?
                     <p>
                        Yes         <input type="checkbox" name="default_profile_image[]" value="1" />
                        No <input type="checkbox" name="default_profile_image[]" value="0" /><br>
                  </div>
               </div>
               <div class="form-group col-md-12">
                  <div class="form-group col-md-3">
                     <p>Protected?
                     <p>
                        Yes     <input type="checkbox" name="protected[]" value="1" />
                        No<input type="checkbox" name="protected[]" value="0" /><br>
                  </div>
                  <div class="form-group col-md-3">
                     <p>Location</p>
                     Yes <input type="checkbox" name="location1" />
                     No   <input type="checkbox" name="location" /></br>
                  </div>
                  <div class="form-group col-md-3">
                     <p>Description</p>
                     Yes <input type="checkbox" name="description1" />
                     No   <input type="checkbox" name="description" /></br>
                  </div>
                  <div class="form-group col-md-3">
                     <p>Display url</p>
                     Yes  <input type="checkbox" name="display_url1" />
                     No   <input type="checkbox" name="display_url" /></br>
                  </div>
               </div>
               <div class="form-group col-md-12">
                  <div class="form-group col-md-3">
                     <p>Time zone</p>
                     Yes   <input type="checkbox" name="time_zone1" />
                     No   <input type="checkbox" name="time_zone" /></br>
                  </div>
                  <div class="form-group col-md-3">
                     <p>White list</p>
                     Yes <input type="checkbox" name="wlist[]" value="1" />
                     No <input type="checkbox" name="wlist[]" value="0" /><br>
                  </div>
               </div>
               <div class="form-group col-md-12">
                  <input class="btn btn-primary btn-lg" onclick="FormClick(); return false;" type="button" value="Look">
               </div>
            </form>
         </div>
         <br />
      </div>
      </div>
      <div  id="twit">
      </div>
   </body>
</html>
