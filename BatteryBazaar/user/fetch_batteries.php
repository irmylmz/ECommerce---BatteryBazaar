<?php
require '../config.php';

if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];

    // Fetch batteries based on the selected category
    $batteries = berkhoca_query_parser("SELECT * FROM Batteries WHERE CategoryID = $category_id");

    $options = "<option value=''>Select Battery</option>";
    foreach ($batteries as $battery) {
        $options .= "<option value='{$battery['BatteryID']}' data-description='{$battery['Description']}'>{$battery['BatteryName']}</option>";
    }

    echo $options;
}
?>
