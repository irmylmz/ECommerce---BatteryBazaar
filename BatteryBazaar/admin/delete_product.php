<?php
require '../config.php';

if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Delete the product from the Products table
    $sql = "DELETE FROM Products WHERE ProductID = $product_id";
    berk_hoce_insert_or_delete($sql);
    header('Location: dashboard.php');
}
?>
