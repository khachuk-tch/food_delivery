
<?php
// Database connection
//require_once '../config.php';

require_once __DIR__ . '/../includes/config.php'; // from public/index.php


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch food items
$sql = "SELECT * FROM food_items ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added for mobile responsiveness -->
  <title>Manage Food Items</title>
  <!-- Bootstrap Icons CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 20px;
    }
    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }
    .table th {
      background-color: #343a40;
      color: white;
    }
    .table td, .table th {
      vertical-align: middle;
    }
    img.food-img {
      width: 60px;
      height: 60px;
      object-fit: cover;
      border-radius: 10px;
    }
    .btn-edit {
      background-color: #0d6efd;
      color: white;
    }
    .btn-delete {
      background-color: #dc3545;
      color: white;
    }
    .btn-edit:hover, .btn-delete:hover {
      opacity: 0.85;
    }
    h2 {
      margin-bottom: 20px;
      font-weight: 600;
      color: #333;
    }
    .table-responsive {
      margin-top: 20px;
    }
  </style>
</head>
<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
  <div class="container mt-4">
      
     

      
  <h2>🍽️ Manage Food Items</h2> 

  <div class="card p-4">
    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Restaurant</th>
            <th>Food Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Image</th>
            <th>Category</th>
            <th>Availability</th>
            <th>Created At</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['restaurant_name']) ?></td>
                <td><?= htmlspecialchars($row['food_name']) ?></td>
                <td><?= htmlspecialchars($row['description']) ?></td>
                <td>₹<?= number_format($row['price'], 2) ?></td>
                <td>
                  <img src="../uploads/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['food_name']) ?>" class="food-img">
                </td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td>
                  <?php if($row['availability'] == 'Available'): ?>
                    <span class="badge bg-success">Available</span>
                  <?php else: ?>
                    <span class="badge bg-danger">Unavailable</span>
                  <?php endif; ?>
                </td>
                <td><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                <td>
    <a href="edit_food.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning mb-2">
  <i class="bi bi-pencil-square"></i> Edit
</a>
    <a href="delete_food.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger mb-2" onclick="return confirm('Are you sure?')">
  <i class="bi bi-trash"></i> Delete
</a>
</td>


              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="10" class="text-center">No food items found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>



  </div>
</div>



<?php $conn->close(); ?>

