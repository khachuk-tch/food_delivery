
<?php
//require_once 'config.php';

//define('ROOT_PATH', dirname(__DIR__)); // when in public/

//require_once ROOT_PATH . '/includes/config.php';
 require_once __DIR__ . '/../includes/config.php'; // from public/index.php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#ffffff">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added for mobile responsiveness -->
    <title>Local Food Delivery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="manifest" href="../manifest.json">
    <meta name="theme-color" content="#ff6347">
    <script src="js/script.js"></script>


    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f9f9f9;
        }

        .navbar {
            background:rgb(238, 248, 236);
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .navbar-brand {
            font-weight: bold;
            color: #ff5722 !important;
        }

        .nav-link {
            font-weight: 500;
            color: #555 !important;
        }

        .nav-link:hover {
            color: #ff5722 !important;
        }

        .hero {
            height: 90vh;
            background: linear-gradient(to right, rgba(0,0,0,0.6), rgba(0,0,0,0.1)),
                        url('assets/images/food-bg.jpg') center center/cover no-repeat;
            color: white;
            display: flex;
            align-items: center;
            padding-left: 10%;
            position: relative;
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.2rem;
            max-width: 600px;
        }

        .btn-cta {
            margin-top: 1rem;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 30px;
            background: #ff5722;
            color: white;
            transition: 0.3s ease;
            border: none;
        }

        .btn-cta:hover {
            background: #e64a19;
            color: white;
        }

        .feature-box {
            text-align: center;
            padding: 2rem 1rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            background: white;
        }

        .feature-icon {
            font-size: 2.5rem;
            color: #ff5722;
            margin-bottom: 1rem;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .card-img-top {
            height: 220px;
            object-fit: cover;
            transition: 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-title {
            font-weight: bold;
            color: #333;
        }

        .card-text {
            color: #ff5722;
            font-weight: bold;
            font-size: 1.1rem;
            margin-bottom: 1.2rem;
        }

        .card:hover .btn-cta {
            opacity: 1;
            transform: translateY(0);
        }

        .btn-cta {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
            margin-top: 0.5rem;
            padding: 8px 20px;
            font-size: 1rem;
            border-radius: 30px;
            background: #ff5722;
            color: white;
            border: none;
        }

        footer {
            background: #fff;
            padding: 1.5rem 0;
            text-align: center;
            border-top: 1px solid #eee;
        }

        /* Responsive adjustments for smaller devices */
        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                padding: 2rem 1rem;
                height: auto;
                text-align: center;
                background-position: center center;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
                max-width: 100%;
            }

            .btn-cta {
                padding: 10px 20px;
                font-size: 1rem;
                opacity: 1;
                transform: translateY(0);
            }

            .card-img-top {
                height: 180px;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>

<!-- Add Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="#">
            🍽️ Khachuk Local Food
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav gap-2">
                <li class="nav-item">
                    <a class="nav-link fs-5" href="#">
                        <i class="bi bi-house-door-fill me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="../user/register.php">
                        <i class="bi bi-person-plus-fill me-1"></i> User Register
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="../user/login.php">
                        <i class="bi bi-box-arrow-in-right me-1"></i> User Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link fs-5" href="../admin/login.php">
                        <i class="bi bi-shield-lock-fill me-1"></i> Admin
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<!-- Hero Section -->
<div class="hero mt-3">
    <!-- Background Video -->
    <video autoplay muted loop playsinline class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" id="heroVideo">
        <source src="videos/food1.mp4" type="video/mp4">
        <source src="videos/food2.mp4" type="video/mp4">
         <source src="videos/food3.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Content -->
    <div class="container position-relative text-white d-flex flex-column justify-content-center align-items-start h-100" style="z-index: 2;">
        <h1 class="display-3 fw-bold">Joydeb Kalai Delicious</h1>
        <h1 class="display-3 fw-bold">Food Delivered Hotel</h1>
        <p class="lead my-4">Enjoy hot, fresh meals from your favorite local restaurants, delivered to your door with a smile.</p>
        <a href="user/login.php" class="btn btn-cta">Start Ordering</a>
    </div>

    <!-- Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: rgba(0,0,0,0.4); z-index: 1;"></div>
</div>

<!-- Popular Foods -->
<section class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Our Popular Foods</h2>
        <p>Fresh, hot, and made just for you!</p>
    </div>
    <div class="row g-4">
        <?php
        $result = $conn->query("SELECT * FROM food_items ORDER BY RAND() LIMIT 6");
        while ($row = $result->fetch_assoc()) {
        ?>
        <div class="col-md-4 col-sm-6">
            <div class="card h-100">
                <img src="uploads/<?php echo $row['image']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['food_name']); ?>">
                <div class="card-body text-center d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title"><?php echo htmlspecialchars($row['food_name']); ?></h5>
                        <p class="card-text">$<?php echo number_format($row['price'], 2); ?></p>
                    </div>
                    <a href="../user/register.php" class="btn btn-cta btn-sm mt-3">Order Now</a>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</section>

<!-- Features -->
<section class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Why Choose Us?</h2>
        <p>We partner with your favorite local restaurants and deliver fast.</p>
    </div>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="feature-box">
                <div class="feature-icon">🚀</div>
                <h5>Fast Delivery</h5>
                <p>Get your meals delivered in under 30 minutes.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <div class="feature-icon">🍔</div>
                <h5>Best Restaurants</h5>
                <p>Choose from a variety of local and popular spots.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-box">
                <div class="feature-icon">📱</div>
                <h5>Easy to Use</h5>
                <p>Simple and user-friendly experience on any device.</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer>
    <div class="container">
        <p>&copy; <?= date('Y') ?> LocalFood Delivery. All rights reserved.</p>
    </div>
</footer>

<!-- Video Rotation Script -->
<script>
    const video = document.getElementById('heroVideo');
    const videoSources = [
        'videos/food1.mp4',
        'videos/food2.mp4',
        'videos/food3.mp4'
    ];
    let currentVideo = 0;

    setInterval(() => {
        currentVideo = (currentVideo + 1) % videoSources.length;
        video.src = videoSources[currentVideo];
        video.load();
        video.play();
    }, 7000);
</script>



<!-- Add this at the bottom of public/index.php, before </body> -->
<script>
if ('serviceWorker' in navigator) {
  navigator.serviceWorker.register('../service-worker.js', { scope: '../' })
    .then(reg => console.log('✅ Service Worker Registered!', reg))
    .catch(err => console.error('❌ Service Worker registration failed:', err));
}
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
