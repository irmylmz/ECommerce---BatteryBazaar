<?php
require 'config.php'; // Admin klasöründeki config.php dosyasını dahil ediyoruz

// Check if user is logged in and is admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../login.php');
    exit;
}

// Fetch categories for the dropdown
$categories = berkhoca_query_parser("SELECT * FROM Categories");

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = $_POST['category_id'];
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $voltage = $_POST['voltage'];
    $width = $_POST['width'];
    $depth = $_POST['depth'];
    $height = $_POST['height'];
    $number_of_terminals = $_POST['number_of_terminals'];
    $weight = $_POST['weight'];

    $insert_sql = "INSERT INTO Batteries (CategoryID, Name, Capacity, Voltage, Width, Depth, Height, NumberOfTerminals, Weight) 
                   VALUES ('$category_id', '$name', '$capacity', '$voltage', '$width', '$depth', '$height', '$number_of_terminals', '$weight')";
    
    berk_hoce_insert_or_delete($insert_sql);

    header('Location: dashboard.php');
    exit;
}
?>

<?php
include 'partial/header.php';
?>

<div class="container mt-5">
    <h1>Add Battery</h1>
    <form method="post" action="add_battery.php">
        <div class="form-group mb-3">
            <label for="category_id">Category</label>
            <select class="form-control" id="category_id" name="category_id" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['CategoryID'] ?>"><?= htmlspecialchars($category['CategoryName']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="name">Battery Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group mb-3">
            <label for="capacity">Capacity (mAh)</label>
            <input type="number" class="form-control" id="capacity" name="capacity" required>
        </div>
        <div class="form-group mb-3">
            <label for="voltage">Voltage (V)</label>
            <input type="number" step="0.01" class="form-control" id="voltage" name="voltage" required>
        </div>
        <div class="form-group mb-3">
            <label for="width">Width (mm)</label>
            <input type="number" step="0.01" class="form-control" id="width" name="width" required>
        </div>
        <div class="form-group mb-3">
            <label for="depth">Depth (mm)</label>
            <input type="number" step="0.01" class="form-control" id="depth" name="depth" required>
        </div>
        <div class="form-group mb-3">
            <label for="height">Height (mm)</label>
            <input type="number" step="0.01" class="form-control" id="height" name="height" required>
        </div>
        <div class="form-group mb-3">
            <label for="number_of_terminals">Number of Terminals</label>
            <input type="number" class="form-control" id="number_of_terminals" name="number_of_terminals" required>
        </div>
        <div class="form-group mb-3">
            <label for="weight">Weight (kg)</label>
            <input type="number" step="0.01" class="form-control" id="weight" name="weight" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Battery</button>
    </form>
</div>
</body>
</html>
