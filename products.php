<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Search support for mood_suggestion.php
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUVANA | Our Collection</title>

    <style>
        :root {
            --sage: #8A9A5B;
            --earth: #4B371C;
            --cream: #FAF9F6;
        }

        body {
            font-family: 'Lexend', sans-serif;
            background-color: var(--cream);
            color: var(--earth);
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
            position: sticky;
            top: 0;
            z-index: 1100;
        }

        .nav-left {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--earth);
            font-weight: bold;
        }

        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-weight: bold;
            font-size: 1.5em;
            color: var(--earth);
            text-decoration: none;
        }

        .nav-link {
            text-decoration: none;
            color: var(--earth);
            font-weight: bold;
        }

        .nav-link:hover {
            color: var(--sage);
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

        .header {
            text-align: center;
            padding: 60px 0 30px 0;
        }

        .header h1 {
            font-family: 'Playfair Display', serif;
            font-size: 45px;
            margin-bottom: 5px;
        }

        .search-box {
            text-align: center;
            margin-bottom: 20px;
        }

        .search-box a {
            color: var(--sage);
            font-weight: bold;
            text-decoration: none;
        }

        .ai-float-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: var(--sage);
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 50px;
            font-weight: bold;
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
            cursor: pointer;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }

        .ai-float-btn:hover {
            transform: scale(1.05);
            background: #76884b;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
        }

        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 20px;
            width: 90%;
            max-width: 500px;
            text-align: center;
            position: relative;
        }

        .close {
            position: absolute;
            right: 20px;
            top: 15px;
            font-size: 24px;
            cursor: pointer;
        }

        .ai-select {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin: 15px 0;
        }

        .ai-reason-box {
            display: none;
            margin-top: 20px;
            padding: 15px;
            background: #f9fbf2;
            border: 1px dashed var(--sage);
            border-radius: 15px;
            text-align: left;
        }

        .product-grid {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .card {
            background: white;
            border-radius: 20px;
            width: 320px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: 0.3s;
            padding-bottom: 20px;
            border: 1px solid #f0f0f0;
            position: relative;
        }

        .card.highlight {
            border: 3px solid var(--sage);
            transform: scale(1.05);
            box-shadow: 0 15px 30px rgba(138, 154, 91, 0.3);
            z-index: 10;
        }

        .card img {
            width: 100%;
            height: 280px;
            object-fit: cover;
        }

        .card-content {
            padding: 20px;
            text-align: center;
        }

        .card-content h3 {
            margin: 10px 0;
            font-family: 'Playfair Display', serif;
            font-size: 22px;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            color: var(--sage);
            margin-top: 10px;
        }

        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            padding: 0 20px;
        }

        .btn {
            padding: 12px;
            border-radius: 30px;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            font-size: 14px;
            width: 100%;
        }

        .btn-custom {
            background: white;
            border: 1px solid var(--sage);
            color: var(--sage);
        }

        .btn-cart {
            background: var(--sage);
            color: white;
        }

        .custom-box {
            display: none;
            background: #f9fbf2;
            margin: 15px 20px;
            padding: 15px;
            border-radius: 15px;
            border: 1px dashed var(--sage);
            text-align: left;
            font-size: 13px;
        }

        .input-label {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 11px;
            color: #888;
            display: block;
            margin-bottom: 5px;
            margin-top: 10px;
        }

        .radio-group {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 10px;
        }

        .qty-input {
            width: 90%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-family: inherit;
        }

        .no-products {
            text-align: center;
            font-size: 18px;
            padding: 40px;
            color: #777;
        }
    </style>
</head>

<body>

<nav class="navbar">
    <a href="dashboard.php" class="nav-left">
        <span style="font-size: 1.5em;">&#8592;</span> Back to Dashboard
    </a>

    <a href="products.php" class="nav-logo">LUVANA</a>

    <div style="display: flex; align-items: center; gap: 20px;">
        <a href="mood_suggestion.php" class="nav-link">Mood Suggestion</a>
        <a href="cart.php" class="nav-link">View Cart</a>
        <a href="logout.php" class="logout-btn">Logout</a>
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

        <button class="btn btn-cart" onclick="getAISuggestion()">Analyze Skin</button>

        <div id="aiReasonBox" class="ai-reason-box">
            <p id="suggestionText"></p>
            <button class="btn btn-custom" id="goToProductBtn">View Recommended Product</button>
        </div>
    </div>
</div>

<div class="header">
    <h1>The Signature Collection</h1>
    <p>Dynamic Organic Purity</p>
</div>

<?php if ($search != ''): ?>
    <div class="search-box">
        Showing suggested products for:
        <strong><?php echo htmlspecialchars($search); ?></strong>
        <br><br>
        <a href="products.php">Show All Products</a>
    </div>
<?php endif; ?>

<div class="product-grid">
    <?php
    if ($search != '') {
        $search_safe = "%" . $search . "%";

        $stmt = mysqli_prepare($conn, "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
        mysqli_stmt_bind_param($stmt, "ss", $search_safe, $search_safe);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    } else {
        $result = mysqli_query($conn, "SELECT * FROM products");
    }

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $name_low = strtolower($row['name']);

            if (strpos($name_low, 'charcoal') !== false) {
                $id_tag = "acne-prod";
            } elseif (strpos($name_low, 'neem') !== false) {
                $id_tag = "rough-prod";
            } elseif (strpos($name_low, 'rose') !== false) {
                $id_tag = "dry-prod";
            } else {
                $id_tag = "aging-prod";
            }
    ?>

    <div class="card" id="<?php echo $id_tag; ?>">
        <img src="image/<?php echo htmlspecialchars($row['image_url']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">

        <div class="card-content">
            <h3><?php echo htmlspecialchars($row['name']); ?></h3>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
            <div class="price">$<?php echo htmlspecialchars($row['price']); ?></div>
        </div>

        <form action="add_to_cart.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($row['id']); ?>">

            <div class="btn-group">
                <button type="button" class="btn" style="background:#f0f0f0;">Details</button>
                <button type="button" class="btn btn-custom" onclick="toggleCustom('custom<?php echo $row['id']; ?>')">Customize</button>
                <button type="submit" class="btn btn-cart">Add to Cart</button>
            </div>

            <div id="custom<?php echo $row['id']; ?>" class="custom-box">
                <span class="input-label">Color:</span>

                <div class="radio-group">
                    <label><input type="radio" name="color" value="Red" checked> Red</label>
                    <label><input type="radio" name="color" value="Lavender"> Lavender</label>
                    <label><input type="radio" name="color" value="Green"> Green</label>
                    <label><input type="radio" name="color" value="Black"> Black</label>
                </div>

                <span class="input-label">Shape:</span>

                <select name="shape" class="ai-select" style="margin:0 0 10px 0;">
                    <option value="Circle">Circle</option>
                    <option value="Floral">Floral</option>
                    <option value="Square">Square</option>
                    <option value="Bubble">Bubble</option>
                </select>

                <span class="input-label">Quantity:</span>
                <input type="number" name="quantity" class="qty-input" value="1" min="1">
            </div>
        </form>
    </div>

    <?php
        }
    } else {
        echo '<div class="no-products">No products found. <br><br><a href="products.php">View All Products</a></div>';
    }
    ?>
</div>

<script>
    function toggleCustom(id) {
        var box = document.getElementById(id);
        box.style.display = (box.style.display === "block") ? "none" : "block";
    }

    function openAI() {
        document.getElementById('aiModal').style.display = "block";
    }

    function closeAI() {
        document.getElementById('aiModal').style.display = "none";
    }

    function getAISuggestion() {
        const problem = document.getElementById('skinProblem').value;
        const text = document.getElementById('suggestionText');
        let matchId = "";

        if (problem === "acne") {
            text.innerHTML = "<b>Charcoal Detox Bar</b> is perfect for you. Activated charcoal draws out impurities and unclogs pores.";
            matchId = "acne-prod";
        } else if (problem === "dry") {
            text.innerHTML = "We recommend <b>Rose Bloom Soap</b> for deep hydration and soothing sensitive skin.";
            matchId = "dry-prod";
        } else if (problem === "rough") {
            text.innerHTML = "<b>Neem Cleanse Bar</b> helps fight bacteria and smooths rough textures.";
            matchId = "rough-prod";
        } else if (problem === "aging") {
            text.innerHTML = "Our <b>Massage Soap</b> stimulates circulation to rejuvenate dull skin.";
            matchId = "aging-prod";
        } else {
            text.innerHTML = "Please select a skin concern first.";
        }

        if (matchId) {
            document.getElementById('aiReasonBox').style.display = "block";

            document.getElementById('goToProductBtn').onclick = function() {
                closeAI();

                document.querySelectorAll('.card').forEach(function(card) {
                    card.classList.remove('highlight');
                });

                const target = document.getElementById(matchId);

                if (target) {
                    target.classList.add('highlight');
                    target.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    alert("Recommended product is not visible right now. Please click Show All Products first.");
                }
            };
        }
    }
</script>

</body>
</html>