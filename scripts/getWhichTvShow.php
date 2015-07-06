<?php

/**
 * getWhichTvShow.php
 * This returns a list of all the tv shows in the xml file that we get in the search from TVRage
 */

$tv_show = $_GET['tvshow']; //Get something like suits

$url = "http://services.tvrage.com/feeds/search.php?show=".$tv_show;
$xml = simplexml_load_file($url);

$xml2 = json_encode($xml);
$xml3 = json_decode($xml2, TRUE);

$show_list = $xml3['show'];
$show_array = array();
for($x = 0; $x < count($show_list); $x++){
    array_push($show_array, array('id' => $show_list[$x]['showid'], 'name' => $show_list[$x]['name']));
}

echo json_encode($show_array);



?>