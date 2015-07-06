<?php

/**
 * isDataInDB.php
 * Gets the show name
 * Gets all of the data for a specific show. Can be used when we want to check if in database then get data if it is
 */

include "../base-login.php";

$name = $_GET['show_name'];

//WE CAN GET THE ID FORM THE SHOW NAME AFTER WE AUTOFILL AND THEY CLICK WHICH ONE IT IS

//get other data
//$name = str_replace("/\s+/g", "_", $name);

$query = $conn->prepare("SELECT show_name, next_episode, air_date FROM shows WHERE show_name=?");
$query->execute(array($name));
$results = $query->fetchAll();

//The show isn't in the db
if($results == NULL){

    //
    //
    //
    //HERE WE CAN SCRAPE THROUGH THE XML TO FIND THE RELEVANT DATA
    //
    //
    //


    //SCRAPE THE XML
    $url = "http://services.tvrage.com/feeds/full_show_info.php?sid=2930";
    $xml_as_simplexml = simplexml_load_file($url);

    //Recursively makes all the simplexml objects to array objects
    $encoded_xml = json_encode($xml_as_simplexml);
    $xml_as_array = json_decode($encoded_xml, TRUE);


    $query = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $query->execute(array($username, $password, $email));

    echo json_encode($results); //Make an array of all the results

}else{
    echo json_encode($results);
}



?>
