<?php

$url = "http://services.tvrage.com/feeds/full_show_info.php?sid=2930";
$xml = simplexml_load_file($url);

$xml2 = json_encode($xml);
$xml3 = json_decode($xml2, TRUE);

echo "<pre>";
    print_r($xml3);
echo "</pre>";

?>