<?php

/**
 * autofill.php
 * Gets the list of shows that will fill the autocomplete
 */

include "../base-login.php";

$query = $conn->prepare("SELECT show_name FROM shows");
$query->execute();
$results = $query->fetchAll();

echo json_encode($results);

?>