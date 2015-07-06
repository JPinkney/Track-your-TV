<?php

include "base-login.php";

######THIS IS THE FILE THAT RUNS DAILY AT ROUGHLY 12 A.M######


$query = mysqli_query($conn, "SELECT show_name, next_episode, emails FROM shows");

while ($row=mysqli_fetch_array($query)) {
    if(date("m.j.y", strtotime($row['next_episode'])) === date("m.j.y")){

	    $msg = "Dear User, Your show ".$row['show_name']." will be airing in approximately one hour.";

		// use wordwrap() if lines are longer than 70 characters
		$msg = wordwrap($msg,70);

	    // send email
		mail($row['emails'],"Track your TV: Your TV show is coming on soon", $msg);


    }
}
$row=mysqli_fetch_array($query)
mysqli_query($conn, "UPDATE shows set refresh=1 WHERE show_name='".$row['next_episode']."'");

?>
