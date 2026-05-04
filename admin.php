<?php
session_start();
include('db.php');

// Security Lock
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { 
    header("Location: dashboard.php"); 
    exit(); 
}

// --- 1. HANDLE SAVING ---
if (isset($_POST['save_product'])) {
    $id = $_POST['product_id']; 
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = $_POST['price'];
    $image = mysqli_real_escape_string($conn, $_POST['image_url']);

    if (!empty($id)) {
        $sql = "UPDATE products SET name='$name', description='$desc', price='$price', image_url='$image' WHERE id=$id";
    } else {
        $sql = "INSERT INTO products (name, description, price, image_url) VALUES ('$name', '$desc', '$price', '$image')";
    }
    mysqli_query($conn, $sql);
    header("Location: admin.php?success=1");
    exit();
}

// --- 2. HANDLE DELETION ---
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    mysqli_query($conn, "DELETE FROM products WHERE id = $delete_id");
    header("Location: admin.php?deleted=1");
    exit();
}

// --- 3. FETCH DATA IF EDITING ---
$edit_data = ['id'=>'','name'=>'','description'=>'','price'=>'','image_url'=>''];
if (isset($_GET['edit_id'])) {
    $res = mysqli_query($conn, "SELECT * FROM products WHERE id = " . intval($_GET['edit_id']));
    if ($res) {
        $edit_data = mysqli_fetch_assoc($res);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LUVANA | Admin Panel</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Lexend:wght@300;400;600;800&display=swap');

        :root {
            --primary: #8A9A5B;
            --dark: #4B371C;
            --danger: #FF4757;
            --white: #ffffff;
        }

        body {
            font-family: 'Lexend', sans-serif;
            background: #f8f9fa;
            color: var(--dark);
            margin: 0;
            padding: 40px 20px;
        }

        .container { max-width: 850px; margin: 0 auto; }

        /* HEADER DESIGN */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: var(--white);
            padding: 20px 40px;
            border-radius: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        header h1 { font-family: 'Playfair Display', serif; font-size: 24px; margin: 0; }
        header h1 span { color: var(--primary); font-weight: 400; font-size: 16px; margin-left: 10px; }

        .exit-btn {
            background: var(--dark);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 13px;
            transition: 0.3s ease;
        }
        .exit-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

        /* SECTION CARDS */
        .glass-card {
            background: var(--white);
            padding: 40px;
            border-radius: 30px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.03);
            margin-bottom: 30px;
            border: 1px solid #eee;
        }

        .glass-card h2 {
            font-size: 22px;
            margin-top: 0;
            margin-bottom: 25px;
            color: var(--primary);
            font-family: 'Playfair Display', serif;
        }

        /* FORM STYLING */
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 800; font-size: 11px; text-transform: uppercase; color: #bbb; margin-bottom: 8px; letter-spacing: 1px; }
        
        input, textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #f1f1f1;
            border-radius: 15px;
            background: #fafafa;
            font-family: inherit;
            box-sizing: border-box;
        }
        input:focus, textarea:focus { border-color: var(--primary); outline: none; background: white; }

        .btn-main {
            background: var(--primary);
            color: white;
            border: none;
            width: 100%;
            padding: 18px;
            border-radius: 15px;
            font-weight: 800;
            cursor: pointer;
            transition: 0.3s;
            font-size: 15px;
            margin-top: 10px;
        }
        .btn-main:hover { background: #7a8a50; }

        /* INVENTORY LIST */
        .inventory-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            padding: 15px;
            margin-bottom: 12px;
            border-radius: 20px;
            border: 1px solid #f5f5f5;
            transition: 0.3s;
        }
        .inventory-item:hover { border-color: var(--primary); transform: translateX(5px); }

        .item-info { display: flex; align-items: center; gap: 15px; }
        .item-img { width: 55px; height: 55px; border-radius: 12px; object-fit: cover; }
        .item-details h4 { margin: 0; font-size: 15px; }
        .item-details span { font-size: 13px; font-weight: 800; color: var(--primary); }

        .actions { display: flex; gap: 8px; }
        .action-btn {
            padding: 8px 15px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            font-size: 11px;
        }
        .edit { background: #f0f4e8; color: var(--primary); }
        .del { background: #fff1f0; color: var(--danger); }

    </style>
</head>
<body>

<div class="container">
    
    <header>
        <h1>LUVANA <span>Admin Management</span></h1>
        <a href="dashboard.php" class="exit-btn">← Back to Site</a>
    </header>

    <section class="glass-card">
        <h2><?php echo $edit_data['id'] ? "✨ Edit Product" : "🌿 New Product Entry"; ?></h2>
        <form method="POST">
            <input type="hidden" name="product_id" value="<?php echo $edit_data['id']; ?>">
            
            <div class="form-group">
                <label>Soap Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($edit_data['name']); ?>" required>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <div class="form-group">
                    <label>Price (USD)</label>
                    <input type="number" step="0.01" name="price" value="<?php echo $edit_data['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Image File (image.png)</label>
                    <input type="text" name="image_url" value="<?php echo htmlspecialchars($edit_data['image_url']); ?>" required>
                </div>
            </div>

            <div class="form-group">
                <label>Description</label>
                <textarea name="description" rows="3" required><?php echo htmlspecialchars($edit_data['description']); ?></textarea>
            </div>

            <button type="submit" name="save_product" class="btn-main">
                <?php echo $edit_data['id'] ? "UPDATE PRODUCT" : "PUBLISH TO SHOP"; ?>
            </button>
            
            <?php if (!empty($edit_data['id'])): ?>
                <a href="admin.php" style="display:block; text-align:center; margin-top:10px; color:var(--danger); text-decoration:none; font-size:12px; font-weight:bold;">Discard Edit</a>
            <?php endif; ?>
        </form>
    </section>

    <section class="glass-card">
        <h2>📦 Live Inventory</h2>
        <div class="inventory-list">
            <?php
            $result = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
            while($row = mysqli_fetch_assoc($result)): ?>
            <div class="inventory-item">
                <div class="item-info">
                    <img src="image/<?php echo $row['image_url']; ?>" class="item-img" onerror="this.src='https://via.placeholder.com/100'">
                    <div class="item-details">
                        <h4><?php echo $row['name']; ?></h4>
                        <span>$<?php echo number_format($row['price'], 2); ?></span>
                    </div>
                </div>
                <div class="actions">
                    <a href="admin.php?edit_id=<?php echo $row['id']; ?>" class="action-btn edit">Edit</a>
                    <a href="admin.php?delete_id=<?php echo $row['id']; ?>" class="action-btn del" onclick="return confirm('Delete this product?')">Delete</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </section>

</div>

</body>
</html>