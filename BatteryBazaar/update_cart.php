<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $quantities = isset($_POST['quantities']) ? $_POST['quantities'] : [];
    
    foreach ($quantities as $order_detail_id => $quantity) {
        $order_detail_id = intval($order_detail_id);
        $quantity = intval($quantity);
        
        if ($quantity > 0) {
            $update_sql = "UPDATE OrderDetails SET Quantity = $quantity WHERE OrderDetailID = $order_detail_id AND OrderID IS NULL";
            berk_hoce_insert_or_delete($update_sql);
        } else {
            $delete_sql = "DELETE FROM OrderDetails WHERE OrderDetailID = $order_detail_id AND OrderID IS NULL";
            berk_hoce_insert_or_delete($delete_sql);
        }
    }
}

header('Location: cart.php');
exit;
?>
