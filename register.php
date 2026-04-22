<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Nature's Glow | Sign Up</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #FFFDD0; /* Cream background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
            width: 380px;
            text-align: center;
            border-top: 5px solid #8A9A5B; /* Sage Green accent */
        }
        h2 { color: #4B371C; margin-bottom: 10px; }
        p { color: #666; font-size: 14px; margin-bottom: 25px; }
        input {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            box-sizing: border-box;
            background-color: #fafafa;
        }
        input:focus { border-color: #8A9A5B; outline: none; }
        .btn {
            background-color: #8A9A5B;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 6px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin-top: 15px;
        }
        .btn:hover { background-color: #76884b; }
        .login-link { margin-top: 20px; font-size: 14px; }
        .login-link a { color: #8A9A5B; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="register-container">
    <h2>Create Account</h2>
    <p>Start your journey with organic purity.</p>
    <form action="register_logic.php" method="POST">
        <input type="text" name="username" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Create Password" required>
        <button type="submit" name="register" class="btn">Register Now</button>
    </form>
    <div class="login-link">
        Already a member? <a href="index.php">Login here</a>
    </div>
</div>

</body>
</html>