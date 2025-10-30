<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit;
}


// Prevent browser caching so Back button won’t reopen this page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Check login
if (!isset($_SESSION['admin_id'])) {
    $_SESSION['timeout_message'] = "Session timed out, please re-login.";
    header("Location: login.php");
    exit();
}






//require_once '../config.php';

require_once __DIR__ . '/../includes/config.php'; // from public/index.php


// Fetch summary stats
$total_orders = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];
$total_users = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
$total_items = $conn->query("SELECT COUNT(*) AS total FROM food_items")->fetch_assoc()['total'];
$total_pending = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE status = 'Pending'")->fetch_assoc()['total'];
$total_delivery = $conn->query("SELECT COUNT(*) AS total FROM orders WHERE status = 'Delivered'")->fetch_assoc()['total'];
?>



<?php include 'includes/sidebar.php'; ?>
<?php include 'includes/admin_header.php'; ?>

<div class="main-content">
  <h2 class="mb-4">Welcome, Admin!</h2>

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card p-4 bg-primary text-white text-center shadow-sm rounded-3">
        <h5>Total Orders</h5>
        <h2><?= $total_orders ?></h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-4 bg-success text-white text-center shadow-sm rounded-3">
        <h5>Total Food Items</h5>
        <h2><?= $total_items ?></h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card p-4 bg-info text-white text-center shadow-sm rounded-3">
        <h5>Total Users</h5>
        <h2><?= $total_users ?></h2>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-4 bg-warning text-white text-center shadow-sm rounded-3">
        <h5>Pending Orders</h5>
        <h2><?= $total_pending ?></h2>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-4 bg-success text-white text-center shadow-sm rounded-3">
        <h5>Delivered Orders</h5>
        <h2><?= $total_delivery ?></h2>
      </div>
    </div>
  </div>

  <!-- Chart Section -->
  <div class="card mt-5 p-4 shadow-sm">
    <h4 class="text-center mb-4">Order Statistics Overview</h4>
    <canvas id="orderChart" height="120"></canvas>
  </div>
</div>

<!-- Add this before </body> -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('orderChart').getContext('2d');
const orderChart = new Chart(ctx, {
  type: 'bar', // You can change to 'line' or 'doughnut'
  data: {
    labels: ['Total Orders', 'Pending', 'Delivered', 'Food Items', 'Users'],
    datasets: [{
      label: 'Count',
      data: [
        <?= $total_orders ?>,
        <?= $total_pending ?>,
        <?= $total_delivery ?>,
        <?= $total_items ?>,
        <?= $total_users ?>
      ],
      backgroundColor: [
        'rgba(13, 110, 253, 0.7)',
        'rgba(255, 193, 7, 0.7)',
        'rgba(25, 135, 84, 0.7)',
        'rgba(23, 162, 184, 0.7)',
        'rgba(111, 66, 193, 0.7)'
      ],
      borderColor: [
        'rgba(13, 110, 253, 1)',
        'rgba(255, 193, 7, 1)',
        'rgba(25, 135, 84, 1)',
        'rgba(23, 162, 184, 1)',
        'rgba(111, 66, 193, 1)'
      ],
      borderWidth: 1,
      borderRadius: 6
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: '#333',
        titleColor: '#fff',
        bodyColor: '#fff'
      }
    },
    scales: {
      y: {
        beginAtZero: true,
        ticks: { stepSize: 1 }
      }
    }
  }
});
</script>



<?php include 'includes/footer.php'; ?>



