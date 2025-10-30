

<?php
session_start();
//require_once '../config.php';

require_once __DIR__ . '/../includes/config.php'; // from public/index.php

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = htmlspecialchars(trim($_POST['email']));
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();
    if (password_verify($password, $admin['password'])) {
      $_SESSION['admin_id'] = $admin['id'];
      $_SESSION['admin_name'] = $admin['username'];
      $_SESSION['admin_email'] = $admin['email'];
      
      header("Location:dashboard.php");
      exit();
    } else {
      $message = "<div class='alert alert-danger'>Incorrect password!</div>";
    }
  } else {
    $message = "<div class='alert alert-danger'>Admin not found!</div>";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Login | PigFarm</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #e0f7ec, #f2f8f9);
      font-family: 'Segoe UI', sans-serif;
    }
    header, footer {
      background-color: #198754;
      color: white;
      padding: 15px 0;
      text-align: center;
    }
    .login-section {
      max-width: 1000px;
      margin: 60px auto;
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .info-side {
      background-color: #198754;
      color: white;
      padding: 40px 30px;
    }
    .info-side h2 {
      font-size: 28px;
      font-weight: 700;
    }
    .info-side p {
      font-size: 16px;
      margin-top: 10px;
    }
    .form-side {
      padding: 40px 30px;
    }
    .form-label {
      font-weight: 500;
    }
    a {
      text-decoration: none;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header>
    <h2>🐖 Food Delivery Admin Portal</h2>
  </header>

  <!-- Login Box -->
  <div class="login-section row mx-auto">
    
    <!-- Left Side Info -->
    <div class="col-md-6 info-side d-flex flex-column justify-content-center">
      <h2>Welcome Back, Admin!</h2>
      <p>Login to manage your farm operations,<br> track piglet sales, and update your portal.</p>
      <p class="mt-3">Need an account? 👉 <a href="admin_register.php" class="text-warning">Register here</a></p>
    </div>

    <!-- Right Side Form -->
    <div class="col-md-6 form-side">
      <h3 class="text-center text-success mb-4">🔐 Admin Login</h3>


      <?php


if (isset($_SESSION['timeout_message'])) {
    echo '<div class="alert alert-warning text-center" style="margin:10px;">'
       . htmlspecialchars($_SESSION['timeout_message'])
       . '</div>';
    unset($_SESSION['timeout_message']); // clear message after showing
}
?>



      <?php if (isset($message)) echo $message; ?>
      <?php if (isset($_GET['message'])) echo $_GET['message']; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Login</button>
        <div class="text-center mt-3">
          👉 <a href="admin_register.php" class="text-decoration-underline text-success">Create Admin Account</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer class="mt-5">
    <p class="mb-0">© <?= date('Y') ?> PigFarm. All rights reserved.</p>
  </footer>

</body>
</html>


