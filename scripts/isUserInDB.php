<?php

/**
 * addUserToTable.php
 * Takes in username, password, and email and adds them to the users table
 * Adds user to users table if they haven't previously signed up. Else error
 */

include ('../base-login.php');

$username = $_GET['username'];
$password = $_GET['Password'];
$email = $_GET['Email'];

$query = $conn->prepare("SELECT * FROM users WHERE username=?");
$query->execute(array($username));
$results = $query->fetchAll();

//The username isn't in the db
if($results == NULL){
    $query = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $query->execute(array($username, $password, $email));
}else{
    echo '<script language="javascript">';
    echo 'alert("Error. Username is already in the database")';
    echo '</script>';
}

?>