<?php

/**
 * logout.php
 * Starts then closes the session to log out a user
 */

session_start(); //to ensure you are using same session
session_destroy(); //destroy the session
header("location:/index.php"); //to redirect back to "index.php" after logging out
exit();

?>