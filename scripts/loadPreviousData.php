<?php

/**
 * loadPreviousData.php
 * Takes in username through a session
 * Gets all of the previous shows that the user has entered
 */

require('../base-login.php');

$username = $_SESSION['Username'];

$query = $conn->prepare("SELECT A.show_name, A.nextEpisode, A.airDate FROM shows A, user_shows B WHERE A.showID=B.showID AND username=?");
$query->execute(array($username));
$result = $query->fetchAll();

echo json_encode($result);

?>