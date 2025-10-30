
<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - Food Delivery</title>
<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
body {
    background: #f8f9fa;
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
}
.header-bar {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 60px;
    background: linear-gradient(135deg, #b2b4e2ff, #313becff);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 20px;
    z-index: 3000;
}
.header-bar h4 {
    margin: 0;
    font-size: 1.2rem;
}
.admin-info {
    display: flex;
    align-items: center;
    gap: 15px;
}
.admin-info span {
    font-size: 0.9rem;
}
.admin-info a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
}
</style>
</head>

<div class="header-bar">
  <h4>🍔 Food Admin Panel</h4>
  <div class="admin-info">
      <span><?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?></span>
      <span><?= htmlspecialchars($_SESSION['admin_email'] ?? 'admin@example.com') ?></span>
      <a href="logout.php" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
  </div>
</div>
