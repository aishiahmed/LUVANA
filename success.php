<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luvana | Order Confirmed</title>
    <style>
        :root { --sage: #8A9A5B; --earth: #4B371C; --cream: #FAF9F6; }
        
        body { 
            font-family: 'Lexend', sans-serif; 
            background-color: var(--cream); 
            margin: 0; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            overflow: hidden;
        }

        .success-container {
            background: white;
            padding: 60px;
            border-radius: 40px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.05);
            max-width: 500px;
            width: 90%;
            animation: slideUp 0.8s cubic-bezier(0.17, 0.67, 0.83, 0.67);
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(50px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .icon-circle {
            width: 100px;
            height: 100px;
            background: #f0f4e8;
            color: var(--sage);
            font-size: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 30px;
            animation: scaleIn 0.5s 0.8s both;
        }

        @keyframes scaleIn {
            from { transform: scale(0); }
            to { transform: scale(1); }
        }

        h1 { 
            font-family: 'Playfair Display', serif; 
            color: var(--earth); 
            font-size: 36px; 
            margin-bottom: 15px; 
        }

        p { color: #777; line-height: 1.6; font-size: 16px; margin-bottom: 5px; }

        .order-id { 
            font-weight: bold; 
            color: var(--sage); 
            margin: 25px 0; 
            display: block; 
            letter-spacing: 1px;
            text-transform: uppercase;
            font-size: 14px;
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-return {
            display: inline-block;
            background: var(--sage);
            color: white;
            padding: 18px 45px;
            border-radius: 35px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
            box-shadow: 0 10px 20px rgba(138, 154, 91, 0.2);
        }

        .btn-return:hover { 
            background: #76884b; 
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(138, 154, 91, 0.3);
        }

        .btn-dashboard {
            color: var(--earth);
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            opacity: 0.7;
            transition: 0.3s;
        }

        .btn-dashboard:hover { opacity: 1; }
    </style>
</head>
<body>

<div class="success-container">
    <div class="icon-circle">🌿</div>
    
    <h1>Order Confirmed!</h1>
    <p>Your payment was successful.</p>
    <p>We are now preparing your organic selection with care.</p>
    
    <span class="order-id">Reference: #LUV-<?php echo rand(1000, 9999); ?></span>
    
    <div class="button-group">
        <a href="products.php" class="btn-return">Continue Shopping</a>
        <a href="dashboard.php" class="btn-dashboard">Back to Dashboard</a>
    </div>
</div>

</body>
</html>