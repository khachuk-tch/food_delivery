

<?php
 //require_once '../config.php';

 require_once __DIR__ . '/../includes/config.php'; // from public/index.php

 
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch current data
$sql = "SELECT * FROM food_items WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$old_image = $row['image']; // Store old image name

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $restaurant_name = $_POST['restaurant_name'];
    $food_name = $_POST['food_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $availability = $_POST['availability'];

    // Image upload
    if ($_FILES['image']['name'] != '') {
        $image_name = time() . "_" . $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image_name);

        // Delete old image
        if (file_exists("uploads/" . $old_image)) {
            unlink("uploads/" . $old_image);
        }

        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
    } else {
        $image_name = $old_image;
    }

    $update_sql = "UPDATE food_items SET 
        restaurant_name='$restaurant_name', 
        food_name='$food_name', 
        description='$description', 
        price='$price', 
        category='$category', 
        availability='$availability',
        image='$image_name'
        WHERE id=$id";

    if ($conn->query($update_sql)) {
        header("Location: manage_food_items.php?msg=updated");
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Added for mobile responsiveness -->

  <title>Edit Food Item</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: #f4f6f8;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    header {
      background: #3b82f6;
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
    }

    footer {
      background: #3b82f6;
      color: white;
      text-align: center;
      padding: 10px;
      margin-top: auto;
      font-size: 14px;
    }

    .container {
      max-width: 900px;
      margin: 30px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #333;
    }

    form {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
    }

    .form-group {
      flex: 1 1 45%;
      display: flex;
      flex-direction: column;
    }

    form label {
      margin-bottom: 5px;
      font-weight: 500;
      color: #555;
    }

    form input[type="text"],
    form input[type="number"],
    form input[type="file"],
    form textarea,
    form select {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 8px;
      background: #f9f9f9;
      width: 100%;
    }

    form textarea {
      resize: vertical;
      min-height: 80px;
    }

    .image-preview {
      margin-top: 10px;
      max-width: 150px;
      border-radius: 8px;
    }

    .full-width {
      flex: 1 1 100%;
    }

    .button-group {
      margin-top: 20px;
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    .button-group button,
    .button-group a {
      background: #3b82f6;
      color: white;
      padding: 10px 30px;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s;
    }

    .button-group button:hover,
    .button-group a:hover {
      background: #2563eb;
    }

    @media (max-width: 768px) {
      .form-group {
        flex: 1 1 100%;
      }
    }

    form input[type="text"],
form input[type="number"],
form input[type="file"],
form textarea,
form select {
    padding: 12px;
    font-size: 16px; /* bigger text */
    border: 1px solid #ccc;
    border-radius: 8px;
    background: #f9f9f9;
    width: 100%;
}


  </style>
</head>

<body>


<?php include 'includes/header.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="main-content">
  <div class="container mt-4">

      <h2>Edit Food Details</h2>
  <form method="POST" action="" enctype="multipart/form-data">
    <div class="form-group">
      <label>Restaurant Name:</label>
      <input type="text" name="restaurant_name" value="<?= htmlspecialchars($row['restaurant_name']) ?>" required>
    </div>

    <div class="form-group">
      <label>Food Name:</label>
      <input type="text" name="food_name" value="<?= htmlspecialchars($row['food_name']) ?>" required>
    </div>

    <div class="form-group">
      <label>Price:</label>
      <input type="number" step="0.01" name="price" value="<?= $row['price'] ?>" required>
    </div>

    <div class="form-group">
      <label>Category:</label>
      <input type="text" name="category" value="<?= htmlspecialchars($row['category']) ?>">
    </div>

    <div class="form-group full-width">
      <label>Description:</label>
      <textarea name="description" required><?= htmlspecialchars($row['description']) ?></textarea>
    </div>

    <div class="form-group">
      <label>Availability:</label>
      <select name="availability">
        <option value="Available" <?= $row['availability'] == 'Available' ? 'selected' : '' ?>>Available</option>
        <option value="Unavailable" <?= $row['availability'] == 'Unavailable' ? 'selected' : '' ?>>Unavailable</option>
      </select>
    </div>

    <div class="form-group">
      <label>Current Image:</label>
      <img src="uploads/<?= $row['image'] ?>" class="image-preview" alt="Current Image">
    </div>

    <div class="form-group full-width">
      <label>Change Image:</label>
      <input type="file" name="image">
    </div>

    <div class="button-group full-width">
      <button type="submit">Update</button>
      <a href="manage_food_items.php">Cancel</a>
    </div>
  </form>

  </div>
</div>



<footer>
  &copy; <?= date('Y') ?> Food Delivery System. All rights reserved.
</footer>

</body>
</html>

<?php $conn->close(); ?>