<?php

/**
 * Verify a users login
 * 
 * @author JPinkney
 */
require "../base-login.php";
require "../password.php";

/*
 * Check to see if the username and password match something in the database
 */
if(!empty($_POST['username']) && !empty($_POST['password']))
{

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT username, password, email from users WHERE username=?");
    $query->execute(array($username));
    $results = $query->fetchAll();
    if($results != null){
        if(password_verify($password, $results[0]['password'])){
            $_SESSION['Username'] = $username;
            $_SESSION['LoggedIn'] = 1;

            echo json_encode(1);
        }else{
            echo json_encode("Your username and password do not match");
        }
    }else{
        echo json_encode("Account not found");
    }

}

?>




