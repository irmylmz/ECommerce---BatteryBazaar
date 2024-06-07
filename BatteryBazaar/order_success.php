<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

include 'partials/header.php';
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-12 text-center">
            <h1>Thank you for your order!</h1>
            <p>Your order has been placed successfully. We will process it shortly.</p>
            <a href="home.php" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</div>

<?php
include 'partials/footer.php';
?>
