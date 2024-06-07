<?php
require 'config.php';

//--to display PHP errors--
ini_set('display_errors', '1'); // 1 is on, 0 is off
ini_set('display_startup_errors', '1'); // 1 is on, 0 is off
error_reporting(E_ALL);

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header('Location: login.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];

    if (!empty($category_name)) {
        // Get the current highest CategoryOrder
        $result = $conn->query("SELECT MAX(CategoryOrder) as max_order FROM Categories");
        $row = $result->fetch_assoc();
        $max_order = $row['max_order'];
        $new_order = $max_order + 1;

        // Insert new category into the database
        $insert_category_query = "INSERT INTO Categories (CategoryName, CategoryOrder) VALUES ('$category_name', '$new_order')";
        if ($conn->query($insert_category_query)) {
            header('Location: dashboard.php');
            exit;
        } else {
            $error_message = "Error: " . $conn->error;
        }
    } else {
        $error_message = "Category name cannot be empty.";
    }
}
?>

<?php
include 'partial/header.php';
?>

<div class="container mt-5">
    <h1>Add Category</h1>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error_message) ?>
        </div>
    <?php endif; ?>
    <form method="post" action="add_category.php">
        <div class="form-group mb-3">
            <label for="category_name">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>
</div>


