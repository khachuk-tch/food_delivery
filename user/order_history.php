<?php
session_start();
//require '../config.php';

require_once __DIR__ . '/../includes/config.php'; 

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$orders = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Order History</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }
        footer {
            background: #343a40;
            color: #fff;
            padding: 10px 0;
            text-align: center;
            margin-top: 50px;
        }
        .food-item {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 5px;
        }
        .food-item img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="#">🍔 Food Delivery</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
    <h2 class="mb-4"> <center>📋 My Order History<center></h2>  <a class= "btn btn-primary" href="user_dashboard.php">Back to Dashboard</a> 
           <br>
           <br>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-info"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>

    <?php if ($orders->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#ID</th>
                        <th>Restaurant</th>
                        <th>Items</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($order = $orders->fetch_assoc()): ?>
                        <tr>
                            <td><?= $order['id'] ?></td>
                            <td><?= htmlspecialchars($order['restaurant_name']) ?></td>
                            <td>
                                <?php
                                $order_id = $order['id'];
                                $items = $conn->query("
                                    SELECT f.food_name, f.image, oi.weight
                                    FROM order_items oi
                                    JOIN food_items f ON oi.food_id = f.id
                                    WHERE oi.order_id = $order_id
                                ");
                                while($item = $items->fetch_assoc()):
                                ?>
                                    <div class="food-item">
                                        <img src="../uploads/<?= htmlspecialchars($item['image']) ?>" alt="Food">
                                        <div>
                                            <?= htmlspecialchars($item['food_name']) ?> (<?= $item['weight'] ?>)
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </td>
                            <td>₹<?= number_format($order['total_amount'], 2) ?></td>
                            <td>
                                <?php if ($order['status'] == 'Pending'): ?>
                                    <span class="badge bg-warning text-dark"><?= $order['status'] ?></span>
                                <?php elseif ($order['status'] == 'Completed'): ?>
                                    <span class="badge bg-success"><?= $order['status'] ?></span>
                                <?php elseif ($order['status'] == 'Cancelled'): ?>
                                    <span class="badge bg-danger"><?= $order['status'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><?= $order['status'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d M Y, h:i A', strtotime($order['order_date'])) ?></td>
                            <td>
                                <?php if ($order['status'] == 'Pending'): ?>
                                    <a href="#?id=<?= $order['id'] ?>" class="btn btn-sm btn-primary mb-1">Edit</a>
                                    <form action="cancel_order.php" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            No orders found.
        </div>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer>
    <div class="container">
        &copy; <?= date('Y') ?> Food Delivery. All Rights Reserved.
    </div>
</footer>

<!-- Bootstrap Bundle JS (for navbar toggler) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>






