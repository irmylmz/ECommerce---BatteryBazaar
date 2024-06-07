<?php
require '../config.php';

if (isset($_GET['card_id'])) {
    $card_id = $_GET['card_id'];

    // Delete the credit card from the CreditCards table
    $sql = "DELETE FROM CreditCards WHERE CardID = $card_id";
    berk_hoce_insert_or_delete($sql);
    header('Location: dashboard.php');
}
?>
