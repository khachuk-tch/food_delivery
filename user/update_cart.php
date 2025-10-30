
<?php
session_start();

if (!isset($_SESSION['cart'])) {
    echo "Cart not found.";
    exit();
}

$index = (int)$_POST['index'];

if ($_POST['action'] === 'increase') {
    $_SESSION['cart'][$index]['quantity'] += 1;
} elseif ($_POST['action'] === 'decrease') {
    if ($_SESSION['cart'][$index]['quantity'] > 1) {
        $_SESSION['cart'][$index]['quantity'] -= 1;
    }
} elseif ($_POST['action'] === 'remove') {
    array_splice($_SESSION['cart'], $index, 1); // Remove the item
}

echo "Cart updated.";
?>

