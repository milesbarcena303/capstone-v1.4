<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "test_db";

// Create a new mysqli connection
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optionally, set the character set (e.g., UTF-8)
if (!mysqli_set_charset($conn, "utf8")) {
    die("Error setting character set: " . mysqli_error($conn));
}

// Now, you can use the $conn object for database operations

?>
