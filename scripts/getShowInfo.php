<?php

require "../base-login.php";

function showInUserDB($conn, $show_name, $showID, $airDate, $nextEpisode){
    //Check if the show is in the users table
    $query = $conn->prepare("SELECT showID, show_name FROM user_shows WHERE show_name=?");
    $query->execute(array($show_name));
    $results = $query->fetchAll();

    //If it isn't in the users table then get the info from the shows table then add it
    if($results == NULL){
        //add
        $user = $_SESSION['username'];
        //$user = "Josh";
        addShowToUsersList($conn, $showID, $show_name, $user);
    }else{
        echo '<script language="javascript">';
        echo 'alert("You are already tracking that show silly!")';
        echo '</script>';
    }

    $results = array($show_name, $airDate, $nextEpisode);
    return $results;
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

        //Go through episodelist then season then episode then date
        $current_date = date("Y-m-d");
        echo "<pre>";

        //I.e. there is only 1 season
        if($show_data['Episodelist']['Season'][0] == null) {
            for($ep = 0; $ep < count($show_data['Episodelist']['Season']['episode']); $ep++){
                if($show_data['Episodelist']['Season']['episode'][$ep]['airdate'] >= $current_date){
                    $newest_episode = $show_data['Episodelist']['Season']['episode'][$ep]['airdate'];
                    break;
                }
            }
        }else {
            for ($season = 0; $season < count($show_data['Episodelist']['Season']); $season++) {
                if($show_data['Episodelist']['Season'][$season]['episode'][0] != null){
                        for ($ep = 0; $ep < count($show_data['Episodelist']['Season'][$season]['episode']); $ep++) {
                            if ($show_data['Episodelist']['Season'][$season]['episode'][$ep]['airdate'] >= $current_date) {
                                $newest_episode = $show_data['Episodelist']['Season'][$season]['episode'][$ep]['airdate'];
                                break;
                            }
                        }
                    }else{
                        //There is only one item in the xml
                        if ($show_data['Episodelist']['Season'][$season]['episode']['airdate'] >= $current_date) {
                            $newest_episode = $show_data['Episodelist']['Season'][$season]['episode']['airdate'];
                            break;
                        }
                    }
                }
        }
        echo "</pre>";

    }

    $query = $conn->prepare("INSERT INTO shows (showID, show_name, airDate, nextEpisode) VALUES (?, ?, ?, ?)");
    $query->execute(array((int)$id, $name, $airs, $newest_episode));

    $showInDB = showInUserDB($conn, $name, $id, $airs, $newest_episode);
    echo json_encode($showInDB);

}

$id = $_GET['id'];
addShowToDB($conn, $id);

?>


