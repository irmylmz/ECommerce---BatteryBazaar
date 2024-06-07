<?php
require 'config.php'; // Admin klasöründeki config.php dosyasını dahil ediyoruz

// Check if user is logged in and is admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../login.php');
    exit;
}

// Check if battery_id is provided
if (!isset($_GET['battery_id']) || empty($_GET['battery_id'])) {
    header('Location: dashboard.php');
    exit;
}

$battery_id = intval($_GET['battery_id']); // Güvenlik için tam sayıya çeviriyoruz

// Fetch battery information
$battery_info = berkhoca_query_parser("SELECT * FROM Batteries WHERE BatteryID = $battery_id");

if (empty($battery_info)) {
    header('Location: dashboard.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $capacity = $_POST['capacity'];
    $voltage = $_POST['voltage'];
    $width = $_POST['width'];
    $depth = $_POST['depth'];
    $height = $_POST['height'];
    $number_of_terminals = $_POST['number_of_terminals'];
    $weight = $_POST['weight'];

    $update_sql = "UPDATE Batteries SET 
                   Name = '$name', 
                   Capacity = '$capacity', 
                   Voltage = '$voltage', 
                   Width = '$width', 
                   Depth = '$depth', 
                   Height = '$height', 
                   NumberOfTerminals = '$number_of_terminals', 
                   Weight = '$weight'
                   WHERE BatteryID = $battery_id";
    
    berk_hoce_insert_or_delete($update_sql);

    header('Location: dashboard.php');
    exit;
}
?>

<?php
include 'partial/header.php';
?>

<div class="container mt-5">
    <h1>Edit Battery</h1>
    <form method="post" action="edit_battery.php?battery_id=<?= htmlspecialchars($battery_id) ?>">
        <div class="form-group mb-3">
            <label for="name">Battery Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($battery_info[0]['Name']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="capacity">Capacity (mAh)</label>
            <input type="number" class="form-control" id="capacity" name="capacity" value="<?= htmlspecialchars($battery_info[0]['Capacity']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="voltage">Voltage (V)</label>
            <input type="number" step="0.01" class="form-control" id="voltage" name="voltage" value="<?= htmlspecialchars($battery_info[0]['Voltage']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="width">Width (mm)</label>
            <input type="number" step="0.01" class="form-control" id="width" name="width" value="<?= htmlspecialchars($battery_info[0]['Width']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="depth">Depth (mm)</label>
            <input type="number" step="0.01" class="form-control" id="depth" name="depth" value="<?= htmlspecialchars($battery_info[0]['Depth']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="height">Height (mm)</label>
            <input type="number" step="0.01" class="form-control" id="height" name="height" value="<?= htmlspecialchars($battery_info[0]['Height']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="number_of_terminals">Number of Terminals</label>
            <input type="number" class="form-control" id="number_of_terminals" name="number_of_terminals" value="<?= htmlspecialchars($battery_info[0]['NumberOfTerminals']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="weight">Weight (kg)</label>
            <input type="number" step="0.01" class="form-control" id="weight" name="weight" value="<?= htmlspecialchars($battery_info[0]['Weight']) ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Battery</button>
    </form>
</div>
</body>
</html>
