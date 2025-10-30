
<?php
session_start();
//require '../config.php';

require_once __DIR__ . '/../includes/config.php'; 

if (!isset($_POST['food_id'])) {
    echo json_encode(["status" => "error", "message" => "No food selected."]);
    exit();
}

$food_id = (int)$_POST['food_id'];

// Fetch food details
$stmt = $conn->prepare("SELECT * FROM food_items WHERE id = ?");
$stmt->bind_param('i', $food_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $food = $result->fetch_assoc();

    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if item already in cart
    $already_in_cart = false;
    foreach ($_SESSION['cart'] as $item) {
        if ($item['food_id'] == $food['id']) {
            $already_in_cart = true;
            break;
        }
    }

    if (!$already_in_cart) {
        $_SESSION['cart'][] = [
            'food_id' => $food['id'],
            'name' => $food['food_name'],
            'image' => $food['image'],
            'price' => $food['price'],
            'quantity' => 1
        ];
        echo json_encode([
            "status" => "success",
            "message" => "Added to Cart!",
            "cart_count" => count($_SESSION['cart'])
        ]);
    } else {
        echo json_encode([
            "status" => "info",
            "message" => "Already in Cart!",
            "cart_count" => count($_SESSION['cart'])
        ]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Food not found."]);
}
?>
