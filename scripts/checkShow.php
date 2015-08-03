<?php

require "../base-login.php";

/*
 *
 * Checks to see if the show name is in the table called show
 *
 */
function isShowInShowTable($conn, $show_name){
    $query = $conn->prepare("SELECT show_name, airDate, nextEpisode FROM shows WHERE show_name=?");
    $query->execute(array($show_name));
    $results = $query->fetchAll();
    return $results;
}

/*
 *
 * Returns a list of available shows from a TVRage search
 *
 */
function getDataFromTVRage($show_name){
    //GET the results from TV Rage

    //Add show to DB, ADD show to users list, display to userlist
    $file = simplexml_load_file("http://services.tvrage.com/feeds/search.php?show=".$show_name);
    $show_array = json_decode(json_encode($file), TRUE);
    $shows = array();
    if($show_array != NULL){
        for($x = 0; $x < count($show_array['show']); $x++){
            //print_r($show_array['show'][$x]['name']);
            array_push($shows, array($show_array['show'][$x]['name'], $show_array['show'][$x]['showid'])); //JUST GET THE SHOW ID FROM HERE WITH THE NAME
        }
    }else{
        //PRINT OUT ERROR THING TO SCREEN SAYING SHOW NOT FOUND
        echo '<script language="javascript">';
        echo 'alert("You are already tracking that show silly!")';
        echo '</script>';
        $shows = NULL;
    }
    echo json_encode($shows);
}


/*
 *
 * Add a show to the users list
 *
 */
function addShowToUsersList($conn, $show_id, $show_name, $username){
    $query = $conn->prepare("INSERT INTO user_shows (username, showID, show_name) VALUES (?, ?, ?)");
    $query->execute(array($username, $show_id, $show_name));
}

function showInUserDB($conn, $show_name){
    //Check if the show is in the users table
    $query = $conn->prepare("SELECT showID, show_name FROM user_shows WHERE show_name=?");
    $query->execute(array($show_name));
    $results = $query->fetchAll();

    //Regardless of whether or not show is in the users table you'll need to get the info
    $query = $conn->prepare("SELECT showID, airDate, nextEpisode FROM shows WHERE show_name=?");
    $query->execute(array($show_name));
    $show_data = $query->fetchAll();

    $showID = $show_data[0]['showID'];
    $airDate = $show_data[0]['airDate'];
    $nextEpisode = $show_data[0]['nextEpisode'];

    //If it isn't in the users table then get the info from the shows table then add it
    if($results == NULL){
        //add
        $user = $_SESSION['username'];
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

//TEST
//echo "<pre>";
    //$show = $_GET['show_name'];
    //getDataFromTVRage($show);
    //echo json_encode("test");
//echo "</pre>";

/**
 *
 * Check if show is in db
 *      IF IT IS:
 *            Check if show is in the users db. If not then add else alert -
 *            Grab the show name, next episode, and channel and time it airs and display to user (done in showInUserDB)
 *      IF NOT:
 *            Do the drop down menu where they can choose which show they want to add
 *
 *            Get the results of all the shows with that sameish name from TVRage (done in getDataFromTVRage)
 *            When user picks then get the data for that show (done in Javascript)
 *            Add the show to database
 *            Add the show to user list (WE CAN REUSE SHOWINUSERDB FOR THIS PART!!!)
 *            Display to users list
 *
 */


$show_name = $_GET['show_name'];
if(isShowInShowTable($conn, $show_name)){
    showInUserDB($conn, $show_name);
}else{
    $search_shows = getDataFromTVRage($show_name);
    if($search_shows == NULL){
        echo '<script language="javascript">';
        echo 'alert("Unforunately that show is not available to track.")';
        echo '</script>';
    }else{
        //var_dump($search_shows);
        echo json_encode($search_shows);
    }
}


?>