
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
//require_once '../config.php';

require_once __DIR__ . '/../includes/config.php'; // from public/index.php


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM orders WHERE id = $id");
    $order = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $id = $_POST['order_id'];
    $conn->query("UPDATE orders SET status='$status' WHERE id=$id");
    header("Location: manage_orders.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added for mobile responsiveness -->

    <title>Edit Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
  <div class="container mt-4">
      
<h2>Edit Order Status</h2>
        <form method="post">
            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
            <div class="mb-3">
                <label>Status</label>
                <select name="status" class="form-select" required>
                    <option <?= $order['status'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option <?= $order['status'] == 'Delivered' ? 'selected' : '' ?>>Delivered</option>
                    <option <?= $order['status'] == 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="manage_orders.php" class="btn btn-secondary">Back</a>
        </form>
      <!-- your form here -->
  </div>
</div>
