<?php
session_start();
include('db.php');

if(isset($_POST['bkash_number'])) {
    $user_id = $_SESSION['user_id'];
    
    // In a real app, you would verify with bKash API here.
    // For now, we update your database status column
    $update_query = "UPDATE cart SET status = 'ordered' WHERE user_id = '$user_id' AND status = 'active'";
    
    if(mysqli_query($conn, $update_query)) {
        echo "<script>alert('Payment Successful! Your Luvana Soaps are on the way.'); window.location='products.php';</script>";
    } else {
        echo "Error updating order: " . mysqli_error($conn);
    }
}
?>