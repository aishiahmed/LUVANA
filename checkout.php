<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
// Fetch the total again to ensure accuracy
$query = "SELECT SUM(products.price * cart.quantity) AS total 
          FROM cart JOIN products ON cart.product_id = products.id 
          WHERE cart.user_id = '$user_id' AND cart.status = 'active'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_amount = $row['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>bKash Payment | Luvana</title>
    <style>
        body { font-family: 'Lexend', sans-serif; background-color: #f4f7f6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .payment-card { background: white; padding: 40px; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); text-align: center; width: 400px; }
        .bkash-logo { width: 150px; margin-bottom: 10px; }
        h2 { color: #4B371C; font-size: 1.4em; margin-bottom: 20px; }
        .amount-box { background: #fff0f5; border: 1px dashed #D12053; padding: 15px; margin: 20px 0; font-size: 1.6em; font-weight: bold; color: #D12053; border-radius: 10px; }
        .input-field { width: 90%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; font-size: 1em; }
        .pay-btn { background-color: #D12053; color: white; border: none; padding: 15px; border-radius: 10px; cursor: pointer; width: 100%; font-size: 1.1em; font-weight: bold; transition: 0.3s; }
        .pay-btn:hover { background-color: #a01840; }
    </style>
</head>
<body>

<div class="payment-card">
    <img src="https://www.logo.wine/a/logo/BKash/BKash-bKash-Logo.wine.svg" class="bkash-logo" alt="bKash">
    <h2>Merchant: Luvana Organic Soaps</h2>
    <p style="color: #666;">Confirm your selection of nature's glow.</p>
    
    <div class="amount-box">
        BDT <?php echo number_format($total_amount, 2); ?>
    </div>

    <input type="text" id="bkash_num" class="input-field" placeholder="Enter bKash Number" required>
    <input type="password" id="pin" class="input-field" placeholder="Enter PIN" required>
    
    <button type="button" onclick="processPayment()" class="pay-btn">Confirm Payment</button>
</div>

<script>
function processPayment() {
    const num = document.getElementById('bkash_num').value;
    const pin = document.getElementById('pin').value;

    if(num === "" || pin === "") {
        alert("Please fill in all payment details.");
        return;
    }

    // Instead of a browser alert, we redirect to our new success page
    window.location.href = "success.php";
}
</script>

</body>
</html>