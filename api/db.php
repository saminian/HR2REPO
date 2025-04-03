<?php
$host = "localhost";
$user = "root"; // Change if needed
$password = ""; // Your database password
$dbname = "hr2"; // Change to your DB name

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
