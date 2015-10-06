<?php
session_start();
$servername = "localhost";
$username = "cs3";
$password = "cs3";
$dbname = "cs3";

$dbstr = "pgsql:host=$servername;dbname=$dbname";

// Create connection
try {
    $dbh = new PDO($dbstr, $username, $password);
} catch (PDOException $e) {
    print "Error: " . $e->getMessage() . "<br/>";
    die();
}

?>
