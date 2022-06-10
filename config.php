<?php
define('DB_SERVER', 'localhost:3306');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'ebay');

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if($mysqli === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
else{
    //echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    //echo "<script>console.log('Debug Objects: connected' );</script>";
}
?>