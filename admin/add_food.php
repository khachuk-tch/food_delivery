
<?php

//require_once '../config.php';

require_once __DIR__ . '/../includes/config.php'; // from public/index.php



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $restaurant_name = $_POST['restaurant_name'];
    $food_name = $_POST['food_name'];
    $weight = $_POST['weight'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $availability = $_POST['availability'];

    // Handle image upload
    $image_name = '';
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'] != '') {
        $image_name = time() . '_' . basename($_FILES['image']['name']);
        //$target = '../uploads/' . $image_name;
        $target = '../public/uploads/' . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO food_items (restaurant_name, food_name, weight, description, price, image, category, availability)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $restaurant_name, $food_name,  $weight, $description, $price, $image_name, $category, $availability);
    $stmt->execute();

    $success = "Food item added successfully!";
}
?>


<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
  <div class="container mt-4">

      <h2 class="mb-4 text-center">Add Food Item</h2>
      

      
    <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
    <form method="post" enctype="multipart/form-data" class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Restaurant Name</label>
            <input type="text" name="restaurant_name" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Food Name</label>
            <input type="text" name="food_name" class="form-control" required>
        </div>

        <div class="col-md-4">
         <label class="form-label">Weight</label>
         <input type="text" name="weight" class="form-control" placeholder="e.g., 250g, 500g, 1kg">
         </div>

        <div class="col-md-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>
        <div class="col-md-4">
            <label class="form-label">Price (₹)</label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control">
        </div>
        <div class="col-md-4">
            <label class="form-label">Availability</label>
            <select name="availability" class="form-select">
                <option value="Available">Available</option>
                <option value="Unavailable">Unavailable</option>
            </select>
        </div>
        <div class="col-md-12">
            <label class="form-label">Upload Image</label>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Add Food</button>
        </div>
    </form>

  </div>
</div>


<?php include 'includes/footer.php'; ?>