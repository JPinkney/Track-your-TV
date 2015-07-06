<?php


include "base-login.php"; 

######THIS IS THE FILE THAT RUNS DAILY AT ROUGHLY 2 A.M######
######THIS FILE RUNS AND RELOADS THE SCRIPTS TO GET IMPORTANT DATA######
$query = mysqli_query($conn, "SELECT show_name, refresh FROM shows WHERE refresh=1");

 // Defining the basic cURL function
    function curl($url) {
        $ch = curl_init();  // Initialising cURL
        curl_setopt($ch, CURLOPT_URL, $url);    // Setting cURL's URL option with the $url variable passed into the function
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
        $data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
        curl_close($ch);    // Closing cURL
        return $data;   // Returning the data from the function
    }

    // Defining the basic scraping function
    function scrape_between($data, $start, $end){
        $data = stristr($data, $start); // Stripping all data from before $start
        $data = substr($data, strlen($start));  // Stripping $start
        $stop = stripos($data, $end);   // Getting the position of the $end of the data to scrape
        $data = substr($data, 0, $stop);    // Stripping all data from after and including the $end of the data to scrape
        return $data;   // Returning the scraped data from the function
    }

while ($row=mysqli_fetch_array($query)) {
    $show_name = "";
    $next_episode = "";
    $air_date = "";

    $name = $row['show_name'];

    $name = str_replace("_", "-", $name);

    if (strtolower($name) === "the-walking-dead"){
        $name = "walking-dead";
    }
    if (strtolower($name) === "the-100"){
        $name = "the-hundred";
    }

    $general_scrape = curl("http://www.mynextepisode.com/shows/".$name);
    
    $show_name = scrape_between($general_scrape, '<h1 class="series_inside_heading">', "</h1>"); //Getting the show name
    $air_date = scrape_between($general_scrape, "<h3>NEXT EPISODE</h3>", "</p>");
    if (strlen($air_date) <= 1){
        $air_date = "not currently airing";
    }
    $next_episode = scrape_between($general_scrape, "<h4>Status</h4>", "</div>");

    mysqli_query($conn, "UPDATE shows SET show_name='".$show_name."', next_episode='".$next_episode."', air_date='".$air_date."', refresh=1 WHERE show_name='".$row['show_name']."'");
    
}








?>