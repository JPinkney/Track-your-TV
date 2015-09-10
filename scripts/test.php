<?php

$url = "http://api.tvmaze.com/search/shows?q=suits&embed=episodes";
$json = file_get_contents($url);
$test = json_decode($json, TRUE);

echo "<pre>";
    print_r($test);
echo "</pre>";
?>