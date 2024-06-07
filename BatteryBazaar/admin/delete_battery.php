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

// Delete the battery
$delete_sql = "DELETE FROM Batteries WHERE BatteryID = $battery_id";
berk_hoce_insert_or_delete($delete_sql);

header('Location: dashboard.php');
exit;
?>
