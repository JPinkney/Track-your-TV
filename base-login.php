<?php

/**
 *  Log in file that is included in every php file that requires access to the database
 *
 *	The log in file uses the PDO class to establish access to the database
 *	and is used in each file that needs access to the database.
 *
 *  @author jpinkney  
 */

session_start();

$servername = "127.0.0.1";
$db = "trackyourtv_db";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}

?>



