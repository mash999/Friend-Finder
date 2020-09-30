<?php
require_once 'functions.php';
use magazine\fetch_functions;
if(isset($_GET['token']) && isset($_GET['account'])){
	global $con;
	$email = htmlspecialchars($_GET['account']);
	$token = htmlspecialchars($_GET['token']);
	$account_info = fetch_functions\get_row('users','USER_EMAIL',$email)[0];
	if($account_info->USER_ACCOUNT_STATUS == $token && $token != 'verified'){
		$stmt = $con->prepare("UPDATE users SET USER_ACCOUNT_STATUS = :ACCOUNT_STATUS WHERE USER_EMAIL = :USER_EMAIL AND USER_ACCOUNT_STATUS = :USER_ACCOUNT_STATUS");
		$executed = $stmt->execute(array('ACCOUNT_STATUS' => 'verified', 'USER_EMAIL' => $email, 'USER_ACCOUNT_STATUS' => $token));
		if($executed){
			$_SESSION['msg'] = "<i class='fa fa-check-circle fa-lg'></i> &nbsp;Great!!! Your account is now verified. Let's get started";
			$_SESSION['active_user_id'] = $account_info->USER_ID;
			$_SESSION['active_user_email'] = $account_info->USER_EMAIL;
			$_SESSION['active_user_access_level'] = $account_info->USER_ACCESS_LEVEL;
			$_SESSION['active_user_name'] = $account_info->USER_NAME;
			echo "<script>location.href = '$base_url'; </script>";
		}
	}
	else{
		echo "<h2 style='font-family:arial;margin-top:20px;'>Document Expired</h2>";
	}
}





if(isset($_GET['subscription'])){
	global $con;
	$subscriber_id = htmlspecialchars($_GET['subscriber']);
	$token = htmlspecialchars($_GET['token']);
	$subscriber = fetch_functions\get_row('subscribers','TABLE_ID',$subscriber_id)[0];
	if(!$subscriber || $subscriber->SUBSCRIBER_STATUS == 'verified'){
		echo "<h2 style='font-family:arial;margin-top:20px;'>Document Expired</h2>";
	}
	else{
		$stmt = $con->prepare("UPDATE subscribers SET SUBSCRIBER_STATUS = :NEW_SUBSCRIBER_STATUS WHERE SUBSCRIBER_STATUS = :SUBSCRIBER_STATUS AND TABLE_ID = :TABLE_ID");
		$executed = $stmt->execute(array('NEW_SUBSCRIBER_STATUS' => 'verified', 'SUBSCRIBER_STATUS' => $token, 'TABLE_ID' => $subscriber_id));
		$_SESSION['subscriber_id'] = $subscriber_id;
		echo "<script>location.href = '$base_url/subscribe/preference-center/update?user=$subscriber_id&updatability=0';</script>";	
	}
	die();
}
?>