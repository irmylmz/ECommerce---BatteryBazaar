<?php
require_once 'config.php'; // Veritabanı bağlantısı için config dosyasını dahil edin

// Ürün ID'sini GET parametresinden alın
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

// Ürün bilgilerini veritabanından çekin
$product = berkhoca_query_parser("SELECT * FROM Products WHERE ProductID = $product_id");

if (empty($product)) {
    echo "Product not found.";
    exit;
}

$product = $product[0]; // Sonuçlar tek bir ürün olduğu için ilk öğeyi alıyoruz

include 'partials/header.php';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($product['Picture'])): ?>
                <?php
                $img_data = base64_encode($product['Picture']);
                echo '<img src="data:image/jpeg;base64,' . $img_data . '" alt="Product Image" class="img-fluid">';
                ?>
            <?php else: ?>
				<img src="img/unnamed.png" alt="No Image Available" class="img-fluid product-thumbnail">
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <h1><?= htmlspecialchars($product['ProductName']) ?></h1>
            <p><?= htmlspecialchars($product['Description']) ?></p>
            <p><strong>Price: $<?= htmlspecialchars($product['Price']) ?></strong></p>
            <p><strong>Discount: <?= htmlspecialchars($product['Discount']) ?>%</strong></p>
            <p><strong>Stock Quantity: <?= htmlspecialchars($product['StockQuantity']) ?></strong></p>
            <a href="add_to_cart.php?product_id=<?= $product['ProductID'] ?>&quantity=1" class="btn btn-primary">Add to Cart</a>
        </div>
    </div>
</div>
<br>
<br>
<br>

<?php
include 'partials/footer.php';
?>
