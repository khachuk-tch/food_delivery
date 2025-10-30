
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
//require '../config.php';

require_once __DIR__ . '/../includes/config.php'; 

// Fetch categories only
$categories = $conn->query("SELECT DISTINCT restaurant_name FROM food_items");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added for mobile responsiveness -->
    <title>Food Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .card-img-top {
            height: 150px;
            object-fit: cover;
        }
        .card { border-radius: 12px; transition: 0.3s; }
        .card:hover { transform: scale(1.02); box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .card-title { font-size: 1.1rem; font-weight: 600; }
        .price-tag { font-size: 1.2rem; color: #28a745; font-weight: bold; }
        .footer { background: #343a40; color: white; padding: 20px 0; margin-top: 50px; }

        .navbar a.nav-link:hover,
        .navbar .btn:hover {
            background-color: rgba(244, 248, 7, 0.15);
            border-radius: 5px;
            color: #fff !important;
        }

        /* Sticky Navbar */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 9999; /* Ensures the navbar stays on top */
        }

        /* Optional: Adding a shadow effect when scrolling */
        .navbar.sticky-nav {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }


        .card-title {
    margin-bottom: 4px;
}
.card .text-muted {
    margin-bottom: 4px;
    font-size: 0.9rem;
}
.price-tag {
    font-size: 1.1rem;
    font-weight: bold;
    color: #28a745;
    margin-top: 8px;
}
    </style>
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(90deg, rgb(0, 153, 255), rgb(102, 51, 255));">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="#" style="font-size: 1.5rem;">🍽 FoodDelivery</a>
        <div class="ms-auto d-flex align-items-center">
            <a class="nav-link text-white me-3" href="checkout.php" style="transition: 0.3s;">
                🛒 My Cart <span id="cart-count" class="badge bg-light text-dark" style="font-size: 0.8rem;">0</span>
            </a>
            <a class="nav-link text-white me-3" href="user_dashboard.php" style="transition: 0.3s;">My Dashboard</a>
            <span class="text-white me-3">Hi, <?= $_SESSION['user_name'] ?></span>
            <a href="logout.php" class="btn btn-sm text-white" style="border: 1px solid #fff; background-color: transparent; transition: 0.3s;">
                Logout
            </a>
        </div>
    </div>
</nav>




<!-- Main Section -->
<div class="container py-4">
    <h3 class="mb-4 text-center">📋 Available Food Items</h3>

    <!-- Search + Filter -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <input type="text" id="searchInput" class="form-control" placeholder="Search food name...">
        </div>
        <div class="col-md-4">
            <select id="categoryFilter" class="form-select">
                <option value="">All Restaurants</option>
                <?php while ($cat = $categories->fetch_assoc()): ?>
                    <option value="<?= $cat['restaurant_name'] ?>"><?= $cat['restaurant_name'] ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-secondary w-100" id="resetBtn">Reset</button>
        </div>
    </div>

    <!-- Food Items Result -->
    <div class="row g-4" id="foodItems">
        <!-- Food items will be loaded here -->
    </div>
</div>

<!-- Footer -->
<footer class="footer text-center">
    <div class="container">
        <p class="mb-1">© <?= date('Y') ?> FoodDelivery. All rights reserved.</p>
        <p class="mb-0">
            <a href="#">Privacy</a> | <a href="#">Terms</a> | <a href="user_dashboard.php">Dashboard</a>
        </p>
    </div>
</footer>

<script>
    function loadFoodItems(search = '', category = '') {
        $.ajax({
            url: 'ajax_fetch_food.php',
            type: 'POST',
            data: { search: search, category: category },
            success: function (data) {
                $('#foodItems').html(data);
            }
        });
    }

    $(document).ready(function () {
        // Initial load
        loadFoodItems();

        // On typing
        $('#searchInput').on('input', function () {
            const search = $(this).val();
            const category = $('#categoryFilter').val();
            loadFoodItems(search, category);
        });

        // On category change
        $('#categoryFilter').on('change', function () {
            const search = $('#searchInput').val();
            const category = $(this).val();
            loadFoodItems(search, category);
        });

        // On reset
        $('#resetBtn').on('click', function () {
            $('#searchInput').val('');
            $('#categoryFilter').val('');
            loadFoodItems();
        });
    });


    
function showUnavailableAlert() {
    Swal.fire({
        icon: 'error',
        title: 'Not Available',
        text: 'Sorry, this food is currently not available!',
        confirmButtonColor: '#d33',
        confirmButtonText: 'OK'
    });
}

$(document).on('click', '.addToCartBtn', function() {
    var foodId = $(this).data('id');
    $.ajax({
        url: 'add_to_cart.php',
        type: 'POST',
        data: { food_id: foodId },
        dataType: 'json',  // IMPORTANT: Expect JSON
        success: function(response) {
            if (response.status === 'success' || response.status === 'info') {
                Swal.fire({
                    icon: response.status === 'success' ? 'success' : 'info',
                    title: response.status === 'success' ? 'Added!' : 'Info',
                    text: response.message,
                    timer: 1500,
                    showConfirmButton: false
                });

                // Update cart count
                $('#cart-count').text(response.cart_count);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                });
            }
        }
    });
});


    // Adding 'sticky-nav' class when the navbar is sticky (for shadow effect)
    window.onscroll = function() {
        var navbar = document.querySelector('.navbar');
        if (window.scrollY > 0) {
            navbar.classList.add('sticky-nav');
        } else {
            navbar.classList.remove('sticky-nav');
        }
    };



</script>
</body>
</html>


