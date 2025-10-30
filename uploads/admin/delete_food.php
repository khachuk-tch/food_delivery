
<?php
// Database connection
//require_once '../config.php';

require_once __DIR__ . '/../includes/config.php'; // from public/index.php


// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is set
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // First, fetch image to delete from folder (optional)
    $img_query = "SELECT image FROM food_items WHERE id = $id";
    $img_result = $conn->query($img_query);
    if ($img_result->num_rows > 0) {
        $img_row = $img_result->fetch_assoc();
        $img_path = "uploads/" . $img_row['image'];
        if (file_exists($img_path)) {
            unlink($img_path); // delete image file
        }
    }

    // Delete the record
    $sql = "DELETE FROM food_items WHERE id = $id";
    if ($conn->query($sql)) {
        header("Location: manage_food_items.php?msg=deleted");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid ID.";
}

$conn->close();
?>
