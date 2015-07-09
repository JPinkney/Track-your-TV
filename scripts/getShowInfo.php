<?php
/**
 * Created by PhpStorm.
 * User: joshpinkney
 * Date: 7/7/15
 * Time: 10:13 PM
 */

require "../base-login.php";

function showInUserDB($conn, $show_name, $showID, $airDate, $nextEpisode){
    //Check if the show is in the users table
    $query = $conn->prepare("SELECT showID, show_name FROM user_shows WHERE show_name=?");
    $query->execute(array($show_name));
    $results = $query->fetchAll();

    //If it isn't in the users table then get the info from the shows table then add it
    if($results == NULL){
        //add
        //$user = $_SESSION['username'];
        $user = "Josh";
        addShowToUsersList($conn, $showID, $show_name, $user);
    }else{
        echo '<script language="javascript">';
        echo 'alert("You are already tracking that show silly!")';
        echo '</script>';
    }

    $results = array($show_name, $airDate, $nextEpisode);
    //ECHO OUT TO THE UI
    echo json_encode($results);
}

function addShowToUsersList($conn, $show_id, $show_name, $username){
    $query = $conn->prepare("INSERT INTO user_shows (username, showID, show_name) VALUES (?, ?, ?)");
    $query->execute(array($username, $show_id, $show_name));
}

function addShowToDB($conn, $showID){
    //Add the show to the DB

    //Add show to DB, ADD show to users list, display to userlist
    $file = simplexml_load_file("http://services.tvrage.com/feeds/full_show_info.php?sid=".$showID);
    $show_data = json_decode(json_encode($file), TRUE);

    //SCRAPE WHATEVER INFO YOU NEED
    $name = $show_data['name'];
    $id = $show_data['showid'];
    $stand_time = date("g:i a", strtotime($show_data['airtime']));
    $airs = "Airs ".$show_data['airday']." at ".$stand_time." on ".$show_data['network'];
    if($show_data['status'] === 'Ended' || $show_data['status'] === 'Canceled' || $show_data['status'] === "Canceled/Ended"){
        $newest_episode = "This show has ended";
    }else{
        $last_season = end($show_data['Episodelist']['Season']);
        $current_date = date("y-m-d");
        $count = 0;
        foreach($last_season as $episodes){
            print_r($episodes);
            if($episodes[$count]['airdate'] >= $current_date){
                $newest_episode = $episodes[$count]['airdate'];
                break;
            }

            //FIX ME IF THE SHOW HAS ENDED AND STUFF
            $count+=1;
        }
    }

    $query = $conn->prepare("INSERT INTO shows (showID, show_name, airDate, nextEpisode) VALUES (?, ?, ?, ?)");
    $query->execute(array((int)$id, $name, $airs, $newest_episode));

    showInUserDB($conn, $name, $id, $airs, $newest_episode);


}

$id = $_GET['id'];
addShowToDB($conn, $id);

?>


