<?php
// Database connection
$servername = "YOUR_SERVER";
$username = "YOUR_USERNAME";
$password = "YOUR_PASSWORD";
$dbname = "YOUR_DB_NAME";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
date_default_timezone_set('Asia/Manila');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>