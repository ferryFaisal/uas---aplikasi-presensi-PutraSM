<?php
// used to connect to the database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "mydbo";
// Create connection
$conn = new mysqli($host, $username, $password, $dbname);
// Check connection
if($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>