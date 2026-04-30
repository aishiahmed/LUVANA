<?php
ob_start(); // THIS FIXES INVISIBLE REDIRECT ERRORS
session_start();
include('db.php'); 

// Kick user out if they aren't logged in
if (!isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit(); 
}

// --- NEW CART LOGIC ---
// If a cart doesn't exist yet, create an empty one
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
    $_SESSION['cart_total'] = 0;
}

// When the user clicks "Add to Cart"
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_price = (float)$_POST['product_price']; // Force it to be a math number
    
    // Add item to the session cart array and update the total
    $_SESSION['cart'][] = $product_id;
    $_SESSION['cart_total'] += $product_price;
    
    // Refresh the exact page we are on safely
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUVANA | Our Collection</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lexend:wght@300;400;600;800&display=swap');

        :root { --sage: #8A9A5B; --earth: #4B371C; --cream: #FAF9F6; }
        body { font-family: 'Lexend', sans-serif; background-color: var(--cream); color: var(--earth); margin: 0; padding: 0; }
        
        /* Navigation Bar Styles */
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
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .logo { font-family: 'Playfair Display', serif; font-size: 28px; letter-spacing: 4px; font-weight: bold; }
        .nav-right { display: flex; align-items: center; gap: 20px; }
        
        /* Checkout Button in Nav */
        .btn-nav-checkout {
            background: var(--sage);
            color: white;
            text-decoration: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 13px;
            transition: 0.3s;
        }
        .btn-nav-checkout:hover { background: #76884b; transform: translateY(-2px); }

        /* Header Section */
        .header { text-align: center; padding: 60px 0 20px 0; }
        .header h1 { font-family: 'Playfair Display', serif; font-size: 45px; margin-bottom: 5px; }

        /* AI Floating Button */
        .ai-float-btn {
            position: fixed; bottom: 30px; right: 30px; 
            background: var(--sage); color: white; border: none; 
            padding: 15px 25px; border-radius: 50px; font-weight: bold;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2); cursor: pointer; z-index: 1000;
            display: flex; align-items: center; gap: 10px; transition: 0.3s;
        }

        /* Modal UI */
        .modal { display: none; position: fixed; z-index: 1001; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); }
        .modal-content { background: white; margin: 10% auto; padding: 30px; border-radius: 20px; width: 90%; max-width: 500px; text-align: center; position: relative; }
        .close { position: absolute; right: 20px; top: 15px; font-size: 24px; cursor: pointer; }
        .ai-select { width: 100%; padding: 12px; border-radius: 10px; border: 1px solid #ddd; margin: 15px 0; }
        .ai-reason-box { display: none; margin-top: 20px; padding: 15px; background: #f9fbf2; border: 1px dashed var(--sage); border-radius: 15px; text-align: left; }

        /* Product Grid & Cards */
        .product-grid { display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; padding: 40px 20px; max-width: 1200px; margin: 0 auto; }
        .card { background: white; border-radius: 20px; width: 320px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: 0.3s; padding-bottom: 20px; border: 1px solid #f0f0f0; }
        .card.highlight { border: 3px solid var(--sage); transform: scale(1.05); box-shadow: 0 15px 30px rgba(138, 154, 91, 0.3); }
        .card img { width: 100%; height: 280px; object-fit: cover; }
        .card-content { padding: 20px; text-align: center; }
        .card-content h3 { margin: 10px 0; font-family: 'Playfair Display', serif; font-size: 22px; }
        .price { font-size: 20px; font-weight: bold; color: var(--sage); margin-top: 10px; }

        /* Buttons */
        .btn-group { display: flex; flex-direction: column; gap: 8px; padding: 0 20px; }
        .btn { padding: 12px; border-radius: 30px; border: none; font-weight: bold; cursor: pointer; transition: 0.3s; font-size: 14px; text-align: center; text-decoration: none; }
        .btn-custom { background: white; border: 1px solid var(--sage); color: var(--sage); }
        .btn-cart { background: var(--sage); color: white; }
        
        .custom-box { display: none; background: #f9fbf2; margin: 15px 20px; padding: 15px; border-radius: 15px; border: 1px dashed var(--sage); text-align: left; font-size: 13px; }
        .input-label { font-weight: 800; text-transform: uppercase; font-size: 11px; color: #888; display: block; margin-bottom: 5px; margin-top: 10px; }
    </style>
</head>
<body>

    <nav>
        <div class="logo">LUVANA</div>
        <div class="nav-right">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="admin.php" style="text-decoration:none; color:red; font-weight:bold; font-size:12px;">ADMIN</a>
            <?php endif; ?>
            
            <a href="checkout.php" class="btn-nav-checkout">
                PROCEED TO CHECKOUT (<?php echo count($_SESSION['cart']); ?>)
            </a>
            
            <a href="logout.php" style="text-decoration:none; color:var(--earth); font-size:14px;">Logout</a>
        </div>
    </nav>

    <button class="ai-float-btn" onclick="openAI()">✨ AI Skin Consultation</button>

    <div id="aiModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAI()">&times;</span>
            <h2 style="font-family: 'Playfair Display', serif;">AI Skin Consultation</h2>
            <p>Describe your skin concern or pick a problem:</p>
            <select id="skinProblem" class="ai-select">
                <option value="">Select a Concern...</option>
                <option value="acne">Pimple / Acne / Oily Skin</option>
                <option value="dry">Dry / Flaky / Sensitive Skin</option>
                <option value="aging">Aging / Wrinkles / Dullness</option>
                <option value="rough">Rough Texture / Scars</option>
            </select>
            <button class="btn btn-cart" style="width:100%" onclick="getAISuggestion()">Analyze Skin</button>
            <div id="aiReasonBox" class="ai-reason-box">
                <p id="suggestionText"></p>
                <button class="btn btn-custom" style="width:100%" id="goToProductBtn">View Recommended Product</button>
            </div>
        </div>
    </div>

    <div class="header">
        <h1>The Signature Collection</h1>
        <p>Dynamic Organic Purity</p>
    </div>

    <div class="product-grid">
        <?php
        $sql = "SELECT * FROM products";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_assoc($result)) {
            $name_low = strtolower($row['name']);
            $id_tag = (strpos($name_low, 'charcoal') !== false) ? "acne-prod" : 
                     ((strpos($name_low, 'neem') !== false) ? "rough-prod" : 
                     ((strpos($name_low, 'rose') !== false) ? "dry-prod" : "aging-prod"));
        ?>
        <div class="card" id="<?php echo $id_tag; ?>">
            <img src="image/<?php echo $row['image_url']; ?>" alt="Soap">
            <div class="card-content">
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <div class="price">$<?php echo number_format($row['price'], 2); ?></div>
            </div>

            <div class="btn-group">
                <button class="btn" style="background:#f0f0f0;">Details</button>
                <button class="btn btn-custom" onclick="toggleCustom('custom<?php echo $row['id']; ?>')">Customize</button>
                
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="add_to_cart" value="true">
                    
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                    
                    <button type="submit" class="btn btn-cart">Add to Cart</button>
                </form>
            </div>

            <div id="custom<?php echo $row['id']; ?>" class="custom-box">
                <span class="input-label">Color:</span>
                <div style="display:flex; gap:10px; margin-bottom:10px;">
                    <label><input type="radio" name="c<?php echo $row['id']; ?>"> Red</label>
                    <label><input type="radio" name="c<?php echo $row['id']; ?>"> Lavender</label>
                    <label><input type="radio" name="c<?php echo $row['id']; ?>"> Green</label>
                </div>
                <span class="input-label">Shape:</span>
                <select class="ai-select" style="margin:0;">
                    <option>Circle</option>
                    <option>Floral</option>
                    <option>Square</option>
                </select>
            </div>
        </div>
        <?php } ?>
    </div>

    <script>
        function toggleCustom(id) {
            var box = document.getElementById(id);
            box.style.display = (box.style.display === "block") ? "none" : "block";
        }
        function openAI() { document.getElementById('aiModal').style.display = "block"; }
        function closeAI() { document.getElementById('aiModal').style.display = "none"; }
        function getAISuggestion() {
            const problem = document.getElementById('skinProblem').value;
            const text = document.getElementById('suggestionText');
            let matchId = "";
            if (problem === "acne") { text.innerHTML = "<b>Charcoal Detox Bar</b> is perfect for you."; matchId = "acne-prod"; }
            else if (problem === "dry") { text.innerHTML = "We recommend <b>Rose Bloom Soap</b>."; matchId = "dry-prod"; }
            else if (problem === "rough") { text.innerHTML = "<b>Neem Cleanse Bar</b> helps smooth textures."; matchId = "rough-prod"; }
            else if (problem === "aging") { text.innerHTML = "Our <b>Massage Soap</b> rejuvenates skin."; matchId = "aging-prod"; }
            if (matchId) {
                document.getElementById('aiReasonBox').style.display = "block";
                document.getElementById('goToProductBtn').onclick = function() {
                    closeAI();
                    document.querySelectorAll('.card').forEach(c => c.classList.remove('highlight'));
                    const target = document.getElementById(matchId);
                    target.classList.add('highlight');
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                };
            }
        }
    </script>
</body>
</html>
<?php ob_end_flush(); ?>