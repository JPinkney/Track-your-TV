<?php
ob_start();

require "../base-login.php";

$username = $_POST['username'];
$password = $_POST['password'];
$password_confirm = $_POST['password-confirm'];
$email = $_POST['email'];
$email_confirm = $_POST['email-confirm'];

if(!empty($username) && !empty($password) && !empty($password_confirm) && !empty($email) && !empty($email_confirm)){

    if($password !== $password_confirm){
        echo "Your passwords do not match";
    }

    if($email !== $email_confirm){
        echo "Your emails do not match";
    }

    if($password === $password_confirm & $email === $email_confirm){
        //Checking to see if the username is already in the database
        $query = $conn->prepare("SELECT username FROM users WHERE username=?");
        $query->execute(array($username));
        $results = $query->fetchAll();

        //If the username isn't in the database then add the account
        if($results == NULL){
            $query = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
            $pass = password_hash($password, PASSWORD_BCRYPT);
            $query->execute(array($username, $pass, $email));

            $_SESSION['Username'] = $username;
            $_SESSION['LoggedIn'] = 1;

            header("Location: ../index.php");
        }else{
            echo "Sorry. The username you've chosen is already in use.";
        }
    }
}

ob_end_clean();
?>