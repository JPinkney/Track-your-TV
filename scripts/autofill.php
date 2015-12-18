<?php

/**
 * Get the list of shows that will fill the autocomplete
 *
 * @author JPinkney
 */
include "../base-login.php";

$query = $conn->prepare("SELECT show_name FROM shows");
$query->execute();
$results = $query->fetchAll();

$x  = array();
foreach($results as $show){
    array_push($x, $show['show_name']);
}

echo json_encode($x);

?>