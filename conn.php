<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "CS3";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>