<?php
session_start();
include('db.php'); // Connects to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect the user and payment info
    $user_id = $_SESSION['user_id'];
    $status = "Confirmed";
    
    // In a real application, you would iterate through the cart.
    // Here we simulate saving a checkout event.
    $sql = "INSERT INTO custom_orders (user_id, product_id, quantity, order_status) 
            VALUES ('$user_id', '1', '1', '$status')";

    if (mysqli_query($conn, $sql)) {
        
        // --- NEW LOGIC: CLEAR THE CART AFTER PAYMENT ---
        unset($_SESSION['cart']);
        unset($_SESSION['cart_total']);

        echo "<script>
                alert('Payment Successful! Your LUVANA soap is being prepared.'); 
                window.location='dashboard.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>