<?php

/**
  * This is the file that the cron job runs that will update all of the series daily
  *
  * @author JPinkney
  */
 
require "../base-login.php";

$current_date = date("Y-m-d");

$query = $conn->prepare("SELECT show_name FROM shows WHERE nextEpisode<=? or nextEpisode='Unknown Next Air Date'");
$query->execute(array($current_date));
$results = $query->fetchAll();

for($x = 0; $x < count($results); $x++){
	$Client = new JPinkney\Client;
	$show_name = $results[$x]['show_name'];
    $search_show = $Client->TVMaze->singleSearch($show_name)[0];
    $show_newEpisode = ($search_show->nextAirDate === null ? "Unknown Next Air Date" : $search_show->nextAirDate);
    $show_airs = ($search_show->airDay === null ? "Not Currently Airing" : 'Airs '.$search_show->airDay."'s at ".$search_show->airTime.' on '.$search_show->network);

    $query2 = $conn->prepare("UPDATE shows SET airDate=?, nextEpisode=? WHERE show_name=?");
    $query2->execute(array($show_airs, $show_newEpisode, $show_name));
}

?>