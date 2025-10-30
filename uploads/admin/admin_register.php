


<?php
//require_once '../config.php';
require_once __DIR__ . '/../includes/config.php'; // from public/index.php

$message = "";

// When form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = htmlspecialchars(trim($_POST['username']));
  $email = htmlspecialchars(trim($_POST['email']));
  $password = $_POST['password'];
  $confirm = $_POST['confirm_password'];

  if ($password !== $confirm) {
    $message = "<div class='alert alert-danger'>Passwords do not match!</div>";
  } else {
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT id FROM admins WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $checkResult = $check->get_result();

    if ($checkResult->num_rows > 0) {
      $message = "<div class='alert alert-warning'>Email already registered.</div>";
    } else {
      $stmt = $conn->prepare("INSERT INTO admins (username, email, password) VALUES (?, ?, ?)");
      $stmt->bind_param("sss", $username, $email, $hashedPassword);
      if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Admin registered successfully! Now login ✅</div>";
        header("location:login.php?message=$message");
      } else {
        $message = "<div class='alert alert-danger'>Error registering admin.</div>";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Register | PigFarm</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f0f4f8, #d9e2ec);
      font-family: 'Segoe UI', sans-serif;
    }
    header, footer {
      background-color: #198754;
      color: white;
      padding: 15px 0;
      text-align: center;
    }
    .register-box {
      max-width: 500px;
      margin: 60px auto;
    }
    .card {
      border-radius: 12px;
    }
    .form-label {
      font-weight: 500;
    }
    .footer-note {
      font-size: 14px;
    }
    .step-form {
      display: none;
    }
    .step-form.active {
      display: block;
    }
  </style>
</head>
<body>

<!-- Header -->
<header>
  <h2>🐖 PigFarm Admin Portal</h2>
</header>

<!-- Register Form -->
<div class="register-box">
  <div class="card shadow-sm">
    <div class="card-body p-4">
      <h3 class="text-center mb-4 text-success">Admin Register</h3>

      <?php if (isset($message)) echo $message; ?>

      <form method="POST" id="multiStepForm">
        <!-- Step 1 -->
        <div class="step-form active" id="step1">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <button type="button" class="btn btn-success w-100" onclick="nextStep()">Next ➡️</button>
        </div>

        <!-- Step 2 -->
        <div class="step-form" id="step2">
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" id="password" class="form-control" required minlength="6">
          </div>
          <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
          </div>
          <div class="d-flex justify-content-between">
            <button type="button" class="btn btn-secondary" onclick="prevStep()">⬅️ Back</button>
            <button type="submit" class="btn btn-success">Register ✅</button>
          </div>
        </div>
      </form>

      <div class="mt-3 text-center">
        👉 <a href="login.php" class="text-decoration-underline text-success">Already have an account? Login</a>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer class="mt-5">
  <p class="mb-0 footer-note">© <?= date('Y') ?> PigFarm. All rights reserved.</p>
</footer>

<!-- JS -->
<script>
  function nextStep() {
    const username = document.querySelector('input[name="username"]');
    const email = document.querySelector('input[name="email"]');
    if (username.value.trim() === '' || email.value.trim() === '') {
      alert('Please fill in all fields!');
      return;
    }

    document.getElementById("step1").classList.remove("active");
    document.getElementById("step2").classList.add("active");
  }

  function prevStep() {
    document.getElementById("step2").classList.remove("active");
    document.getElementById("step1").classList.add("active");
  }

  // Optional: Password match check before submit
  document.getElementById("multiStepForm").addEventListener("submit", function(e) {
    const pwd = document.getElementById("password").value;
    const confirm = document.getElementById("confirm_password").value;
    if (pwd !== confirm) {
      e.preventDefault();
      alert("Passwords do not match!");
    }
  });
</script>

</body>
</html>
