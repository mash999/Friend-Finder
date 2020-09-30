  <?php 
  require 'functions/functions.php';
  use friend_finder\fetch_functions;

  if(!isset($_SESSION['f_finder_active_user'])){
    echo "<script>location.href='$base_url/index.php';</script>";
    die();
  }
  $user = fetch_functions\get_row('users','PRIMARY_ID',$_SESSION['f_finder_active_user'])[0];
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

              <!-- Friend List
              ================================================= -->
              <div class="friend-list">
                <div class="row">
                  <?php 
                  $friends = fetch_functions\get_row('users','PRIMARY_ID',$_SESSION['f_finder_active_user'])[0];
                  $friends_ids = explode(",", $friends->FRIENDS_IDS);
                  foreach ($friends_ids as $id) {
                    $f = fetch_functions\get_row('users','PRIMARY_ID',$id)[0];
                    echo "
                    <div class='col-md-6 col-sm-6'>
                      <div class='friend-card'>
                        <img src='images/cover-photos/$f->COVER_PICTURE' alt='$f->FIRST_NAME $f->LAST_NAME - cover picture' class='img-responsive cover' />
                        <div class='card-info'>
                          <img src='images/profile-pictures/$f->PROFILE_PICTURE' alt='$f->FIRST_NAME $f->LAST_NAME - profile picture' class='profile-photo-lg' />
                          <div class='friend-info'>
                            <h5><a href='timeline.php?id=$f->PRIMARY_ID' class='profile-link'>$f->FIRST_NAME $f->LAST_NAME</a></h5>
                            <p>$f->PROFESSION</p>
                          </div>
                        </div>
                      </div>
                    </div>
                    ";
                  }
                  ?>
                </div>
              </div>
            </div>

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

    <!-- Scripts
    ================================================= -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.sticky-kit.min.js"></script>
    <script src="js/jquery.scrollbar.min.js"></script>
    <script src="js/script.js"></script>
    
  </body>
</html>
