<?php
include 'config.php';

if (isset($_GET['category_id'])) {
    $categoryID = $_GET['category_id'];

    $sql = "DELETE FROM Categories WHERE CategoryID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $categoryID);

    if ($stmt->execute()) {
        header("Location: categories.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>