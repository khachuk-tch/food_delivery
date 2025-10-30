<?php
session_start();
//require '../config.php'; // Database connection

require_once __DIR__ . '/../includes/config.php'; 

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get cart from session
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];



if (empty($cart)) {
    header("Location: checkout.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user address from users table
$address = "Unknown Address"; // Default
$userQuery = $conn->prepare("SELECT address FROM users WHERE id = ?");
$userQuery->bind_param("i", $user_id);
$userQuery->execute();
$userResult = $userQuery->get_result();
if ($userRow = $userResult->fetch_assoc()) {
    $address = $userRow['address'];
}
$userQuery->close();

// Fetch restaurant name from food_items table (from first cart item)
$restaurant_name = "Unknown Restaurant"; // Default

if (!empty($cart)) {
    $firstFoodId = (int)$cart[0]['food_id'];

    $restaurantQuery = $conn->prepare("SELECT restaurant_name FROM food_items WHERE id = ?");
    $restaurantQuery->bind_param("i", $firstFoodId);
    $restaurantQuery->execute();
    $restaurantResult = $restaurantQuery->get_result();
    if ($restaurantRow = $restaurantResult->fetch_assoc()) {
        $restaurant_name = $restaurantRow['restaurant_name'];
    }
    $restaurantQuery->close();
}

// Prepare items and calculate total
$totalAmount = 0;
$itemsArray = [];

foreach ($cart as $item) {
    if (!isset($item['food_id'])) continue; // Skip invalid cart items

    $foodName = $item['name'] ?? "Unknown Food";
    $weight = $item['weight'] ?? '';
    $price = (float)($item['price'] ?? 0);
    $quantity = (int)($item['quantity'] ?? 0);

    $subtotal = $price * $quantity ;
    $totalAmount += $subtotal;

    $itemsArray[] = [
        
        'name' => $foodName,
        'weight' => $weight,
        'price' => $price,
        'quantity' => $quantity
    ];
}

// Convert items array to JSON
$itemsJson = json_encode($itemsArray);

// Insert order into orders table
$orderStmt = $conn->prepare("INSERT INTO orders (user_id, restaurant_name, items, total_amount, address, status, order_date) 
                             VALUES (?, ?, ?, ?, ?, 'Pending', NOW())");
$orderStmt->bind_param("issds", $user_id, $restaurant_name, $itemsJson, $totalAmount, $address);

if ($orderStmt->execute()) {
    $order_id = $orderStmt->insert_id;

    // Insert each item into order_items table
    $itemStmt = $conn->prepare("INSERT INTO order_items (order_id, food_id, weight, price) VALUES (?, ?, ?, ?)");

    foreach ($cart as $item) {
        if (!isset($item['food_id'])) continue;
    
        $food_id = (int)$item['food_id'];
        $price = (float)($item['price'] ?? 0);
    
        // 🔥 Fetch weight from food_items table
        $weight = 'N/A'; // Default in case not found
        $weightQuery = $conn->prepare("SELECT weight FROM food_items WHERE id = ?");
        $weightQuery->bind_param("i", $food_id);
        $weightQuery->execute();
        $weightResult = $weightQuery->get_result();
        if ($weightRow = $weightResult->fetch_assoc()) {
            $weight = $weightRow['weight'];
        }
        $weightQuery->close();
    
        // Insert into order_items
        $itemStmt->bind_param("iisd", $order_id, $food_id, $weight, $price);
        $itemStmt->execute();
    }
    
    



    $itemStmt->close();

    // Clear cart after placing order
    unset($_SESSION['cart']);

    // Redirect to thank you page
    header("Location: thankyou.php?order_id=" . $order_id);
    exit();
} else {
    echo "Something went wrong while placing the order!";
}

$orderStmt->close();
?>





