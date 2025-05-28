<?php
// Database configuration
$host = 'sql109.infinityfree.com'; // Database host
$db = 'if0_39081327_venuedb'; // Database name
$user = 'if0_39081327'; // Database username
$pass = '1YjgHno2ek1o'; // Database password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>