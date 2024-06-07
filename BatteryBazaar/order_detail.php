<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$order_id = intval($_GET['order_id']);

// Sipariş detaylarını al
$order_details = berkhoca_query_parser("SELECT od.*, p.ProductName, p.Picture FROM OrderDetails od JOIN Products p ON od.ProductID = p.ProductID WHERE od.OrderID = $order_id");

include 'partials/header.php';
?>

<div class="container my-5">
    <h2>Order Details</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Image</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_details as $detail): ?>
                <tr>
                    <td><?= htmlspecialchars($detail['ProductName']) ?></td>
                    <td>
                        <?php if (!empty($detail['Picture'])): ?>
                            <?php
                            $img_data = base64_encode($detail['Picture']);
                            echo '<img src="data:image/jpeg;base64,' . $img_data . '" alt="Product Image" class="img-fluid" style="max-width: 100px; max-height: 100px;">';
                            ?>
                        <?php else: ?>
                            <img src="images/no_image_available.png" alt="No Image Available" class="img-fluid" style="max-width: 100px; max-height: 100px;">
                        <?php endif; ?>
                    </td>
                    <td>$<?= number_format($detail['PriceAtPurchase'], 2) ?></td>
                    <td><?= htmlspecialchars($detail['Quantity']) ?></td>
                    <td>$<?= number_format($detail['PriceAtPurchase'] * $detail['Quantity'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
include 'partials/footer.php';
?>
