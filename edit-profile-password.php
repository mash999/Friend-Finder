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
        <div class="timeline-cover" style="background: url('<?php echo "images/cover-photos/$user->COVER_PICTURE";?>')">

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
                  <li><a href="timeline.php">Timeline</a></li>
                  <li><a href="about.php" class="active">About</a></li>
                  <li><a href="friends.php">Friends</a></li>
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
                  <li><a href="timeline.php">Timeline</a></li>
                  <li><a href="about.php" class="active">About</a></li>
                  <li><a href="friends.php">Friends</a></li>
              </ul>
            </div>
          </div><!--Timeline Menu for Small Screens End-->

        </div>
        <div id="page-contents">
          <div class="row">
            <div class="col-md-3">
              
              <!--Edit Profile Menu-->
              <ul class="edit-menu">
                <li><i class="icon ion-ios-information-outline"></i><a href="edit-timeline.php">About</a></li>
                <li class="active"><i class="icon ion-ios-locked-outline"></i><a href="edit-profile-password.php">Change Password</a></li>
              </ul>
            </div>
            <div class="col-md-7">

              <!-- Password Information
              ================================================= -->
              <div class="edit-profile-container">
                <div class="block-title">
                  <h4 class="grey"><i class="icon ion-android-checkmark-circle"></i>Update Password</h4>
                  <div class="line"></div>
                  <p>Fill up the following fields and press save.</p>
                  <?php 
                  if(isset($_SESSION['f_finder_update_msg']) && !empty($_SESSION['f_finder_update_msg'])){ 
                    echo "<br>" . $_SESSION['f_finder_update_msg'] . "<br>";
                    $_SESSION['f_finder_update_msg'] = "";
                  }
                  ?>
                  <div class="line"></div>
                </div>
                <div class="edit-block">
                  <form action="<?php echo $base_url;?>/functions/process-forms.php" method="post"  name="basic-info" id="password-info" class="form-inline">

                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="my-password">Old password</label>
                        <input id="my-password" class="form-control input-group-lg" type="password" name="current-password" title="Current password" placeholder="Current password"/>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-6">
                        <label>New password</label>
                        <input class="form-control input-group-lg" type="password" name="new-password" title="New password" placeholder="New password"/>
                      </div>
                      <div class="form-group col-xs-6">
                        <label>Confirm password</label>
                        <input class="form-control input-group-lg" type="password" name="confirm-password" title="Confirm password" placeholder="Confirm password"/>
                      </div>
                    </div>
                    <p><a href="#">Forgot Password?</a></p>
                    <button type="submit" name="update-password" class="btn btn-primary">Save Password</button>
                  </form>
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
