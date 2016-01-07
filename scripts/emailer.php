<?php

/**
  * Sends emails to users who opt into email notifications
  *
  * @author JPinkney
  */
 
require "../base-login.php";

$current_date = date("Y-m-d");

$query = $conn->prepare("SELECT show_name, airDate, username, email FROM shows, users WHERE email_notifications=1 and nextEpisode=?");
$query->execute(array($current_date));
$results = $query->fetchAll();

for($x = 0; $x < count($results); $x++){

    $to = $results[$x]['email'];
    $subject = "Your daily show reminder!";
    $txt = "Your show ".$results[$x]['show_name']." ".$results[$x]['airDate'];
    $headers = "From: TVTracker@trackyourtv.com";

    mail($to,$subject,$txt,$headers);
}

?>