<?php
session_start();
include('db.php'); 

// Kick user out if they aren't logged in
if (!isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUVANA | Love, Life!</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lexend:wght@300;400&display=swap');

        :root {
            --sage: #8A9A5B;
            --cream: #FAF9F6;
            --earth: #4B371C;
        }

        body { 
            margin: 0; 
            font-family: 'Lexend', sans-serif; 
            background-color: var(--cream); 
            color: var(--earth);
            scroll-behavior: smooth;
        }

        /* Navigation */
        nav {
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo { font-family: 'Playfair Display', serif; font-size: 28px; letter-spacing: 4px; font-weight: bold; }
        .nav-right { display: flex; align-items: center; gap: 20px; }
        #cart-counter { background: var(--sage); color: white; padding: 5px 15px; border-radius: 20px; font-weight: bold; }

        /* Admin Link Style */
        .admin-link {
            color: #d9534f;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            border: 1px solid #d9534f;
            padding: 8px 15px;
            border-radius: 50px;
            transition: 0.3s;
        }
        .admin-link:hover { background: #d9534f; color: white; }

        /* Hero Section */
        .hero {
            height: 85vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 10%;
        }

        .hero span { color: var(--sage); font-weight: bold; letter-spacing: 2px; text-transform: uppercase; font-size: 14px; }
        .hero h1 { font-family: 'Playfair Display', serif; font-size: 80px; margin: 10px 0; color: var(--earth); }
        .hero .tagline { font-family: 'Playfair Display', serif; font-style: italic; font-size: 24px; margin-bottom: 20px; }
        .hero p { max-width: 600px; line-height: 1.6; font-size: 18px; color: #666; }

        /* Info Section */
        .organic-info {
            padding: 120px 10%;
            background-color: #f4f6f0;
            text-align: center;
        }

        .organic-info h2 { font-family: 'Playfair Display', serif; font-size: 42px; color: var(--sage); }
        .organic-info p { max-width: 800px; margin: 20px auto; font-size: 18px; line-height: 1.8; opacity: 0.8; }

        /* Transition Area */
        .transition-area {
            background-color: var(--sage);
            color: white;
            padding: 120px 20px;
            text-align: center;
        }

        .transition-area h2 { font-family: 'Playfair Display', serif; font-size: 48px; margin-bottom: 40px; }
        .btn-shop {
            background: white;
            color: var(--sage);
            padding: 20px 50px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
            transition: 0.3s ease;
            display: inline-block;
        }
        .btn-shop:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(0,0,0,0.15); }
    </style>
</head>
<body>

<nav>
    <div class="logo">LUVANA</div>
    <div class="nav-right">
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="admin.php" class="admin-link">ADMIN PANEL</a>
        <?php endif; ?>

        <div id="cart-counter">Basket: 0</div>
        <a href="logout.php" style="text-decoration:none; color:var(--earth); font-size:14px;">Logout</a>
    </div>
</nav>

<section class="hero">
    <span>✨ 100% Organic & Handcrafted</span>
    <h1>LUVANA</h1>
    <div class="tagline">Love, Life!</div>
    <p>Handcrafted organic melt and pour soaps, made with love and pure natural ingredients.</p>
</section>

<section class="organic-info">
    <span style="letter-spacing:2px; font-weight:bold; font-size:12px;">ECO-FRIENDLY INITIATIVE</span>
    <h2>Seedable Newspaper Packaging</h2>
    <p>Every LUVANA soap bar comes wrapped in seedable newspaper packaging that you can plant after use.</p>
</section>

<section class="transition-area">
    <h2>Ready to Experience Purity?</h2>
    <a href="products.php" class="btn-shop">Enter Our Signature Collection</a>
</section>

</body>
</html>