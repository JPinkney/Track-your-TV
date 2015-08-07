<?php

require "../base-login.php";

$username = $_SESSION["Username"];
$emails = $_POST['emails'];
$text = $_POST['text-message'];
$phone_number = $_POST['phone_number'];

if($emails == "on"){
    $emails = 1;
}else{
    $emails = 0;
}

if($text == "on"){
    $text = 1;
}else{
    $text = 0;
}

$query = $conn->prepare("UPDATE users SET email_notifications=?, text_notifications=?, phone_number=? WHERE username=?");
$query->execute(array($emails, $text, $phone_number, $username));

?>