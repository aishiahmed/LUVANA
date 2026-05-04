<?php
session_start();
include('db.php');

// Check if the specific cart row ID is provided
if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $cart_row_id = mysqli_real_escape_string($conn, $_GET['id']);
    $user_id = $_SESSION['user_id'];

    // ONLY update the specific row matching this ID for this user
    $sql = "UPDATE cart SET status = 'canceled' 
            WHERE id = '$cart_row_id' AND user_id = '$user_id'";
    
    if (mysqli_query($conn, $sql)) {
        // Redirect back to the cart
        header("Location: cart.php?status=item_canceled");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    header("Location: cart.php");
}
exit();
?>