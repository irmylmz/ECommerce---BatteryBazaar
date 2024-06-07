<?php
require '../config.php';

// Check if category_id is provided
if (isset($_POST['category_id'])) {
    $category_id = intval($_POST['category_id']);
    $batteries = berkhoca_query_parser("SELECT * FROM Batteries WHERE CategoryID = $category_id");

    foreach ($batteries as $battery) {
        echo '<option value="' . $battery['BatteryID'] . '">' . htmlspecialchars($battery['Name']) . '</option>';
    }
} else {
    echo '<option value="">No batteries found</option>';
}
?>

