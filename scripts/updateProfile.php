<?php

/**
  * Update the profile of the current user
  *
  * @author JPinkney
  */
 
require "../base-login.php";

$username = $_SESSION["Username"];
$emails = $_POST['emails'];
$text = $_POST['text-message'];
$phone_number = $_POST['phone_number'];
$carrier = $_POST['carrier'];

if($emails == "on"){
    $emails = 1;
}else{
    $emails = 0;
}

if($text == "on"){
    $text = 1;
}else{
    $text = 0;
}

$phone_number = str_replace("-", "", $phone_number);

if($carrier == "AT&T"){
	$carrier_email = "txt.att.net";
}else if($carrier == "Sprint"){
	$carrier_email = "messaging.sprintpcs.com";
}else if($carrier == "T-Mobile"){
	$carrier_email = "tmomail.net";
}else if($carrier == "Verizon"){
	$carrier_email = "vtext.com";
}else if($carrier == "Alltel"){
	$carrier_email = "message.alltel.com";
}else if($carrier == "Rogers"){
	$carrier_email = "pcs.rogers.com";
}else if($carrier == "Telus"){
	$carrier_email = "msg.telus.com";
}else if($carrier == "Virgin Mobile"){
	$carrier_email = "vmobl.com";
}else if($carrier == "Bell"){
	$carrier_email = "txt.bellmobility.ca";
}

$query = $conn->prepare("UPDATE users SET email_notifications=?, text_notifications=?, phone_number=?, carrier_email=? WHERE username=?");
$query->execute(array($emails, $text, $phone_number, $carrier, $username));

?>