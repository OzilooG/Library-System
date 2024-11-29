<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "AssignmentDB";
// create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// display if connection fails 
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}


?>