<?php
$mood = $_POST['mood'] ?? '';

$suggestions = [
    "stressed" => [
        "name" => "Rose Bloom Soap",
        "search" => "rose",
        "reason" => "Rose soap is gentle and calming, perfect when you feel stressed."
    ],
    "tired" => [
        "name" => "Massage Soap",
        "search" => "massage",
        "reason" => "Massage soap can help you feel refreshed and relaxed."
    ],
    "happy" => [
        "name" => "Rose Bloom Soap",
        "search" => "rose",
        "reason" => "Rose soap matches a happy and fresh mood."
    ],
    "sad" => [
        "name" => "Rose Bloom Soap",
        "search" => "rose",
        "reason" => "Rose soap gives a soft, comforting feeling."
    ],
    "romantic" => [
        "name" => "Rose Bloom Soap",
        "search" => "rose",
        "reason" => "Rose soap is a perfect romantic choice."
    ],
    "fresh" => [
        "name" => "Neem Cleanse Bar",
        "search" => "neem",
        "reason" => "Neem soap gives a clean and fresh feeling."
    ],
    "sleepy" => [
        "name" => "Massage Soap",
        "search" => "massage",
        "reason" => "Massage soap is relaxing before rest."
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nature's Glow | Mood Suggestion</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #FAF9F6;
            color: #4B371C;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background: white;
            padding: 15px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }

        .navbar a {
            text-decoration: none;
            color: #4B371C;
            font-weight: bold;
            margin-left: 15px;
        }

        .logo {
            font-size: 24px;
            color: #8A9A5B;
        }

        .container {
            max-width: 500px;
            background: white;
            margin: 70px auto;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            text-align: center;
        }

        h2 {
            color: #8A9A5B;
            margin-bottom: 20px;
        }

        select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin: 15px 0;
            font-size: 15px;
        }

        button,
        .btn {
            display: inline-block;
            background-color: #8A9A5B;
            color: white;
            padding: 12px 22px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover,
        .btn:hover {
            background-color: #76884b;
        }

        .secondary-link {
            display: inline-block;
            margin-top: 15px;
            color: #4B371C;
            text-decoration: none;
            font-weight: bold;
        }

        .result-box {
            background: #f9fbf2;
            border: 1px dashed #8A9A5B;
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <a href="index.php" class="logo">Nature's Glow</a>

    <div>
        <a href="products.php">Products</a>
        <a href="cart.php">Cart</a>
        <a href="mood_suggestion.php">Mood Suggestion</a>
    </div>
</nav>

<div class="container">
    <h2>Soap Suggestion Based on Your Mood</h2>

    <?php if ($mood && isset($suggestions[$mood])): ?>

        <div class="result-box">
            <h3>Your mood: <?php echo htmlspecialchars(ucfirst($mood)); ?></h3>

            <p>Recommended soap:</p>

            <h2><?php echo htmlspecialchars($suggestions[$mood]['name']); ?></h2>

            <p><?php echo htmlspecialchars($suggestions[$mood]['reason']); ?></p>

            <a class="btn" href="products.php?search=<?php echo urlencode($suggestions[$mood]['search']); ?>">
                View Suggested Soap
            </a>
        </div>

        <br>
        <a class="secondary-link" href="mood_suggestion.php">Try Again</a>

    <?php else: ?>

        <form method="POST" action="mood_suggestion.php">
            <label>How are you feeling today?</label>

            <select name="mood" required>
                <option value="">Select your mood</option>
                <option value="stressed">Stressed</option>
                <option value="tired">Tired</option>
                <option value="happy">Happy</option>
                <option value="sad">Sad</option>
                <option value="romantic">Romantic</option>
                <option value="fresh">Fresh / Active</option>
                <option value="sleepy">Sleepy</option>
            </select>

            <button type="submit">Get Suggestion</button>
        </form>

    <?php endif; ?>

    <br><br>
    <a class="secondary-link" href="products.php">Back to Products</a>
</div>

</body>
</html>