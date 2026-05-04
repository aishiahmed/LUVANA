<?php
session_start();
include('db.php');

/** * LUVANA SHOP - ADD TO CART LOGIC
 * This script handles adding products like the Charcoal Detox Bar 
 * to 'Your Nature's Glow Selection'
 */

// 1. Security Check: User must be logged in to access the cart
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?error=login_required");
    exit();
}

if (isset($_POST['product_id'])) {
    $user_id = $_SESSION['user_id'];
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    
    // 2. Capture customization data (Color/Shape) from products.php
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $item_color = isset($_POST['color']) ? mysqli_real_escape_string($conn, $_POST['color']) : 'Default';
    $item_shape = isset($_POST['shape']) ? mysqli_real_escape_string($conn, $_POST['shape']) : 'Default';

    // 3. Check if this exact customized item is already active in the cart
    $check_query = "SELECT * FROM cart 
                    WHERE user_id = '$user_id' 
                    AND product_id = '$product_id' 
                    AND color = '$item_color' 
                    AND shape = '$item_shape' 
                    AND status = 'active'";
    
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        // Update quantity if the item is already there
        $update_sql = "UPDATE cart SET quantity = quantity + $quantity 
                       WHERE user_id = '$user_id' AND product_id = '$product_id' 
                       AND color = '$item_color' AND shape = '$item_shape' AND status = 'active'";
        mysqli_query($conn, $update_sql);
    } else {
        // 4. Insert as a new item for the Luvana collection
        $insert_query = "INSERT INTO cart (user_id, product_id, quantity, color, shape, status) 
                         VALUES ('$user_id', '$product_id', '$quantity', '$item_color', '$item_shape', 'active')";
        
        if (!mysqli_query($conn, $insert_query)) {
            die("Database Error: " . mysqli_error($conn));
        }
    }

    // 5. Success! Redirect to see 'Your Nature's Glow Selection'
    header("Location: cart.php?status=success");
    exit();
} else {
    // Redirect if accessed directly
    header("Location: products.php");
    exit();
}
?>