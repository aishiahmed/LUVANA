<?php
session_start();
include('db.php');

// Your Google Console Keys
$clientID = '363654339723-hd82g0g8flq6p0fpkedple1fhq20vmu4.apps.googleusercontent.com';
$clientSecret = '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'; // <--- PASTE IT HERE
$redirectUri = 'http://localhost/cse3277_projec/google_login.php';

if (isset($_GET['code'])) {
    // This part exchanges the code for a login token
    $token_url = "https://oauth2.googleapis.com/token";
    $post_data = [
        'code' => $_GET['code'],
        'client_id' => $clientID,
        'client_secret' => $clientSecret,
        'redirect_uri' => $redirectUri,
        'grant_type' => 'authorization_code'
    ];

    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    $response = json_decode(curl_exec($ch), true);
    
    if (isset($response['access_token'])) {
        $user_info_url = "https://www.googleapis.com/oauth2/v1/userinfo?access_token=" . $response['access_token'];
        $user = json_decode(file_get_contents($user_info_url), true);

        $google_id = $user['id'];
        $email = $user['email'];
        $name = mysqli_real_escape_string($conn, $user['name']);

        // Check user in your organic_soap_db
        $check = mysqli_query($conn, "SELECT * FROM users WHERE google_id = '$google_id' OR email = '$email'");
        
        if ($row = mysqli_fetch_assoc($check)) {
            $_SESSION['user_id'] = $row['id'];
        } else {
            // Add new user to database
            mysqli_query($conn, "INSERT INTO users (username, email, google_id, role) VALUES ('$name', '$email', '$google_id', 'customer')");
            $_SESSION['user_id'] = mysqli_insert_id($conn);
        }
        
        // Success! Go to dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        die("Login Failed: Access Token not received. Check your Client Secret.");
    }
} else {
    // Start Google Login
    $auth_url = "https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id=$clientID&redirect_uri=$redirectUri&scope=email%20profile";
    header("Location: $auth_url");
    exit();
}
?>