  <?php 
  require 'functions/functions.php';
  use friend_finder\fetch_functions;
  if(!isset($_SESSION['f_finder_active_user'])){
    echo "<script>location.href='$base_url/index.php';</script>";
    die();
  }
  if($_GET['id']){
    $user_id = htmlspecialchars($_GET['id']);
    $user = fetch_functions\get_row('users','PRIMARY_ID',$user_id)[0];
    if($user){
      if($user->PRIMARY_ID == $_SESSION['f_finder_active_user']) $own_profile = true;
      else  $own_profile = false;
    }
    else echo "<script>location.href='broken-link.php';</script>";  
  }
  else{
    if($_SESSION['f_finder_active_user']){
      $user = fetch_functions\get_row('users','PRIMARY_ID',$_SESSION['f_finder_active_user'])[0];
      $own_profile = true;
    }
    else{
      echo "<script>location.href='$base_url/index.php';</script>";
      die();
    }
  }

  include 'partials/header.php';
  ?>

    <div class="container">

      <!-- Timeline
      ================================================= -->
      <div class="timeline">
        <div class="timeline-cover" style="background:url('images/cover-photos/<?php echo $user->COVER_PICTURE;?>') no-repeat; background-size:cover">

          <!--Timeline Menu for Large Screens-->
          <div class="timeline-nav-bar hidden-sm hidden-xs">
            <div class="row">
              <div class="col-md-3">
                <div class="profile-info">
                  <img src="images/profile-pictures/<?php echo $user->PROFILE_PICTURE;?>" alt="<?php echo $user->FIRST_NAME . " " . $user->LAST_NAME;?>" class="img-responsive profile-photo" />
                  <h3><?php echo $user->FIRST_NAME . " " . $user->LAST_NAME;?></h3>
                  <p class="text-muted"><?php echo $user->PROFESSION;?></p>
                </div>
              </div>
              <div class="col-md-9">
                <ul class="list-inline profile-menu">
                  <li><a href="timeline.php" class="active">Timeline</a></li>
                  <li><a href="about.php">About</a></li>
                  <li><a href="friends.php">Friends</a></li>
                </ul>
                <ul class="follow-me list-inline">
                  <?php 
                  $friends = $user->FRIENDS_IDS;
                  $friend_ids = explode(',', $friends);
                  $total_friend = sizeof($friend_ids);
                  echo "<li>Total Friends : $total_friend</li>";
                  if(!$own_profile && !in_array($user->PRIMARY_ID, $friend_ids)){
                    echo "<li><button class='btn-primary'>Add Friend</button></li>";
                  }
                  else{
                    if($own_profile) echo "<li><button class='btn-primary' onclick=\"location.href='edit-timeline.php';\">Edit Profile</button></li>";
                    else echo "<li><button class='btn-primary'>Unfriend</button></li>";
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div><!--Timeline Menu for Large Screens End-->

          <!--Timeline Menu for Small Screens-->
          <div class="navbar-mobile hidden-lg hidden-md">
            <div class="profile-info">
              <img src="images/profile-pictures/<?php echo $user->PROFILE_PICTURE;?>" alt="<?php echo $user->FIRST_NAME . " " . $user->LAST_NAME;?>" class="img-responsive profile-photo" />
              <h4><?php echo $user->FIRST_NAME . " " . $user->LAST_NAME;?></h4>
              <p class="text-muted"><?php echo $user->PROFESSION;?></p>
            </div>
            <div class="mobile-menu">
              <ul class="list-inline">
                <li><a href="timeline.php" class="active">Timeline</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="friends.php">Friends</a></li>
              </ul>

              <?php 
              if(!$own_profile && !in_array($user->PRIMARY_ID, $friend_ids)){
                echo "<button class='btn-primary'>Add Friend</button>";
              }
              else{
                if($own_profile) echo "<button class='btn-primary' onclick=\"location.href='edit-timeline.php';\">Edit Profile</button>";
                else echo "<button class='btn-primary'>Unfriend</button>";
              }
              ?>
            </div>
          </div><!--Timeline Menu for Small Screens End-->

        </div>
        <div id="page-contents">
          <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-7">

              <!-- Post Create Box
              ================================================= -->
              <div class="create-post">
                <form id="new-post" class="create-post" action="<?php echo $base_url;?>/functions/process-forms.php" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-7 col-sm-7">
                      <div class="form-group">
                        <img src="images/profile-pictures/<?php echo $user->PROFILE_PICTURE;?>" alt="<?php echo $user->FIRST_NAME . ' ' . $user->LAST_NAME;?>" class="profile-photo-md" />
                        <textarea name="status" id="status-textarea" cols="50" rows="1" class="form-control" placeholder="Write what you wish"></textarea>
                      </div>
                    </div>
                    <div class="col-md-5 col-sm-5">
                      <div class="tools">
                        <ul class="publishing-tools list-inline">
                          <li><a href="#"><label for="status-textarea"><i class="ion-compose"></i></label></a></li>
                          <li><a href="#"><label for="upload-images"><i class="ion-images"></i></label></a></li>
                          <li><a href="#"><label for="upload-videos"><i class="ion-ios-videocam"></i></a></label></li>
                          <input class="hidden upload-media" type="file" id="upload-images" name="upload-images[]" data-accepts="images" accept="image/*" multiple>
                          <input class="hidden upload-media" type="file" id="upload-videos" name="upload-videos[]" data-accepts="videos" accept="video/mp4,video/webm,video/ogg" multiple>
                          <input type="hidden" name="media-type" id="media-type" value="">
                        </ul>
                        <button type="submit" name="post-status" class="btn btn-primary pull-right">Publish</button>
                      </div>
                    </div>
                  </div>
                  <ul id="selected-files"></ul>
                </form>
              </div><!-- Post Create Box End-->

              <!-- Post Content
              ================================================= -->
              <div class="post-content">

                <!--Post Date-->
                <?php 
                $stmt = $con->query("SELECT * FROM posts WHERE POSTED_BY = '$user->PRIMARY_ID' ORDER BY ENTERED_AT DESC");
                $posts = $stmt->fetchAll(\PDO::FETCH_OBJ);
                foreach ($posts as $post) {
                $status = htmlspecialchars_decode(trim($post->STATUS));
                $time = fetch_functions\publish_time(strtotime($post->ENTERED_AT));
                echo "
                <div class='post-date hidden-xs hidden-sm'>
                  <h5>$user->FIRST_NAME</h5>
                  <p class='text-grey'>$time</p>
                </div><!--Post Date End-->
                ";
                
                if($post->MEDIA_TYPE > 0){
                  $medias = explode("\{}/",$post->MEDIA);
                  $num_of_medias = sizeof($medias) - 1;
                  if($post->MEDIA_TYPE == 1){
                    $media = "images/posts-images/" . $medias[1];
                    $src = "<img src='$media' alt='post-image' class='img-responsive post-image media' />";
                  }
                  else if($post->MEDIA_TYPE == 2){
                    $media = "videos/posts-videos/" . $medias[1];
                    $src = "<video src='$media' class='img-responsive post-image media' controls></video>";
                  }
                  if($num_of_medias == 1) echo $src;
                  else{
                    echo "<div class='posts-media-container'>";
                    for ($i=1; $i <= $num_of_medias; $i++) {
                        if($i <= 4){
                          if($post->MEDIA_TYPE == 1)
                            echo "<img src='images/posts-images/$medias[$i]' alt='post-image' class='img-responsive post-image media' />";
                          else if($post->MEDIA_TYPE == 2)
                            echo "<video src='videos/posts-videos/$medias[$i]' class='img-responsive post-image media' controls></video>";
                        }
                        else{
                          echo "<br><button class='all-media'>View All</button>";
                          break;
                        }
                    }
                    echo "</div>";
                    echo "<div class='clearfix'></div>";
                  }
                } // if media type = image
                
                echo "
                <div class='post-container'>
                  <img src='images/profile-pictures/$user->PROFILE_PICTURE' alt='$user->FIRST_NAME' class='profile-photo-md pull-left' />
                  <div class='post-detail'>
                    <div class='user-info'>
                      <h5><a href='timeline.php?id=$user->PRIMARY_ID' class='profile-link'>$user->FIRST_NAME $user->LAST_NAME</a></h5>
                      <p class='text-muted'>Published $time</p>
                    </div>";
                    if(!empty($status) && !is_null($status)){
                      echo "<div class='line-divider'></div>";
                    }
                    echo "
                    <div class='post-text'>
                      <p>$status</p>
                    </div>
                    ";

                    $stmt = $con->query("SELECT * FROM comments WHERE POST_ID = '$post->POST_ID' ORDER BY ENTERED_AT DESC");
                    $comments = $stmt->fetchAll(\PDO::FETCH_OBJ);
                    if(sizeof($comments) > 0){
                      echo "<div class='line-divider'></div>";
                    }
                    $i = 1;
                    foreach ($comments as $c) {
                      $el = "";
                      $commenter = fetch_functions\get_row('users','PRIMARY_ID',$c->COMMENTED_BY)[0];
                      if($i > 5) {
                         echo "
                         <div class='post-comment hidden'>
                           <img src='images/profile-pictures/$commenter->PROFILE_PICTURE' alt='$commenter->FIRST_NAME $commenter->LAST_NAME' class='profile-photo-sm' />
                           <p><a href='timeline.html' class='profile-link'>$commenter->FIRST_NAME</a> $c->COMMENT</p>
                         </div>
                         "; 
                      }
                      else{
                         echo "
                         <div class='post-comment'>
                           <img src='images/profile-pictures/$commenter->PROFILE_PICTURE' alt='$commenter->FIRST_NAME $commenter->LAST_NAME' class='profile-photo-sm' />
                           <p><a href='timeline.html' class='profile-link'>$commenter->FIRST_NAME</a> $c->COMMENT</p>
                         </div>
                         "; 
                      }
                      if($i == 6) echo "<a href='#' class='show-all-comments'>View all comments</a>";
                      $i++;
                    }
                    ?>
                  </div>
                </div>
              <?php } ?>
              
              </div>
            </div>

            <!-- 
            FOR RIGHT SIDE ACTIVITY PART
            <div class="col-md-2 static">
              <div id="sticky-sidebar">
                <h4 class="grey">Sarah's activity</h4>
                <div class="feed-item">
                  <div class="live-activity">
                    <p><a href="#" class="profile-link">Sarah</a> Commended on a Photo</p>
                    <p class="text-muted">5 mins ago</p>
                  </div>
                </div>
              </div>
            </div>
             -->
          </div>
        </div>
      </div>
    </div>

    <!-- Footer
    ================================================= -->
    <footer id="footer">
      <div class="container">
      	<div class="row">
          <div class="footer-wrapper">
            <div class="col-md-3 col-sm-3">
              <a href=""><img src="images/logo-black.png" alt="" class="footer-logo" /></a>
              <ul class="list-inline social-icons">
              	<li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-googleplus"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-pinterest"></i></a></li>
              	<li><a href="#"><i class="icon ion-social-linkedin"></i></a></li>
              </ul>
            </div>
            <div class="col-md-2 col-sm-2">
              <h5>For individuals</h5>
              <ul class="footer-links">
                <li><a href="">Signup</a></li>
                <li><a href="">login</a></li>
                <li><a href="">Explore</a></li>
                <li><a href="">Finder app</a></li>
                <li><a href="">Features</a></li>
                <li><a href="">Language settings</a></li>
              </ul>
            </div>
            <div class="col-md-2 col-sm-2">
              <h5>For businesses</h5>
              <ul class="footer-links">
                <li><a href="">Business signup</a></li>
                <li><a href="">Business login</a></li>
                <li><a href="">Benefits</a></li>
                <li><a href="">Resources</a></li>
                <li><a href="">Advertise</a></li>
                <li><a href="">Setup</a></li>
              </ul>
            </div>
            <div class="col-md-2 col-sm-2">
              <h5>About</h5>
              <ul class="footer-links">
                <li><a href="">About us</a></li>
                <li><a href="">Contact us</a></li>
                <li><a href="">Privacy Policy</a></li>
                <li><a href="">Terms</a></li>
                <li><a href="">Help</a></li>
              </ul>
            </div>
            <div class="col-md-3 col-sm-3">
              <h5>Contact Us</h5>
              <ul class="contact">
                <li><i class="icon ion-ios-telephone-outline"></i>+1 (234) 222 0754</li>
                <li><i class="icon ion-ios-email-outline"></i>info@thunder-team.com</li>
                <li><i class="icon ion-ios-location-outline"></i>228 Park Ave S NY, USA</li>
              </ul>
            </div>
          </div>
      	</div>
      </div>
      <div class="copyright">
        <p>Thunder Team © 2016. All rights reserved</p>
      </div>
		</footer>
    
    <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>

    <!-- Scripts
    ================================================= -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky-kit.min.js"></script>
    <script src="js/jquery.scrollbar.min.js"></script>
    <script src="js/script.js"></script>

  </body>
</html>
