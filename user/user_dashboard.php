
<?php
session_start();
//require '../config.php'; // Database connection

require_once __DIR__ . '/../includes/config.php'; 

// Prevent browser caching so Back button won’t reopen this page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Check login
if (!isset($_SESSION['user_id'])) {
    $_SESSION['timeout_message'] = "Session timed out, please re-login.";
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added for mobile responsiveness -->
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card i {
            font-size: 2rem;
            color: #0d6efd;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">🍽 FoodDelivery</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="text-light btn btn-success d-flex gap-3 me-3" href="menu.php">Go to Menu</a>
        </li>

    
        <li class="nav-item">
          <a class="text-light btn btn-primary me-5 d-flex gap-3" href="order_history.php">Check Order</a>
        </li>
        
      </ul>
    </div>
  </div>
</nav>

<!-- Dashboard Content -->
<div class="container mt-5">
    <h3 class="mb-4">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?>! 🎉</h3>

    


    <div class="row g-4">
        <!-- Menu Card -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <i class="bi bi-list-ul"></i>
                <h5 class="mt-3">Browse Menu</h5>
                <p>Explore delicious food from your favorite restaurants.</p>
                <a href="menu.php" class="btn btn-primary">Go to Menu</a>
            </div>
        </div>
     <?php $user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();  ?>

        <!-- Profile Card -->
<div class="col-md-4">
    <div class="card text-center p-4">
        <?php
        echo '<img src="' . (!empty($user['photo']) ? '../uploads/' . $user['photo'] : 'https://via.placeholder.com/150') . '" 
            class="rounded-circle mx-auto d-block" 
            height="50" 
            width="50" 
            style="object-fit: cover;" 
            alt="User Photo">';
        ?>
        <h5 class="mt-3">My Profile</h5>
        <p>View or update your personal information and picture</p>
        <a class="btn btn-success" href="edit_profile.php">👤 Edit Profile</a>
    </div>
</div>



        <!-- Logout Card -->
        <div class="col-md-4">
            <div class="card text-center p-4">
                <i class="bi bi-box-arrow-right"></i>
                <h5 class="mt-3">Logout</h5>
                <p>Ready to go? Safely logout from your account.</p>
                <a href="logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>
    </div>

    <?php




$user_id = $_SESSION['user_id'];

$orders = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY order_date DESC");
$order_count = 0;
?>

<h5 class="mt-5">🕒 Recent Orders</h5>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-info"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
<?php endif; ?>

<table class="table table-bordered mt-3 align-middle">
    <thead class="table-dark text-center">
        <tr>
            <th>Restaurant</th>
            <th>Items</th>
            <th>Total</th>
            <th>Status</th>
            <th>Reach Time</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody class="text-center">
    <?php $order_count = 0; ?>
    <?php while($order = $orders->fetch_assoc()): ?>
        <?php if ($order_count >= 5) break; ?> <!-- Show only 5 recent orders -->
        <tr>
            <td><?= htmlspecialchars($order['restaurant_name']) ?></td>
            
            <!-- Ordered Items -->
            <td class="text-start">
                <?php
                $order_id = $order['id'];
                $items = $conn->query("
                    SELECT f.food_name, f.image, oi.weight
                    FROM order_items oi
                    JOIN food_items f ON oi.food_id = f.id
                    WHERE oi.order_id = $order_id
                ");
                while ($item = $items->fetch_assoc()):
                ?>
                    <div class="d-flex align-items-center mb-2">
                        <img src="../uploads/<?= htmlspecialchars($item['image']) ?>" 
                             alt="<?= htmlspecialchars($item['food_name']) ?>" 
                             class="me-2" 
                             style="width: 45px; height: 45px; object-fit: cover; border-radius: 5px;">
                        <div>
                            <strong><?= htmlspecialchars($item['food_name']) ?></strong><br>
                            <small>Qty: <?= htmlspecialchars($item['weight']) ?></small>
                        </div>
                    </div>
                <?php endwhile; ?>
            </td>

            <td>₹<?= number_format($order['total_amount'], 2) ?></td>
            <td>
                <?php if ($order['status'] == 'Pending'): ?>
                    <span class="badge bg-warning text-dark">Pending</span>
                <?php elseif ($order['status'] == 'Delivered'): ?>
                    <span class="badge bg-success">Delivered</span>
                <?php else: ?>
                    <span class="badge bg-secondary"><?= htmlspecialchars($order['status']) ?></span>
                <?php endif; ?>
            </td>

            <!-- ✅ Reach Time + Progress Bar -->
            <td>
                <?php if ($order['status'] == 'Pending'): ?>
                    <?php 
                    $reach_time = rand(30, 60); // Random between 30–60 minutes
                    ?>
                    <div class="reach-time text-primary fw-bold" data-minutes="<?= $reach_time ?>">
                        ⏱️ Reaching in <?= $reach_time ?> min...
                    </div>
                    <div class="progress mt-1" style="height: 6px;">
                        <div class="progress-bar bg-success" 
                             role="progressbar" 
                             style="width: 0%;" 
                             aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                <?php elseif ($order['status'] == 'Delivered'): ?>
                    <div class="text-success fw-bold">✅ Reached successfully</div>
                <?php else: ?>
                    <span class="text-muted">N/A</span>
                <?php endif; ?>
            </td>

            <td><?= date('d M Y, h:i A', strtotime($order['order_date'])) ?></td>

            <td>
                <?php if ($order['status'] == 'Pending'): ?>
                    <form method="POST" action="cancel_order.php" onsubmit="return confirm('Cancel this order?');">
                        <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Cancel</button>
                    </form>
                <?php else: ?>
                    <span class="text-muted">N/A</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php $order_count++; ?>
    <?php endwhile; ?>
    </tbody>
</table>

<!-- 🧠 Live Countdown + Progress Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const timers = document.querySelectorAll(".reach-time");

    timers.forEach(timer => {
        let minutes = parseInt(timer.getAttribute("data-minutes"));
        const progressBar = timer.nextElementSibling.querySelector(".progress-bar");
        const total = minutes;
        let elapsed = 0;

        const interval = setInterval(() => {
            if (minutes > 1) {
                minutes--;
                elapsed++;
                const percent = Math.min((elapsed / total) * 100, 100);
                progressBar.style.width = percent + "%";
                timer.textContent = `⏱️ Reaching in ${minutes} min...`;
            } else {
                clearInterval(interval);
                progressBar.style.width = "100%";
                progressBar.classList.replace("bg-success", "bg-info");
                timer.textContent = "✅ Reached successfully";
                timer.style.color = "green";
                timer.style.fontWeight = "bold";
            }
        }, 60000); // Every 60 seconds = 1 minute
    });
});
</script>


<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Bootstrap JS for Navbar Toggle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>

