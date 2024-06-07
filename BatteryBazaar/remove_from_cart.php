<?php
session_start();
require 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$order_detail_id = isset($_GET['order_detail_id']) ? intval($_GET['order_detail_id']) : 0;

$delete_sql = "DELETE FROM OrderDetails WHERE OrderDetailID = $order_detail_id AND OrderID IS NULL";
berk_hoce_insert_or_delete($delete_sql);

header('Location: cart.php');
exit;
?>
