<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
//require_once '../config.php';

require_once __DIR__ . '/../includes/config.php'; // from public/index.php


$orders = $conn->query("
    SELECT 
        orders.id AS order_id, 
        users.name AS user_name, 
        users.phone AS user_phone, 
        users.address AS user_address, 
        orders.restaurant_name, 
        orders.total_amount, 
        orders.status, 
        orders.order_date,
        food_items.food_name,
        food_items.image
    FROM orders
    JOIN users ON orders.user_id = users.id
    JOIN order_items ON orders.id = order_items.order_id
    JOIN food_items ON order_items.food_id = food_items.id
    ORDER BY orders.order_date DESC
");


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added for mobile responsiveness -->
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
    body {
        background: #f4f6f9;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', sans-serif;
    }
  
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    table th {
        background-color: #343a40;
        color: white;
    }
    table td, table th {
        vertical-align: middle;
    }

    .col-actions {
        width: 140px;
    }
</style>

</head>
<body>


<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
  <div class="container">
      

  <h2 class="mb-4"> <center> 📦 Manage Orders</center> </h2>   

    <div class="card p-3">
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
    <tr>
        <th>Order ID</th>
        <th>User Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Food Name</th>
        <th>Food Image</th>
        <th>Restaurant</th>
        <th>Total Amount</th>
        <th>Status</th>
        <th>Order Date</th>
        <th class="col-actions">Actions</th>
    </tr>
</thead>

<tbody>
<?php while($row = $orders->fetch_assoc()): ?>
    <tr>
        <td><?= $row['order_id'] ?></td>
        <td><?= htmlspecialchars($row['user_name']) ?></td>
        <td><?= htmlspecialchars($row['user_phone']) ?></td>
        <td><?= htmlspecialchars($row['user_address']) ?></td>
        <td><?= htmlspecialchars($row['food_name']) ?></td>
        <td>
            <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['food_name']) ?>" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
        </td>
        <td><?= htmlspecialchars($row['restaurant_name']) ?></td>
        <td>₹<?= number_format($row['total_amount'], 2) ?></td>
        <td>
            <span class="badge bg-<?= 
                $row['status'] === 'Pending' ? 'warning' : 
                ($row['status'] === 'Delivered' ? 'success' : 
                ($row['status'] === 'Cancelled' ? 'danger' : 'secondary')) ?>">
                <?= $row['status'] ?>
            </span>
        </td>
        <td><?= date('d M Y, h:i A', strtotime($row['order_date'])) ?></td>
        <td>
            <a href="edit_order.php?id=<?= $row['order_id'] ?>" class="btn btn-sm btn-primary">Edit</a>
            <a href="delete_order.php?id=<?= $row['order_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
        </td>
    </tr>
<?php endwhile; ?>
</tbody>

            </table>
        </div>
    </div>

      <!-- your form here -->
  </div>
</div>

