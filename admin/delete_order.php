
<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

//require_once '../config.php';

require_once __DIR__ . '/../includes/config.php'; // from public/index.php


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Always sanitize input

    // Step 1: Delete child records first
    $conn->query("DELETE FROM order_items WHERE order_id = $id");

    // Step 2: Now delete the main order
    $conn->query("DELETE FROM orders WHERE id = $id");
}

$conn->close();

// Redirect
header("Location: manage_orders.php");
exit();
?>

