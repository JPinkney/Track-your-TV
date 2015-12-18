<?php

/**
  * Sends text messagers to users who opt into text messages
  *
  * @author JPinkney
  */
require "../base-login.php";

$current_date = date("Y-m-d");

$query = $conn->prepare("SELECT A.show_name, A.nextEpisode, A.airDate, C.phone_number, C.carrier_email, C.text_notifications FROM shows A, user_shows B, users C WHERE A.showID=B.showID AND B.username=C.username AND C.email_notifications=1 AND A.nextEpisode=?");
$query->execute(array($current_date));
$results = $query->fetchAll();

for($x = 0; $x < count($results); $x++){

		$to = $results[$x]['phone_number']."@".$results[$x]['carrier_email'];
	    $subject = "Your daily show reminder!";
	    $txt = "Your show ".$results[$x]['show_name']." ".$results[$x]['airDate'];
	    $headers = "From: TVTracker@trackyourtv.com";

	    mail($to,$subject,$txt,$headers);	
    
}

?>