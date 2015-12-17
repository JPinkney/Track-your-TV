<?php

require "../base-login.php";
require "../TVMazeIncludes.php";

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

function addShowToUsersList($conn, $show_id, $show_name, $username){
    $query = $conn->prepare("INSERT INTO user_shows (username, showID, show_name) VALUES (?, ?, ?)");
    $query->execute(array($username, $show_id, $show_name));
}

function addShowToShowsList($conn, $id, $name, $airs, $newest_episode){
    $query = $conn->prepare("INSERT INTO shows (showID, show_name, airDate, nextEpisode) VALUES (?, ?, ?, ?)");
    $query->execute(array((int)$id, $name, $airs, $newest_episode));
}

/*
 *
 * Check to see if the show is in the users database
 *
 */
function showInUserDB($conn, $show_name){
    //Check if the show is in the users table
    $user = $_SESSION['Username'];
    $query = $conn->prepare("SELECT showID, show_name FROM user_shows WHERE show_name=? AND username=?");
    $query->execute(array($show_name, $user));
    $results = $query->fetchAll();

    //Regardless of whether or not show is in the users table you'll need to get the info
    $query = $conn->prepare("SELECT showID, airDate, nextEpisode FROM shows WHERE show_name=?");
    $query->execute(array($show_name));
    $show_data = $query->fetchAll();

    $showID = $show_data[0]['showID'];
    $airDate = $show_data[0]['airDate'];
    $nextEpisode = $show_data[0]['nextEpisode'];

    //If it isn't in the users table then get the info from the shows table then add it
    if(count($results) == 0){
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

    $Client = new JPinkney\Client;

    $search_show = $Client->TVMaze->singleSearch($show_name)[0];
 
    //We need to double check after the search if its in the table otherwise it could store duplicates if they spelled something wrong
    if($search_show === null || $search_show === ""){
        echo '<script language="javascript">';
        echo 'alert("Unfortunately that show is not available to track.")';
        echo '</script>';
    }else{
        //add the show to the users db
        //then display

        $user = $_SESSION['Username'];

        $show_id = $search_show->id;
        $show_name = $search_show->name;
        $show_airs = 'Airs '.$search_show->airDay."'s at ".$search_show->airTime.' on '.$search_show->network;
        $show_newEpisode = $search_show->nextAirDate;

        addShowToShowsList($conn, $show_id, $show_name, $show_airs, $show_newEpisode);
        addShowToUsersList($conn, $show_id, $show_name, $user);

        echo json_encode(array($show_id, $show_newEpisode, $show_airs));
    }
}


?>