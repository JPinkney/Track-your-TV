<?php
ob_start();

require "../base-login.php";
require "../password.php";

//If the user is not logged in then they can't log in
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    header('Location: ../index.php');
}
elseif(!empty($_POST['username']) && !empty($_POST['password']))
{

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT username, password, email from users WHERE username=?");
    $query->execute(array($username));
    $results = $query->fetchAll();

    if(password_verify($password, $results[0]['password'])){
        $_SESSION['Username'] = $username;
        $_SESSION['LoggedIn'] = 1;

        header('Location: ../index.php');
    }else{
        echo "<h6>Your username and password do not match.</h6>";
    }

}

ob_end_clean();
?>




