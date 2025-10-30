
<?php
// DB Connection

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

//require_once '../config.php';

require_once __DIR__ . '/../includes/config.php'; // from public/index.php



// Fetch existing user data
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    if ($result->num_rows == 0) die("User not found.");
    $user = $result->fetch_assoc();
}

// Update user data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name    = $_POST['name'];
    $phone   = $_POST['phone'];
    $email   = $_POST['email'];
    $address = $_POST['address'];

    // Optional: Update password only if field is filled
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $user['password'];

    // Optional: Handle photo upload
    if (!empty($_FILES['photo']['name'])) {
        $photo = basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photo);
    } else {
        $photo = $user['photo'];
    }

    // Update query
    $sql = "UPDATE users SET name='$name', phone='$phone', email='$email', address='$address', password='$password', photo='$photo' WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: dashboard.php"); // Redirect back
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- HTML Form -->
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
  <div class="container mt-4">
    
<h2>Edit User</h2>
    <form method="POST" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-6">
            <label>Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($user['name']); ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']); ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Address</label>
            <input type="text" name="address" value="<?= htmlspecialchars($user['address']); ?>" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>New Password (optional)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Photo</label><br>
            <input type="file" name="photo" class="form-control">
            <img src="../uploads/<?= $user['photo']; ?>" width="50" class="mt-2">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-success">Update</button>
            <a href="user_details.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
      <!-- your form here -->
  </div>
</div>
