<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Pulling the role column we verified in the database
    $sql = "SELECT id, username, password, role FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        // Supports both hashed passwords and plain text for your current setup
        if (password_verify($password, $row['password']) || $password == $row['password']) {
            
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['username'];
            
            // This enables the restricted access checks we added
            $_SESSION['role'] = $row['role']; 

            // Logic to separate admins from customers
            if ($_SESSION['role'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        }
    }
    // Redirect back to login with an error message instead of a blank page
    header("Location: index.php?error=invalid_credentials");
    exit();
}
?>