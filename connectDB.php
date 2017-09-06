<?php

$hostname = "localhost";
$username = "root";
$password = "R9!6fsX5@3de";
$DBname = "goodsharing";

mysql_query("SET NAMES ‘UTF8′");
mysql_query("SET CHARACTER SET UTF8");

// Create connection
$conn = new mysqli($hostname, $username, $password, $DBname);


// Check connection
if ($conn->connect_error) {
    die("Error: "+$conn->connect_error);
} 
//echo '<script>console.log("connected to database");</script>';
?>
