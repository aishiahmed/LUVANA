<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
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
        body { font-family: 'Lexend', sans-serif; background-color: #f4f7f6; color: #4F5D2F; margin: 0; padding: 0; }
        
        /* Navigation Bar Styles */
        .navbar { 
            background: white; 
            padding: 15px 5%; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
        }
        .nav-logo { font-family: 'Playfair Display', serif; font-weight: bold; font-size: 1.5em; color: #4B371C; text-decoration: none; }
        .logout-btn { 
            text-decoration: none; 
            color: #d9534f; 
            font-weight: bold; 
            border: 1.5px solid #d9534f; 
            padding: 8px 20px; 
            border-radius: 20px; 
            transition: 0.3s; 
        }
        .logout-btn:hover { background: #d9534f; color: white; }

        .cart-container { width: 90%; max-width: 1100px; margin: 50px auto; background: white; padding: 40px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        h1 { font-family: 'Playfair Display', serif; color: #4B371C; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #8A9A5B; color: white; padding: 15px; text-align: left; }
        td { padding: 15px; border-bottom: 1px solid #eee; }
        .product-info { font-weight: bold; display: block; }
        .custom-details { font-size: 0.85em; color: #777; }
        .total-row { font-size: 1.5em; font-weight: bold; text-align: right; padding-top: 30px; color: #4B371C; }
        .cancel-btn { color: #d9534f; text-decoration: none; font-weight: bold; border: 1px solid #d9534f; padding: 6px 12px; border-radius: 8px; transition: 0.3s; }
        .cancel-btn:hover { background: #d9534f; color: white; }
        
        .checkout-section { display: flex; justify-content: space-between; align-items: center; margin-top: 40px; }
        .shop-more-link { color: #8A9A5B; text-decoration: none; font-weight: bold; font-size: 1.1em; transition: 0.3s; }
        .shop-more-link:hover { text-decoration: underline; color: #4F5D2F; }

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
        .bkash-btn:hover { background-color: #a01840; transform: translateY(-2px); }
        .empty-msg { text-align: center; padding: 50px; font-size: 1.2em; }
    </style>
</head>
<body>

<nav class="navbar">
    <a href="products.php" class="nav-logo">LUVANA</a>
    <div>
        <a href="products.php" style="margin-right: 25px; text-decoration: none; color: #4F5D2F; font-weight: bold;">Shop</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</nav>

<div class="cart-container">
    <h1>Your Nature's Glow Selection</h1>
    
    <?php if(mysqli_num_rows($result) > 0): ?>
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
                <?php while($item = mysqli_fetch_assoc($result)): 
                    $subtotal = $item['price'] * $item['quantity']; 
                    $grand_total += $subtotal;
                ?>
                <tr>
                    <td>
                        <span class="product-info"><?php echo $item['name']; ?></span>
                        <span class="custom-details">
                            Style: <?php echo $item['color']; ?> | Shape: <?php echo $item['shape']; ?>
                        </span>
                    </td>
                    <td>$<?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>$<?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <a href="cancel_item.php?id=<?php echo $item['cart_id']; ?>" class="cancel-btn">Cancel</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="total-row">
            Grand Total: <span style="margin-left: 50px;">$<?php echo number_format($grand_total, 2); ?></span>
        </div>

        <div class="checkout-section">
            <a href="products.php" class="shop-more-link">← Continue Shopping</a>
            <a href="checkout.php?amount=<?php echo $grand_total; ?>" class="bkash-btn">Pay with bKash</a>
        </div>

    <?php else: ?>
        <div class="empty-msg">
            <p>Your cart is empty.</p>
            <a href="products.php" style="color: #8A9A5B; font-weight: bold;">Return to Shop</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>