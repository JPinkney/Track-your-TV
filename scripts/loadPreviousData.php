<?php

/**
 * loadPreviousData.php
 * Takes in username through a session
 * Gets all of the previous shows that the user has entered
 */

require('../base-login.php');

$username = $_SESSION['username'];

$query = $conn->prepare("SELECT * FROM user_shows WHERE username=?");
$query->execute(array($username));
$result = $query->fetchAll();

echo json_encode($result);

?>