<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nature's Glow | Login</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            background-color: #FFFDD0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }

        h2 {
            color: #8A9A5B;
            margin-bottom: 25px;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #8A9A5B;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .btn:hover {
            background-color: #76884b;
        }

        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 1px solid #ddd;
            color: #444;
            padding: 10px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            margin-top: 15px;
            transition: background 0.3s;
        }

        .btn-google:hover {
            background: #f1f1f1;
        }

        .btn-google img {
            width: 18px;
            margin-right: 10px;
        }

        .btn-mood {
            display: block;
            background-color: #4B371C;
            color: white;
            padding: 12px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 15px;
            font-weight: bold;
            margin-top: 15px;
            transition: background 0.3s;
        }

        .btn-mood:hover {
            background-color: #6b4f2a;
        }

        .divider {
            margin: 20px 0;
            display: flex;
            align-items: center;
            color: #888;
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
            margin: 0 10px;
        }

        .switch-link {
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .switch-link a {
            color: #4B371C;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="login-container">
    <h2>Welcome Back</h2>

    <form action="login_logic.php" method="POST">
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login" class="btn">Login</button>
    </form>

    <div class="divider">OR</div>

    <a href="google_login.php" class="btn-google">
        <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google">
        Continue with Google
    </a>

    <!-- Mood Suggestion Link -->
    <a href="mood_suggestion.php" class="btn-mood">
        Get Soap Suggestion Based on Your Mood
    </a>

    <div class="switch-link">
        Don't have an account? <a href="register.php">Sign Up</a>
    </div>
</div>

</body>
</html>