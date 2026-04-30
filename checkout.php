<?php
session_start();
include('db.php'); // Uses your database connection

// Ensure the user is logged in before allowing checkout
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Pull the dynamic total from the cart!
$cart_subtotal = isset($_SESSION['cart_total']) ? $_SESSION['cart_total'] : 0; 

// Add shipping if they actually have items in their cart
$shipping = ($cart_subtotal > 0) ? 5.00 : 0.00;
$order_total = $cart_subtotal + $shipping;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUVANA | Secure Checkout</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lexend:wght@300;400;600&display=swap');

        :root {
            --sage: #8A9A5B;
            --dark: #4B371C;
            --cream: #FAF9F6;
        }

        body {
            font-family: 'Lexend', sans-serif;
            background-color: var(--cream);
            color: var(--dark);
            margin: 0;
            padding: 40px 20px;
        }

        .checkout-container {
            max-width: 900px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 350px;
            gap: 30px;
        }

        .payment-section, .summary-section {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            border: 1px solid #f0f0f0;
        }

        h2 { font-family: 'Playfair Display', serif; margin-bottom: 20px; color: var(--sage); }

        /* Payment Method Selectors */
        .payment-methods { display: flex; gap: 15px; margin-bottom: 25px; }
        .method-card {
            flex: 1;
            border: 2px solid #eee;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }
        .method-card.active { border-color: var(--sage); background: #f9fbf2; }

        /* Form Styling */
        .input-group { margin-bottom: 15px; }
        label { display: block; font-size: 11px; font-weight: 800; margin-bottom: 5px; color: #bbb; text-transform: uppercase; letter-spacing: 1px; }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #eee;
            border-radius: 8px;
            box-sizing: border-box;
            background: #fafafa;
        }
        input:focus { border-color: var(--sage); outline: none; background: #fff; }

        .btn-pay {
            background: var(--sage);
            color: white;
            width: 100%;
            padding: 18px;
            border: none;
            border-radius: 50px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.3s;
        }
        .btn-pay:hover { background: #76884b; transform: translateY(-2px); }

        .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
        .total { font-weight: 800; font-size: 22px; color: var(--sage); border-top: 1px solid #eee; padding-top: 15px; margin-top: 15px; }
    </style>
</head>
<body>

<div class="checkout-container">
    <div class="payment-section">
        <h2>Secure Payment</h2>
        
        <div class="payment-methods">
            <div class="method-card active">💳 Credit Card</div>
            <div class="method-card">🅿️ PayPal</div>
        </div>

        <form action="payment_logic.php" method="POST">
            <div class="input-group">
                <label>Cardholder Name</label>
                <input type="text" name="card_name" placeholder="Name on card" required>
            </div>
            <div class="input-group">
                <label>Card Number</label>
                <input type="text" name="card_number" placeholder="xxxx xxxx xxxx xxxx" required>
            </div>
            <div style="display:flex; gap:15px;">
                <div class="input-group" style="flex:2;">
                    <label>Expiration</label>
                    <input type="text" name="expiry" placeholder="MM/YY" required>
                </div>
                <div class="input-group" style="flex:1;">
                    <label>CVV</label>
                    <input type="password" name="cvv" placeholder="***" required>
                </div>
            </div>
            <button type="submit" class="btn-pay">Pay $<?php echo number_format($order_total, 2); ?></button>
        </form>
    </div>

    <div class="summary-section">
        <h2>Your Order</h2>
        <div class="summary-row"><span>Cart Items Subtotal</span><span>$<?php echo number_format($cart_subtotal, 2); ?></span></div>
        <div class="summary-row"><span>Shipping</span><span>$<?php echo number_format($shipping, 2); ?></span></div>
        <div class="summary-row total"><span>Total</span><span>$<?php echo number_format($order_total, 2); ?></span></div>
        <p style="font-size: 12px; color: #888; margin-top: 20px;">
            Includes seedable newspaper packaging! 🌿
        </p>
    </div>
</div>

</body>
</html>