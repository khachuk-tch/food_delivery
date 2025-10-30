
<?php


session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
//require_once '../config.php';

require_once __DIR__ . '/../includes/config.php'; // from public/index.php



if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Optionally delete user photo from uploads/
    $result = $conn->query("SELECT photo FROM users WHERE id=$id");
    if ($result->num_rows > 0) {
        $photo = $result->fetch_assoc()['photo'];
        if (file_exists("../uploads/" . $photo)) {
            unlink("../uploads/" . $photo);
        }
    }

    $sql = "DELETE FROM users WHERE id=$id";
    if ($conn->query($sql)) {
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}
?>
