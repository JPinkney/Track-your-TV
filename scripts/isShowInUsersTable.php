<?php
/**
 * isShowInUsersTable.php
 * Checks to see if the TV Show is in the users database. If its not then add it.
 */

$username = $_SESSION['username'];
$showname = $_GET['tvshow'];

$query = $conn->prepare("SELECT * FROM user_shows WHERE username=? and showname=?");
$query->execute(array($username, $showname));
$results = $query->fetchAll();

//IF ITS NOT IN THE USERS TABLE
if($results == NULL){
    $query = $conn->prepare("INSERT INTO user_shows (username, showname) VALUES (?, ?)");
    $query->execute(array($username, $showname));
}else{
    json_encode(NULL);
}

?>