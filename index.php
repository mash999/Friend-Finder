  <?php 
  require 'functions/functions.php';
  use friend_finder\fetch_functions;
  if(isset($_SESSION['f_finder_active_user'])){
    echo "<script>location.href='$base_url/newsfeed.php';</script>";
    die();
  }
  if(isset($_GET['login'])) $start_with = "login";
  else $start_with = "registrations";
  include 'partials/header.php';
  ?>
    
    <!-- Landing Page Contents
    ================================================= -->
    <div id="lp-register">
    	<div class="container wrapper">
        <div class="row">
        	<div class="col-sm-5">
            <div class="intro-texts">
            	<h1 class="text-white">Make Cool Friends !!!</h1>
            	<p>Friend Finder is a social network template that can be used to connect people. The template offers Landing pages, News Feed, Image/Video Feed, Chat Box, Timeline and lot more. <br /> <br />Why are you waiting for? Buy it now.</p>
              <button class="btn btn-primary">Learn More</button>
            </div>
          </div>
        	<div class="col-sm-6 col-sm-offset-1">
            <div class="reg-form-container"> 
            
              <!-- Register/Login Tabs-->
              <div class="reg-options">
                <ul class="nav nav-tabs">
                  <?php 
                  if($start_with == "registrations") echo "<li class='active'><a href='#register' data-toggle='tab'>Register</a></li>";
                  else echo "<li><a href='#register' data-toggle='tab'>Register</a></li>";
                  if($start_with == "login") echo "<li class='active'><a href='#login' data-toggle='tab'>Login</a></li>";
                  else echo "<li><a href='#login' data-toggle='tab'>Login</a></li>";
                  ?>
                </ul><!--Tabs End-->
              </div>
              
              <!--Registration Form Contents-->
              <div class="tab-content">
                <?php 
                  if(isset($_SESSION['f_finder_update_msg']) && !empty($_SESSION['f_finder_update_msg'])){
                    echo $_SESSION['f_finder_update_msg'];
                    $_SESSION['f_finder_update_msg'] = "";
                  }
                ?>
                
                <?php 
                  if($start_with == "registrations") echo "<div class='tab-pane active' id='register'>";
                  else echo "<div class='tab-pane' id='register'>";
                  ?>
                  <h3>Register Now !!!</h3>
                  <p class="text-muted">Be cool and join today. Meet millions</p>
                  
                  <!--Register Form-->
                  <form action="<?php echo $base_url;?>/functions/process-forms.php" method="post" name="registration_form" id='registration_form' class="form-inline">
                    <div class="row">
                      <div class="form-group col-xs-6">
                        <label for="firstname" class="sr-only">First Name</label>
                        <input id="firstname" class="form-control input-group-lg" type="text" name="firstname" title="Enter first name" placeholder="First name" required />
                      </div>
                      <div class="form-group col-xs-6">
                        <label for="lastname" class="sr-only">Last Name</label>
                        <input id="lastname" class="form-control input-group-lg" type="text" name="lastname" title="Enter last name" placeholder="Last name" required />
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="email" class="sr-only">Email</label>
                        <input id="email" class="form-control input-group-lg" type="text" name="email" title="Enter Email" placeholder="Your Email" required />
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" class="form-control input-group-lg" type="password" name="password" title="Enter password" placeholder="Password" required />
                      </div>
                    </div>
                    <div class="row">
                      <p class="birth"><strong>Date of Birth</strong></p>
                      <div class="form-group col-sm-3 col-xs-6">
                        <label for="month" class="sr-only"></label>
                        <select name="day" class="form-control" id="day" required>
                          <option value="" disabled selected>Day</option>
                          <?php for($i = 1; $i <= 31; $i++) echo "<option value='$i'>$i</option>"; ?>
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
                            echo "<option value='$i'>$m</option>";
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
                            echo "<option value = '$i'>$i</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group gender">
                      <label class="radio-inline">
                        <input type="radio" name="optradio" value="Male" checked>Male
                      </label>
                      <label class="radio-inline">
                        <input type="radio" name="optradio" value="Female">Female
                      </label>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-6">
                        <label for="city" class="sr-only">City</label>
                        <input id="city" name="city" class="form-control input-group-lg reg_name" type="text" name="city" title="Enter city" placeholder="Your city"/>
                      </div>
                      <div class="form-group col-xs-6">
                        <label for="country" class="sr-only"></label>
                        <select name="country" class="form-control" id="country">
                          <option value="country" disabled selected>Country</option>
                          <?php 
                          $countries = fetch_functions\get_rows('countries');
                          foreach ($countries as $c) {
                              echo "<option value='$c->COUNTRY_CODE'>$c->COUNTRY_NAME</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                    <p><a href="#">Already have an account?</a></p>
                    <button type="submit" class="btn btn-primary" name="register-user">Register Now</button>
                  </form><!--Register Now Form Ends-->
                </div><!--Registration Form Contents Ends-->
                
                <!--Login-->
                <?php
                if($start_with == "login") echo "<div class='tab-pane active' id='login'>";
                else echo "<div class='tab-pane' id='login'>";
                ?>
                  <h3>Login</h3>
                  <p class="text-muted">Log into your account</p>
                  
                  <!--Login Form-->
                  <form action="<?php echo $base_url;?>/functions/process-forms.php" method="post" name="Login_form" id='Login_form'>
                     <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="my-email" class="sr-only">Email</label>
                        <input id="my-email" class="form-control input-group-lg" type="text" name="email" title="Enter Email" placeholder="Your Email" required />
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-xs-12">
                        <label for="my-password" class="sr-only">Password</label>
                        <input id="my-password" class="form-control input-group-lg" type="password" name="password" title="Enter password" placeholder="Password" required />
                      </div>
                    </div>
                    <p><a href="#">Forgot Password?</a></p>
                    <button type="submit" class="btn btn-primary" name="user-login">Login Now</button>
                  </form><!--Login Form Ends--> 
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6 col-sm-offset-6">
          
            <!--Social Icons-->
            <ul class="list-inline social-icons">
              <li><a href="#"><i class="icon ion-social-facebook"></i></a></li>
              <li><a href="#"><i class="icon ion-social-twitter"></i></a></li>
              <li><a href="#"><i class="icon ion-social-googleplus"></i></a></li>
              <li><a href="#"><i class="icon ion-social-pinterest"></i></a></li>
              <li><a href="#"><i class="icon ion-social-linkedin"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!--preloader-->
    <div id="spinner-wrapper">
      <div class="spinner"></div>
    </div>

    <!-- Scripts
    ================================================= -->
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.appear.min.js"></script>
		<script src="js/jquery.incremental-counter.js"></script>
    <script src="js/script.js"></script>
    
	</body>
</html>
