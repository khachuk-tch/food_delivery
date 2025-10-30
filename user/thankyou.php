
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get order id if needed
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added for mobile responsiveness -->
    <title>Thank You</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .thankyou-card {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .thankyou-card h1 {
            font-size: 2.5rem;
            color: #28a745;
        }
        .thankyou-card p {
            margin-top: 20px;
            font-size: 1.2rem;
            color: #555;
        }
    </style>
</head>
<body>

<div class="thankyou-card">
    <h1>🎉 Thank You!</h1>
    <p>Your order has been placed successfully!</p>
    <?php if ($order_id): ?>
        <p><strong>Order ID:</strong> #<?= $order_id ?></p>
    <?php endif; ?>
    <a href="menu.php" class="btn btn-primary mt-4">🍽️ Continue Shopping</a>
</div>

</body>
</html>
