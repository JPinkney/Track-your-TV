<?php
//ob_start();

require "../base-login.php";
require "../password.php";

//If the user is not logged in then they can't log in
if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))
{
    //header('Location: ../index.php');
    //This section shouldn't be available because they are logged in and this switched to a single page application.
}
elseif(!empty($_POST['username']) && !empty($_POST['password']))
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

//ob_end_clean();
?>




