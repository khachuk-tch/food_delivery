
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Example: store admin info in session during login
// $_SESSION['admin_name'] = "John Doe";
// $_SESSION['admin_email'] = "john@example.com";

$admin_name = $_SESSION['admin_name'] ?? 'Admin';
$admin_email = $_SESSION['admin_email'] ?? 'admin@example.com';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel - Food Delivery</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f0f2f5;
        margin: 0;
        padding: 0;
    }

    /* Modern Header */
    .admin-header {
        background: linear-gradient(135deg, #c8deecff, #2630e0ff);
        color: #fff;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .admin-header .brand {
        font-size: 1.4rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .admin-header .admin-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .admin-header .admin-details {
        text-align: right;
    }

    .admin-header .admin-details span {
        display: block;
        line-height: 1.2;
        font-size: 0.9rem;
    }

    .logout-btn {
        background: #ff4757;
        border: none;
        padding: 6px 14px;
        border-radius: 6px;
        color: #fff;
        font-size: 0.9rem;
        transition: 0.3s;
    }

    .logout-btn:hover {
        background: #e84118;
    }

    @media (max-width: 768px) {
        .admin-header {
            flex-direction: column;
            text-align: center;
        }
        .admin-header .admin-info {
            flex-direction: column;
            margin-top: 0.5rem;
        }
    }


     body {
       
        overflow-x: hidden;
    }
    .main-content {
        
        padding: 2rem;
    }
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
    }


</style>
</head>
<body>

<header class="admin-header">
    <div class="brand">
        🍔 <span><strong>Admin Panel</strong></span>
    </div>

    <div class="admin-info">
        <div class="admin-details">
            <span><strong><?= htmlspecialchars($admin_name) ?></strong></span>
            <span><?= htmlspecialchars($admin_email) ?></span>
        </div>
        <a href="../admin/logout.php" class="btn logout-btn">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</header>