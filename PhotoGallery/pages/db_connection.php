<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "photogallery";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally, set the charset for the connection
$conn->set_charset("utf8");

?>
