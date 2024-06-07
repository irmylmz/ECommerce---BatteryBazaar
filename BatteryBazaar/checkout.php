<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Kullanıcının sepetindeki ürünleri al
$cart_items = berkhoca_query_parser("SELECT c.*, p.ProductName, p.Picture, p.Price FROM Cart c JOIN Products p ON c.ProductID = p.ProductID WHERE c.UserID = $user_id");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Siparişi tamamla
    $order_date = date('Y-m-d H:i:s');
    $total_amount = array_sum(array_map(function($item) { return $item['Quantity'] * $item['Price']; }, $cart_items));

    // Orders tablosuna yeni bir sipariş ekleyin
    $insert_order_sql = "INSERT INTO Orders (UserID, OrderDate, TotalAmount, OrderStatus) VALUES ($user_id, '$order_date', $total_amount, 'Pending')";
    if ($conn->query($insert_order_sql)) {
        // En son eklenen siparişin OrderID'sini alın
        $order_id = $conn->insert_id;

        // Sepet öğelerini OrderDetails tablosuna ekleyin
        foreach ($cart_items as $item) {
            $product_id = $item['ProductID'];
            $quantity = $item['Quantity'];
            $price_at_purchase = $item['Price'];
            $insert_order_details_sql = "INSERT INTO OrderDetails (OrderID, ProductID, Quantity, PriceAtPurchase) VALUES ($order_id, $product_id, $quantity, $price_at_purchase)";
            $conn->query($insert_order_details_sql);
        }

        // Sepeti temizleyin
        berk_hoce_insert_or_delete("DELETE FROM Cart WHERE UserID = $user_id");

        // Sipariş başarıyla tamamlandı sayfasına yönlendirin
        header('Location: order_success.php');
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

include 'partials/header.php';
?>

<div class="container my-5">
    <div class="row">
        <form class="col-md-12" method="post">
            <div class="site-blocks-table">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="product-thumbnail">Image</th>
                            <th class="product-name">Product</th>
                            <th class="product-price">Price</th>
                            <th class="product-quantity">Quantity</th>
                            <th class="product-total">Total</th>
                            <th class="product-remove">Remove</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cart_items)): ?>
                            <?php foreach ($cart_items as $item): ?>
                                <tr>
                                    <td class="product-thumbnail">
                                        <?php if (!empty($item['Picture'])): ?>
                                            <?php
                                            $img_data = base64_encode($item['Picture']);
                                            echo '<img src="data:image/jpeg;base64,' . $img_data . '" alt="Product Image" class="img-fluid">';
                                            ?>
                                        <?php else: ?>
                                            <img src="images/no_image_available.png" alt="No Image Available" class="img-fluid">
                                        <?php endif; ?>
                                    </td>
                                    <td class="product-name">
                                        <h2 class="h5 text-black"><?= htmlspecialchars($item['ProductName']) ?></h2>
                                    </td>
                                    <td>$<?= htmlspecialchars($item['Price']) ?></td>
                                    <td>
                                        <div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-outline-black decrease" type="button">&minus;</button>
                                            </div>
                                            <input type="text" class="form-control text-center quantity-amount" name="quantities[<?= $item['CartID'] ?>]" value="<?= htmlspecialchars($item['Quantity']) ?>" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-black increase" type="button">&plus;</button>
                                            </div>
                                        </div>
                                    </td>
                                    <td>$<?= htmlspecialchars($item['Quantity'] * $item['Price']) ?></td>
                                    <td><a href="remove_from_cart.php?cart_id=<?= $item['CartID'] ?>" class="btn btn-black btn-sm">X</a></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">Your cart is empty.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <button type="submit" class="btn btn-black btn-sm btn-block">Complete Purchase</button>
        </form>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <button class="btn btn-outline-black btn-sm btn-block">Continue Shopping</button>
        </div>
        <div class="col-md-6">
            <div class="row justify-content-end">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12 text-right border-bottom mb-5">
                            <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <span class="text-black">Subtotal</span>
                        </div>
                        <div class="col-md-6 text-right">
                            <strong class="text-black">$<?= number_format(array_sum(array_map(function($item) { return $item['Quantity'] * $item['Price']; }, $cart_items)), 2) ?></strong>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col-md-6">
                            <span class="text-black">Total</span>
                        </div>
                        <div class="col-md-6 text-right">
                            <strong class="text-black">$<?= number_format(array_sum(array_map(function($item) { return $item['Quantity'] * $item['Price']; }, $cart_items)), 2) ?></strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <a href="checkout.php" class="btn btn-black btn-lg py-3 btn-block">Proceed To Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'partials/footer.php';
?>
