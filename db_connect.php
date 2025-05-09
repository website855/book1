<?php
// db_connect.php

$host = 'localhost';    // your database host
$user = 'root';         // your database username
$password = '';         // your database password
$dbname = 'turfmaster'; // your database name

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
