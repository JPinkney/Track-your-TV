<?php

/**
  * Check to see if the user is in the users database
  * 
  * @author JPinkney
  */
include ('../base-login.php');

$username = $_GET['username'];
$password = $_GET['Password'];
$email = $_GET['Email'];

$query = $conn->prepare("SELECT * FROM users WHERE username=?");
$query->execute(array($username));
$results = $query->fetchAll();

if($results == NULL){
    $query = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $query->execute(array($username, $password, $email));
}else{
    echo '<script language="javascript">';
    echo 'alert("Error. Username is already in the database")';
    echo '</script>';
}

?>