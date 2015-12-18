<?php

/**
 * Check to see if the TVShow is in the Database, 
 * if no then add it to the show list and user list
 * if yes then just add it to the user list
 * 
 * @author JPinkney
 */
require "../base-login.php";
require "../TVMazeIncludes.php";

/**
 * Check to see if the show name is the show table
 * 
 * @param PDO $conn the database connection 
 * @param String $show_name the showname to check 
 * @return Array of String
 */
function isShowInShowTable($conn, $show_name){
    $query = $conn->prepare("SELECT show_name, airDate, nextEpisode FROM shows WHERE show_name=?");
    $query->execute(array($show_name));
    $results = $query->fetchAll();
    return $results;
}

/**
 * Add show to the user list
 * 
 * @param PDO $conn the database connection 
 * @param int $show_id the id of the show 
 * @param string $show_name the name of the show
 * @param string $username the username of the current user 
 * @return null
 */
function addShowToUsersList($conn, $show_id, $show_name, $username){
    $query = $conn->prepare("INSERT INTO user_shows (username, showID, show_name) VALUES (?, ?, ?)");
    $query->execute(array($username, $show_id, $show_name));
}

/**
 * Add show to show list
 * 
 * @param PDO $conn the database connection
 * @param int $id the id of the show 
 * @param string $name the name of the show
 * @param string $airs the date the show airs (in string format)
 * @param string $newest_episode the newest airing episode
 * @return null
 */
function addShowToShowsList($conn, $id, $name, $airs, $newest_episode){
    $query = $conn->prepare("INSERT INTO shows (showID, show_name, airDate, nextEpisode) VALUES (?, ?, ?, ?)");
    $query->execute(array((int)$id, $name, $airs, $newest_episode));
}

/**
 * Check if the show is in the user database
 * 
 * @param PDO $conn the database connection 
 * @param string $show_name the name of the show 
 * @return Array
 */
function showInUserDB($conn, $show_name){
    //Check if the show is in the users table
    $user = $_SESSION['Username'];

    $query = $conn->prepare("SELECT A.show_name, A.nextEpisode, A.airDate FROM shows A, user_shows B WHERE A.showID=B.showID AND A.show_name=? AND username=?");
    $query->execute(array($show_name, $user));
    $result = $query->fetchAll();


    //If it isn't in the users table then get the info from the shows table then add it
    if(count($result) == 0){

        $query = $conn->prepare("SELECT showID, nextEpisode, airDate FROM shows WHERE show_name=?");
        $query->execute(array($show_name));
        $show_data = $query->fetchAll();

        $showID = $show_data[0]['showID'];
        $nextEpisode = $show_data[0]['nextEpisode'];
        $airDate = $show_data[0]['airDate'];
        
        addShowToUsersList($conn, $showID, $show_name, $user);
        echo json_encode(array($show_name, $nextEpisode, $airDate));
    }else{
        echo json_encode(array());
    }

    
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
    
    if($search_show->id === null){
        echo json_encode(array("Not found"));
    }else{
        //add the show to the users db
        //then display

        $user = $_SESSION['Username'];

        $show_id = $search_show->id;
        $show_newEpisode = ($search_show->nextAirDate === null ? "Unknown Next Air Date" : $search_show->nextAirDate);
        $show_airs = ($search_show->airDay === null ? "Not Currently Airing" : 'Airs '.$search_show->airDay."'s at ".$search_show->airTime.' on '.$search_show->network);

        if($show_id !== ""){
            addShowToShowsList($conn, $show_id, $show_name, $show_airs, $show_newEpisode);
            addShowToUsersList($conn, $show_id, $show_name, $user);
        }       
        
        echo json_encode(array($show_name, $show_newEpisode, $show_airs));
  
    }
}


?>