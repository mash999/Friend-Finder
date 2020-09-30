<?php namespace friend_finder\fetch_functions;
error_reporting(0);
use friend_finder\fetch_functions;
session_start();
$base_url= "http://localhost:8080/projects/friendfinder";
$site_name = "Friend Finder";

try{
	$con = new \PDO('mysql:host=localhost;dbname=friend_finder','root','');
	$con->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
	return $con;
}

catch(\PDOException $e){
	echo "ERROR : " . $e->getMessage();
	return false;
}









function get_row($table,$param,$paramVal){
	global $con;
	$stmt = $con->prepare("SELECT * FROM $table WHERE $param=:paramVal");
	$stmt->bindParam(':paramVal',$paramVal);
	$stmt->execute();
	$row = $stmt->fetchAll(\PDO::FETCH_OBJ);
	return $row;
}









function get_rows($table){
	global $con;
	$stmt = $con->prepare("SELECT * FROM $table");
	$stmt->execute();
	$rows = $stmt->fetchAll(\PDO::FETCH_OBJ);
	return $rows;
}









function get_limited_rows($table,$param,$sort,$limit){
	global $con;
	if(strtoupper($sort)=="DESC"){
		$stmt = $con->prepare("SELECT * FROM $table ORDER BY $param DESC LIMIT $limit");
	}
	else{
		$stmt = $con->prepare("SELECT * FROM $table ORDER BY $param ASC LIMIT $limit");
	}
	$stmt->execute();
	$rows = $stmt->fetchAll(\PDO::FETCH_OBJ);
	return $rows;
}









function get_distinct_rows($table,$param){
	global $con;
	$stmt = $con->prepare("SELECT distinct $param FROM $table");
	$stmt->execute();
	$row = $stmt->fetchAll(\PDO::FETCH_OBJ);
	return $row;
}









function get_link_info($url){
	if($page = file_get_contents($url)){
		$title_end = explode("</title>", $page)[0];
		$title = explode("<title>", $title_end)[1];
		return "<h4>$title</h4><p>$url</p>";	
	}
	else{
		return "<h4>Invalid URL. No such link found</h4>";
	}
}









function publish_time($publish_time){
	$time_diff = abs(time() - $publish_time);
	$year = $time_diff/60/60/24/30/12;
	$month = $time_diff/60/60/24/30;
	$day = $time_diff/60/60/24;
	$hour = $time_diff/60/60;
	$min = $time_diff/60;
	if($year < 1){
		if($month < 1){
			if($day < 1){
				if($hour < 1){
					if($min < 1){
						$time = "Just Now";
					}
					else{
						$time = floor($min);
						if($time == 1) $time = $time . " minute ago";
						else  $time = $time . " minutes ago";
					}
				}
				else{
					$time = floor($hour);
					if($time == 1) $time = $time . " hour ago";
					else  $time = $time . " hours ago";
				}
			}
			else{
				$time = floor($day);
				if($time == 1) $time = $time . " day ago";
				else if($time > 1 && $time < 8) $time = $time . " days ago";
				else  $time = date("d M, Y",$publish_time);
			}
		}
		else{
			$time = date("d M, Y",$publish_time);
		}
	}
	else{
		$time = date("d M, Y",$publish_time);
	}

	return $time;
}







function get_link_data($url){
	if($page = file_get_contents($url)){
		$title_end = explode("</title>", $page)[0];
		$title = explode("<title>", $title_end)[1];
		return "<h4>$title</h4>";	
	}
	else{
		return "<h4>Invalid URL. No such link found</h4>";
	}
}









function get_countries(){
	$country_list = array("Afghanistan", "Aland Islands", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Barbuda", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Trty.", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Caicos Islands", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "French Guiana", "French Polynesia", "French Southern Territories", "Futuna Islands", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guernsey", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard", "Herzegovina", "Holy See", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Isle of Man", "Israel", "Italy", "Jamaica", "Jan Mayen Islands", "Japan", "Jersey", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea", "Korea (Democratic)", "Kuwait", "Kyrgyzstan", "Lao", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao", "Macedonia", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "McDonald Islands", "Mexico", "Micronesia", "Miquelon", "Moldova", "Monaco", "Mongolia", "Montenegro", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "Nevis", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Palestinian Territory, Occupied", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Principe", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Barthelemy", "Saint Helena", "Saint Kitts", "Saint Lucia", "Saint Martin (French part)", "Saint Pierre", "Saint Vincent", "Samoa", "San Marino", "Sao Tome", "Saudi Arabia", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia", "South Sandwich Islands", "Spain", "Sri Lanka", "Sudan", "Suriname", "Svalbard", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "The Grenadines", "Timor-Leste", "Tobago", "Togo", "Tokelau", "Tonga", "Trinidad", "Tunisia", "Turkey", "Turkmenistan", "Turks Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay", "US Minor Outlying Islands", "Uzbekistan", "Vanuatu", "Vatican City State", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (US)", "Wallis", "Western Sahara", "Yemen", "Zambia", "Zimbabwe");	
	
	return $country_list;
}