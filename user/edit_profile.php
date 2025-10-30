
<?php
session_start();
//require '../config.php';

require_once __DIR__ . '/../includes/config.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name  = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Handle photo upload
    if (!empty($_FILES['photo']['name'])) {
        $targetDir = "../uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir);
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $photoName = "user_" . $user_id . "." . $ext;
        $targetPath = $targetDir . $photoName;

        move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath);
        $conn->query("UPDATE users SET photo='$photoName' WHERE id=$user_id");
    }

    $conn->query("UPDATE users SET name='$name', phone='$phone', email='$email',address='$address' WHERE id=$user_id");
    $_SESSION['user_name'] = $name;
    $msg = "✅ Profile updated successfully!";
}

$user = $conn->query("SELECT * FROM users WHERE id=$user_id")->fetch_assoc();
$profilePhoto = !empty($user['photo']) ? "../uploads/" . $user['photo'] : "https://via.placeholder.com/150";
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added for mobile responsiveness -->
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f1f3f5;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.06);
        }
        .footer {
            background: #343a40;
            color: #fff;
            padding: 15px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        .profile-pic {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #dee2e6;
        }
    </style>
</head>
<body>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">🍽 FoodDelivery</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="user_dashboard.php">🏠 Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="order_history.php">📜 Order History</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="edit_profile.php">👤 Edit Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger" href="logout.php">🚪 Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main -->
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h4 class="mb-3">👤 Edit Profile</h4>
                <?php if (isset($msg)) echo "<div class='alert alert-success'>$msg</div>"; ?>

                <div class="text-center mb-3">
                    <img src="<?= $profilePhoto ?>" class="profile-pic" alt="Profile Photo">
                </div>

                <form method="POST" enctype="multipart/form-data">

                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input class="form-control" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control" name="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input class="form-control" type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input class="form-control" type="text" name="address" value="<?= htmlspecialchars($user['address']) ?>" required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Profile Photo</label>
                        <input class="form-control" type="file" name="photo" accept="image/*">
                        <small class="text-muted">Leave empty to keep current photo</small>
                    </div>
                    <button class="btn btn-primary w-100">💾 Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<div class="footer text-center">
    <div class="container">
        &copy; <?= date("Y") ?> FoodDelivery App | All rights reserved
    </div>
</div>

</body>
</html>

