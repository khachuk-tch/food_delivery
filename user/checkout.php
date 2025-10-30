<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}




$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
$totalAmount = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added for mobile responsiveness -->
    <title>Checkout Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="bg-light">


<div class="container py-4">
    <h2 class="text-center mb-4">🛒 My Cart</h2>

    <?php if (count($cart) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered bg-white shadow-sm">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Food Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart as $index => $item): ?>
                        <?php $subtotal = $item['price'] * $item['quantity']; $totalAmount += $subtotal; ?>
                        <tr>
                            <td><img src="../uploads/<?= $item['image'] ?>" width="60" height="60" style="object-fit:cover;" class="rounded"></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>₹<?= $item['price'] ?></td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button class="btn btn-sm btn-outline-secondary decreaseQty" data-index="<?= $index ?>">-</button>
                                    <span class="mx-2"><?= $item['quantity'] ?></span>
                                    <button class="btn btn-sm btn-outline-primary increaseQty" data-index="<?= $index ?>">+</button>
                                </div>
                            </td>
                            <td>₹<?= $subtotal ?></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-danger removeItem" data-index="<?= $index ?>">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="card p-3 mb-4 shadow-sm">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="m-0">Total: ₹<?= $totalAmount ?></h4>
            </div>
        </div>

        <div class="d-flex justify-content-center gap-3">
            <a href="menu.php" class="btn btn-outline-primary">← Continue Shopping</a>
            <form method="post" action="place_order.php" class="d-inline">
                <button type="submit" class="btn btn-success">✅ Place Order</button>
            </form>
        </div>

    <?php else: ?>
        <div class="alert alert-warning text-center">
            Your cart is empty! <a href="menu.php" class="btn btn-sm btn-outline-primary mt-2">Go to Menu</a>
        </div>
    <?php endif; ?>
</div>





<script>
$(document).ready(function() {
    $('.increaseQty').click(function() {
        var index = $(this).data('index');
        $.post('update_cart.php', { action: 'increase', index: index }, function(response) {
            location.reload(); // Reload after update
        });
    });

    $('.decreaseQty').click(function() {
        var index = $(this).data('index');
        $.post('update_cart.php', { action: 'decrease', index: index }, function(response) {
            location.reload(); // Reload after update
        });
    });
});

$('.removeItem').click(function() {
    var index = $(this).data('index');
    if (confirm('Are you sure you want to remove this item?')) {
        $.post('update_cart.php', { action: 'remove', index: index }, function(response) {
            location.reload(); // Reload after remove
        });
    }
});



</script>


</body>
</html>
