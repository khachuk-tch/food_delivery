
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
//require_once '../config.php';

require_once __DIR__ . '/../includes/config.php'; // from public/index.php


// Fetch user data
$sql = "SELECT id, name, phone, email, address, photo FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User List</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
  <div class="container">
     
  <h2 class="mb-4"><center>User List</center></h2>  
    <table class="table table-bordered table-hover table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Address</th>
                <th>Photo</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= htmlspecialchars($row['name']); ?></td>
                    <td><?= htmlspecialchars($row['phone']); ?></td>
                    <td><?= htmlspecialchars($row['email']); ?></td>
                    <td><?= htmlspecialchars($row['address']); ?></td>
                    
                    <td>
                        <img src="../uploads/<?= htmlspecialchars($row['photo']); ?>" width="50" height="50" class="rounded-circle">
                    </td>
 <td class="text-center">
    <div class="d-flex flex-column align-items-center">
        <a href="edit_user.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning mb-2 w-75">
            <i class="bi bi-pencil-square"></i> Edit
        </a>
        <a href="delete_user.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger w-75"
           onclick="return confirm('Are you sure to delete this user?');">
            <i class="bi bi-trash"></i> Delete
        </a>
    </div>
</td>


                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8" class="text-center">No users found.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>

      <!-- your form here -->
  </div>
</div>



<!-- Bootstrap JS (optional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php $conn->close(); ?>
