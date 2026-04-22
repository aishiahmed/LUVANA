<?php
$host = "localhost";
$user = "root"; 
$pass = ""; // Default XAMPP password is empty
$dbname = "organic_soap_db";

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>