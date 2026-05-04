<?php
$host = "localhost";
$user = "root"; 
$pass = ""; // Default XAMPP password is empty
$dbname = "organic_soap_db"; // As seen in your phpMyAdmin

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ensure the google_id column exists for your Gmail login
$query = "SHOW COLUMNS FROM `users` LIKE 'google_id'";
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) == 0) {
    mysqli_query($conn, "ALTER TABLE users ADD COLUMN google_id VARCHAR(255) DEFAULT NULL");
}
?>