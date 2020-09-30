<?php namespace friend_finder\process_forms;
require_once 'functions.php';
use friend_finder\fetch_functions;
use friend_finder\process_forms;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/vendor/autoload.php';




// TRIGGERS

if(isset($_POST['register-user']))
	register_user();

if(isset($_POST['user-login']))
	user_login();

if(isset($_POST['update-password']))
	update_password();

if(isset($_POST['update-timeline']))
	update_timeline();

if(isset($_POST['post-status']))
	post_status();









function register_user(){
	global $con;
	global $base_url;
	$first_name = trim(htmlspecialchars($_POST['firstname']));
	$last_name = trim(htmlspecialchars($_POST['lastname']));
	$email = trim(htmlspecialchars($_POST['email']));
	$password = htmlspecialchars($_POST['password']);
	$day = trim(htmlspecialchars($_POST['day']));
	$month = trim(htmlspecialchars($_POST['month']));
	$year = trim(htmlspecialchars($_POST['year']));
	$dob = $year . '-' . $month . '-' . $day;
	$gender = trim(htmlspecialchars($_POST['optradio']));
	$city = trim(htmlspecialchars($_POST['city']));
	$country = trim(htmlspecialchars($_POST['country']));
	
	$token = "friend_finder - " . uniqid() . uniqid();
	$user = fetch_functions\get_row('users','E_MAIL',$email)[0];
	if(sizeof($user) > 0){
		$_SESSION['f_finder_update_msg'] = "<p class='error-msg'>The email you inserted exists. Please try logging in instead</p>";
	} // user exists
	else{
		$stmt = $con->prepare("INSERT INTO users (FIRST_NAME, LAST_NAME, E_MAIL, PASSWORD, DOB, PICTURE, GENDER, CITY, COUNTRY, ACCOUNT_STATUS) VALUES (:FIRST_NAME, :LAST_NAME, :E_MAIL, :PASSWORD, :DOB, :PICTURE, :GENDER, :CITY, :COUNTRY, :ACCOUNT_STATUS)");
		$executed = $stmt->execute(array('FIRST_NAME' => $first_name, 'LAST_NAME' => $last_name, 'E_MAIL' => $email, 'PASSWORD' => hash('sha512',$password), 'DOB' => $dob, 'PROFILE_PICTURE' => 'placeholder.jpg', 'COVER_PICTURE' => 'cover-placeholder.jpg', 'GENDER' => $gender, 'CITY' => $city, 'COUNTRY' => $country, 'ACCOUNT_STATUS' => $token));
		if($executed){
			$last_inserted_id = $con->lastInsertId();
			$subject = "Registration Validation";
			$message = "<h3>Hey, $first_name $last_name</h3><p>Welcome to friend finder. Please click on the following link to verify your account</p><p><a href='$base_url/functions/verify.php?account=$email&token=$token'>VERIFY ACCOUNT</a></p>";
			$alt_body = "Hey, $first_name $lastname, Welcome to friend finder. Please follow the link to verify your account : $base_url/functions/verify.php?account=$email&token=$token";
			$set_from = "MAIL_ADDRESS_GOES_HERE";
			$emailer_name = "Friend Finder";
			$send_mail = send_email($email,$subject,$message,$alt_body,$set_from,$emailer_name,'MAIL_ADDRESS_GOES_HERE','PASSWORD_GOES_HERE');
			if($send_mail){
				$_SESSION['f_finder_update_msg'] = "<p class='success-msg'>A verification link has been sent to <b>$email</b>. Please verify your account through your e-mail.</p>";
			} // if mail is sent
			else{
				$stmt = $con->prepare("DELETE FROM users WHERE KEY_ID = :KEY_ID");
				$stmt->execute(array('KEY_ID' => $last_inserted_id));
				$_SESSION['f_finder_update_msg'] = "<p class='error-msg'>Something went wrong. Please try again later</p>";
			} // if mail sending fails
		} // if insert query executes
		else{
			$_SESSION['f_finder_update_msg'] = "<p class='error-msg'>Something went wrong. Please try again later</p>";
		} // if insert query does not execute
	} // if user does not exist in the database
	echo "<script>location.href = '$base_url/index.php';</script>";	
	die();
}









function user_login(){
	global $con;
	global $base_url;
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
	$user = fetch_functions\get_row('users','E_MAIL',$email)[0];
	if($user){
		if($user->PASSWORD == hash('sha512', $password)){
			$_SESSION['f_finder_active_user'] = $user->PRIMARY_ID;
			echo "<script>location.href='$base_url/newsfeed.php';</script>";
			die();
		}
		else
			$_SESSION['f_finder_update_msg'] = "<p class='error-msg'>The e-mail and password do not match !!</p>";
	}
	else{
		$_SESSION['f_finder_update_msg'] = "<p class='error-msg'><strong><em>$email</em></strong> does not exist. Please register first</p>";
	}
	echo "<script>location.href='$base_url/index.php?login';</script>";
	die();
}









function update_password(){
	global $con;
	global $base_url;
	$current_password = htmlspecialchars($_POST['current-password']);
	$new_password = htmlspecialchars($_POST['new-password']);
	$confirm_pass = htmlspecialchars($_POST['confirm-password']);
	$stmt = $con->prepare("SELECT PASSWORD FROM users WHERE PRIMARY_ID = :PRIMARY_ID LIMIT 1");
	$executed = $stmt->execute(array('PRIMARY_ID' => $_SESSION['f_finder_active_user']));
	if($executed){
		$password = $stmt->fetch(\PDO::FETCH_OBJ);
		$password = $password->PASSWORD;
		if($password == hash('sha512', $current_password)){
			if($new_password == $confirm_pass){
				$stmt = $con->prepare("UPDATE users SET PASSWORD = :PASSWORD WHERE PRIMARY_ID = :PRIMARY_ID");
				$executed = $stmt->execute(array('PASSWORD' => hash('sha512', $new_password) , 'PRIMARY_ID' => $_SESSION['f_finder_active_user']));
				if($executed){
					$_SESSION['f_finder_update_msg'] = "<p class='success-msg'><i class='fa fa-check-circle fa-lg'></i> &nbsp;Your password has been successfully updated.</p>";
				}
				else{
					$_SESSION['f_finder_update_msg'] = "<p class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;This is embarrasing. Something went wrong. Please try again later</p>";
				}
			}
			else{
				$_SESSION['f_finder_update_msg'] = "<p class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;The new password and confirm password fields do not match.</p>";
			}
		}
		else{
			$_SESSION['f_finder_update_msg'] = "<p class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Your current password does not match.</p>";
		}
	}
	else{
		$_SESSION['f_finder_update_msg'] = "<p class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;This is embarrasing. Something went wrong. Please try again later</p>";
	}
	echo "<script>location.href='$base_url/edit-profile-password.php';</script>";
	die();
}









function update_timeline(){
	global $con;
	global $base_url;

	$first_name = htmlspecialchars($_POST['firstname']);
	$last_name = htmlspecialchars($_POST['lastname']);
	$profession = htmlspecialchars($_POST['profession']);
	$bio = trim(htmlspecialchars($_POST['bio']));
	$month = htmlspecialchars($_POST['month']);
	$day = htmlspecialchars($_POST['day']);
	$year = htmlspecialchars($_POST['year']);
	$dob = $year . "-" . $month . "-" . $day;
	$gender = htmlspecialchars($_POST['gender']);
	$city = htmlspecialchars($_POST['city']);
	$country = htmlspecialchars($_POST['country']);

	// UPDATE PROFILE AND COVER PICTURE
	$row = fetch_functions\get_row('users','PRIMARY_ID',$_SESSION['f_finder_active_user'])[0];
	if(!empty(basename($_FILES['profile-picture']['name']))){
		$profile_picture = move_single_file('profile-picture','../images/profile-pictures/');
		if(!$profile_picture) $profile_picture = $row->PROFILE_PICTURE;		
		else{
			if($row->COVER_PICTURE != "placeholder.jpg"){
				unlink("../images/profile-pictures/$row->PROFILE_PICTURE");
			}
		}
	}
	else{
		$profile_picture = $row->PROFILE_PICTURE;
	}
	if(!empty(basename($_FILES['cover-picture']['name']))){
		$cover_picture = move_single_file('cover-picture','../images/cover-photos/');
		if(!$cover_picture) $cover_picture = $row->COVER_PICTURE;
		else{
			if($row->COVER_PICTURE != "cover-placeholder.jpg"){
				unlink("../images/cover-photos/$row->COVER_PICTURE");
			}
		}
	}
	else{
		$cover_picture = $row->COVER_PICTURE;
	}

	$stmt = $con->prepare("UPDATE users SET FIRST_NAME = :FIRST_NAME, LAST_NAME = :LAST_NAME, PROFILE_PICTURE = :PROFILE_PICTURE, COVER_PICTURE = :COVER_PICTURE, DOB = :DOB, BIO = :BIO, PROFESSION = :PROFESSION, GENDER = :GENDER, CITY = :CITY, COUNTRY = :COUNTRY WHERE PRIMARY_ID = :PRIMARY_ID");
	$executed = $stmt->execute(array('FIRST_NAME' => $first_name, 'LAST_NAME' => $last_name, 'PROFILE_PICTURE' => $profile_picture, 'COVER_PICTURE' => $cover_picture, 'DOB' => $dob, 'BIO' => $bio, 'PROFESSION' => $profession, 'GENDER' => $gender, 'CITY' => $city, 'COUNTRY' => $country, 'PRIMARY_ID' => $_SESSION['f_finder_active_user']));

	echo "<script>location.href='$base_url/about.php';</script>";
	die();
}









function post_status(){
	global $con;
	global $base_url;
	$status = htmlspecialchars(nl2br($_POST['status']));
	$type = htmlspecialchars($_POST['media-type']);
	$cancelled_file_list = $_POST['cancelled-file-list'];
	$media = null;
	if(!empty($type)){
		$media = "";
		if($type == 1){ $name = "upload-images"; $dir = "../images/posts-images/"; }
		else if ($type == 2){ $name = "upload-videos"; $dir = "../videos/posts-videos/"; }
		$total = count($_FILES[$name]['name']);
		for($i = 0; $i < $total; $i++) {
			$base_name = basename($_FILES[$name]['name'][$i]);
			if(!$cancelled_file_list || !in_array($base_name, $cancelled_file_list)){
				$file_name = move_file($name,$base_name,$i,$dir);
				if($file_name){
					$media .= "\{}/" . $file_name;
				} // if end
			} // if base_name not in cancelled_file_list
		} // for end
	} // if empty($type) end


	$stmt = $con->prepare("INSERT INTO posts (STATUS,MEDIA_TYPE,MEDIA,POSTED_BY) VALUES (:STATUS,:MEDIA_TYPE,:MEDIA,:POSTED_BY)");
	$executed = $stmt->execute(array('STATUS' => $status, 'MEDIA_TYPE' => $type, 'MEDIA' => $media, 'POSTED_BY' => $_SESSION['f_finder_active_user']));
	if($executed) echo "<script>location.href='$base_url/newsfeed.php';</script>";
	else $_SESSION['f_finder_update_msg'] = "<p class='error-msg'>Something went wrong. Please try again later.</p>";
	die();
}









function move_file($name,$file_name,$index,$temp_dir){
	$file_name = uniqid() . $file_name;
	$target_file = $temp_dir . $file_name;
    if (move_uploaded_file($_FILES[$name]["tmp_name"][$index], $target_file))  return $file_name;    	
	else return false;
}









function move_single_file($name,$temp_dir){
	$file_name = uniqid() . basename($_FILES[$name]['name']);
	$target_file = $temp_dir . $file_name;
    if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file))  return $file_name;    	
	else return false;
}









function send_email($to,$subject,$message,$alt_body,$set_from,$emailer_name,$user_email,$passcode){
    global $con;
    global $base_url;
    $mail = new PHPMailer(true);        
    
    $template = "    
    <html>
    <head>
	    <style>
	    h3 { color: #333; font-family: arial,sans-serif; font-size: 20px; margin-top: 25px; margin-bottom: 0px; } 
	    p { color: #333; font-family: arial,sans-serif; font-size: 15px; line-height: 20px; }
	    .header img { width: 200px; }
	    a { color: #204d74; font-family: arial,sans-serif; font-size: 15px; text-decoration: none; }
	    .body { width:500px; height: auto; box-sizing: border-box; padding: 20px 30px; border: 1px solid #ccc; margin: auto; }
	    .content { width : 100%; }
	    .header { text-align: center; }
	    .header h1 { color: #333; font-family:arial,sans-serif; font-size: 22px; margin: 0px; border-bottom: 1px solid #ccc; padding-bottom: 20px; }
		.footer p { color: #333; font-family: arial,sans-serif; font-size: 15px; line-height:20px; padding:0; margin:0; }
	    </style>
	</head>
    <body>
    <div class='body'>
    	<div class='content'>
    		<div class='header'>
    			<img src='$base_url/images/logo-black.png' alt='Friend Finder'>
    			<h1>Friend Finder</h1>
    		</div>
    		$message
    	</div>
    	<p>Thank you<br>Friend Finder</p>
    </div>
    </body>
    </html>";


    try {
        $mail->SMTPDebug = 0; 
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // mail host address
        $mail->SMTPAuth = true;                
        $mail->Username = "mashbu111@gmail.com";  // $user_email      
        $mail->Password = "FormosaQQTea";                          
        $mail->SMTPSecure = 'tsl';                           
        $mail->Port = 587;
        $mail->setFrom("mashbu111@gmail.com", $emailer_name); // $set_from
        $mail->addAddress($to);  

        $mail->isHTML(true);                                 
        $mail->Subject = $subject;
        $mail->Body    = $template;
        $mail->AltBody = $alt_body;
        $mail->send();
		return true;
    } catch (Exception $e) {
        return false;
    }
}