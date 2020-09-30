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
        <form action="<?php echo $base_url;?>/functions/process-forms.php" method="post" enctype="multipart/form-data" name="basic-info" id="basic-info" class="form-inline">
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
              	<li class="active"><i class="icon ion-ios-information-outline"></i><a href="edit-timeline.php">About</a></li>
              	<li><i class="icon ion-ios-locked-outline"></i><a href="edit-profile-password.php">Change Password</a></li>
              </ul>
            </div>
            <div class="col-md-6">

              <!-- Basic Information
              ================================================= -->
              <div class="edit-profile-container">
                <div class="block-title">
                  <h4 class="grey"><i class="icon ion-android-checkmark-circle"></i>Edit basic information</h4>
                  <div class="line"></div>
                  <p>Fill up the following fields and press save. Your basic informations are public</p>
                  <div class="line"></div>
                </div>
                <div class="edit-block">
                    <div class="row">
                      <div class="form-group col-xs-6">
                        <label for="firstname">First name</label>
                        <input id="firstname" class="form-control input-group-lg" type="text" name="firstname" title="Enter first name" placeholder="First name" value="<?php echo $user->FIRST_NAME;?>" />
                      </div>
                      <div class="form-group col-xs-6">
                        <label for="lastname" class="">Last name</label>
                        <input id="lastname" class="form-control input-group-lg" type="text" name="lastname" title="Enter last name" placeholder="Last name" value="<?php echo $user->LAST_NAME;?>" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="profession">My profession</label>
                        <input id="profession" class="form-control input-group-lg" type="text" name="profession" title="Enter Profession" placeholder="My Profession" value="<?php echo $user->PROFESSION;?>" />
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="email">My email</label>
                        <input id="email" class="form-control input-group-lg" type="text" title="Enter Email" placeholder="My Email" value="<?php echo $user->E_MAIL;?>" readonly />
                      </div>
                    </div>
                    <div class="row">
                      <p class="custom-label"><strong>Date of Birth</strong></p>
                      <div class="form-group col-sm-3 col-xs-6">
                        <label for="month" class="sr-only"></label>
                        <select name="day" class="form-control" id="day" required>
                          <option value="" disabled>Day</option>
                          <?php 
                            for($i = 1; $i <= 31; $i++){ 
                              if($i == explode("-", $user->DOB)[2]){
                                echo "<option value='$i' selected>$i</option>"; 
                              }
                              else{
                                echo "<option value='$i'>$i</option>"; 
                              }
                            }
                            ?>
                        </select>
                      </div>
                      <div class="form-group col-sm-3 col-xs-6">
                        <label for="month" class="sr-only"></label>
                        <select name="month" class="form-control" id="month" required>
                          <option value="" disabled selected>Month</option>
                          <?php 
                          $i = 1;
                          $months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
                          foreach ($months as $m) {
                            if($i == explode("-", $user->DOB)[1]){
                              echo "<option value='$i' selected>$m</option>"; 
                            }
                            else{
                              echo "<option value='$i'>$m</option>"; 
                            }
                            $i++;
                          }
                          ?>
                        </select>
                      </div>
                      <div class="form-group col-sm-6 col-xs-12">
                        <label for="year" class="sr-only"></label>
                        <select name="year" class="form-control" id="year" required>
                          <option value="" disabled selected>Year</option>
                          <?php 
                          $starting_year = 1930;
                          $end_year = date("Y") - 18;
                          for($i = $end_year; $i >= $starting_year; $i--){
                            if($i == explode("-", $user->DOB)[0])
                              echo "<option value='$i' selected>$i</option>"; 
                            else
                              echo "<option value='$i'>$i</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group gender">
                      <span class="custom-label"><strong>I am a: </strong></span>
                      <label class="radio-inline">
                        <?php 
                        if($user->GENDER == "Male") echo "<input type='radio' name='gender' value='Male' checked>Male";
                        else echo "<input type='radio' value='Male' name='gender'>Male";
                        ?>
                      </label>
                      <label class="radio-inline">
                        <?php 
                        if($user->GENDER == "Female") echo "<input type='radio' name='gender' value='Female' checked>Female";
                        else echo "<input type='radio' name='gender' value='Female'>Female";
                        ?>
                      </label>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-6">
                        <label for="city"> My city</label>
                        <input id="city" class="form-control input-group-lg" type="text" name="city" title="Enter city" placeholder="Your city" value="<?php echo $user->CITY;?>"/>
                      </div>
                      <div class="form-group col-xs-6">
                        <label for="country">My country</label>
                        <select name="country" class="form-control" id="country">
                          <?php 
                          $countries = fetch_functions\get_rows('countries');
                          foreach ($countries as $c) {
                            if(trim($c->COUNTRY_CODE) == $user->COUNTRY) 
                              echo "<option value='$c->COUNTRY_CODE' selected>$c->COUNTRY_NAME</option>";
                            else
                              echo "<option value='$c->COUNTRY_CODE'>$c->COUNTRY_NAME</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="my-info">About me</label>
                        <textarea id="my-info" name="bio" class="form-control" placeholder="Some texts about me" rows="4" cols="400"><?php echo $user->BIO;?></textarea>
                      </div>
                    </div>
                    <button type="submit" name="update-timeline" class="btn btn-primary">Save Changes</button>
                </div>
              </div>
            </div>

            <div class="col-md-3 static">
              <div id="sticky-sidebar">
                <h4 class="grey"><i class="fa fa-camera"></i> &nbsp; Upload Images</h4>
                <div class="feed-item">
                  <div class="live-activity">
                    <div class="edit-picture-container">
                      <h4>Profile Picture</h4>
                      <div class="edit-picture">
                        <label for="edit-profile-picture" class="edit-picture-layout">
                          <i class="fa fa-camera"></i>
                        </label>
                        <img id="profile-picture-frame" src="images/profile-pictures/<?php echo $user->PROFILE_PICTURE;?>" alt="<?php echo $user->FIRST_NAME . ' ' .$suer->LAST_NAME;?>">
                        <input type="file" name="profile-picture" id="edit-profile-picture" class="hidden">
                      </div>
                    </div>

                    <div class="edit-picture-container">
                      <h4>Cover Photo</h4>
                      <div class="edit-picture">
                        <label for="edit-cover-picture" class="edit-picture-layout">
                          <i class="fa fa-camera"></i>
                        </label>
                        <img id="cover-picture-frame" src="images/cover-photos/<?php echo $user->COVER_PICTURE;?>" alt="<?php echo $user->FIRST_NAME . ' ' .$suer->LAST_NAME;?>">
                        <input type="file" name="cover-picture" id="edit-cover-picture" class="hidden">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        </form>
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
