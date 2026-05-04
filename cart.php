<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = (int) $_SESSION['user_id'];
$grand_total = 0;

// Fetch active items and join with products table
$query = "SELECT cart.id AS cart_id, products.name, products.price, cart.quantity, cart.color, cart.shape 
          FROM cart 
          JOIN products ON cart.product_id = products.id 
          WHERE cart.user_id = '$user_id' AND cart.status = 'active'";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Luvana | Your Cart</title>

    <style>
        body {
            font-family: 'Lexend', sans-serif;
            background-color: #f4f7f6;
            color: #4F5D2F;
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

        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-weight: bold;
            font-size: 1.5em;
            color: #4B371C;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .nav-link {
            text-decoration: none;
            color: #4F5D2F;
            font-weight: bold;
        }

        .nav-link:hover {
            color: #8A9A5B;
        }

        .logout-btn {
            text-decoration: none;
            color: #d9534f;
            font-weight: bold;
            border: 1.5px solid #d9534f;
            padding: 8px 20px;
            border-radius: 20px;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #d9534f;
            color: white;
        }

        .cart-container {
            width: 90%;
            max-width: 1100px;
            margin: 50px auto;
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        h1 {
            font-family: 'Playfair Display', serif;
            color: #4B371C;
            margin-bottom: 30px;
        }

        .mood-box {
            background: #f9fbf2;
            border: 1px dashed #8A9A5B;
            border-radius: 15px;
            padding: 18px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .mood-box p {
            margin: 0;
            color: #4B371C;
            font-weight: bold;
        }

        .mood-btn {
            background: #8A9A5B;
            color: white;
            padding: 10px 22px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .mood-btn:hover {
            background: #76884b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #8A9A5B;
            color: white;
            padding: 15px;
            text-align: left;
        }

        td {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .product-info {
            font-weight: bold;
            display: block;
        }

        .custom-details {
            font-size: 0.85em;
            color: #777;
        }

        .total-row {
            font-size: 1.5em;
            font-weight: bold;
            text-align: right;
            padding-top: 30px;
            color: #4B371C;
        }

        .cancel-btn {
            color: #d9534f;
            text-decoration: none;
            font-weight: bold;
            border: 1px solid #d9534f;
            padding: 6px 12px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .cancel-btn:hover {
            background: #d9534f;
            color: white;
        }

        .checkout-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            gap: 15px;
            flex-wrap: wrap;
        }

        .left-actions {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            align-items: center;
        }

        .shop-more-link {
            color: #8A9A5B;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1em;
            transition: 0.3s;
        }

        .shop-more-link:hover {
            text-decoration: underline;
            color: #4F5D2F;
        }

        .bkash-btn {
            background-color: #D12053;
            color: white;
            padding: 15px 40px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1em;
            transition: 0.3s;
        }

        .bkash-btn:hover {
            background-color: #a01840;
            transform: translateY(-2px);
        }

        .empty-msg {
            text-align: center;
            padding: 50px;
            font-size: 1.2em;
        }

        .empty-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .empty-actions a {
            text-decoration: none;
            font-weight: bold;
            padding: 12px 25px;
            border-radius: 25px;
        }

        .return-btn {
            background: #8A9A5B;
            color: white;
        }

        .empty-mood-btn {
            background: #4B371C;
            color: white;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <a href="dashboard.php" class="nav-logo">LUVANA</a>

    <div class="nav-links">
        <a href="products.php" class="nav-link">Shop</a>
        <a href="mood_suggestion.php" class="nav-link">Mood Suggestion</a>
        <a href="cart.php" class="nav-link">Cart</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</nav>

<div class="cart-container">
    <h1>Your Nature's Glow Selection</h1>

    <div class="mood-box">
        <p>Not sure what to add next? Get a soap suggestion based on your mood.</p>
        <a href="mood_suggestion.php" class="mood-btn">Find Soap by Mood</a>
    </div>
    
    <?php if ($result && mysqli_num_rows($result) > 0): ?>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php while ($item = mysqli_fetch_assoc($result)): 
                    $subtotal = $item['price'] * $item['quantity']; 
                    $grand_total += $subtotal;
                ?>

                <tr>
                    <td>
                        <span class="product-info">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </span>

                        <span class="custom-details">
                            Style: <?php echo htmlspecialchars($item['color']); ?> |
                            Shape: <?php echo htmlspecialchars($item['shape']); ?>
                        </span>
                    </td>

                    <td>$<?php echo number_format($item['price'], 2); ?></td>

                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>

                    <td>$<?php echo number_format($subtotal, 2); ?></td>

                    <td>
                        <a href="cancel_item.php?id=<?php echo htmlspecialchars($item['cart_id']); ?>" class="cancel-btn">
                            Cancel
                        </a>
                    </td>
                </tr>

                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="total-row">
            Grand Total:
            <span style="margin-left: 50px;">
                $<?php echo number_format($grand_total, 2); ?>
            </span>
        </div>

        <div class="checkout-section">
            <div class="left-actions">
                <a href="products.php" class="shop-more-link">← Continue Shopping</a>
                <a href="mood_suggestion.php" class="shop-more-link">Find Another Soap by Mood</a>
            </div>

            <a href="checkout.php?amount=<?php echo urlencode($grand_total); ?>" class="bkash-btn">
                Pay with bKash
            </a>
        </div>

    <?php else: ?>

        <div class="empty-msg">
            <p>Your cart is empty.</p>

            <div class="empty-actions">
                <a href="products.php" class="return-btn">Return to Shop</a>
                <a href="mood_suggestion.php" class="empty-mood-btn">Get Mood Suggestion</a>
            </div>
        </div>

    <?php endif; ?>
</div>

</body>
</html>