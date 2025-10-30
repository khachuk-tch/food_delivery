<?php
session_start();
//include '../config.php';

require_once __DIR__ . '/../includes/config.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = (int) $_POST['order_id'];
    $user_id = $_SESSION['user_id'];

    // Check if the order is still pending and belongs to the user
    $check = $conn->query("SELECT * FROM orders WHERE id = $order_id AND user_id = $user_id AND status = 'Pending'");
    if ($check->num_rows > 0) {
        // First delete related order_items
        $conn->query("DELETE FROM order_items WHERE order_id = $order_id");

        // Then delete the order itself
        $conn->query("DELETE FROM orders WHERE id = $order_id");

        $_SESSION['message'] = "Order deleted successfully.";
    } else {
        $_SESSION['message'] = "Cannot delete this order.";
    }
}

header("Location: user_dashboard.php");
exit();
?>


