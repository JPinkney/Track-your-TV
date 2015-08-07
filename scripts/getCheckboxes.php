<?php
/**
 * Created by PhpStorm.
 * User: joshpinkney
 * Date: 8/3/15
 * Time: 10:43 AM
 */

require "../base-login.php";

$username = $_SESSION["Username"];

$query = $conn->prepare("SELECT email_notifications, text_notifications, phone_number FROM users WHERE username=?");
$query->execute(array($username));
$results = $query->fetchAll();

echo json_encode($results);

?>
