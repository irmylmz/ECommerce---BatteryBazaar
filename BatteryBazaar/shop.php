<?php
require_once 'config.php'; // Veritabanı bağlantısı için config dosyasını dahil edin

// Fetch products from the database
$products = berkhoca_query_parser("SELECT * FROM Products");
?>

<?php
include 'partials/header.php';
?>

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Shop</h1>
                </div>
            </div>
            <div class="col-lg-7">
                
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">

            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                        <a class="product-item" href="product_detail.php?product_id=<?= $product['ProductID'] ?>">
                            <?php if (!empty($product['Picture'])): ?>
                                <?php
                                $img_data = base64_encode($product['Picture']);
                                echo '<img src="data:image/jpeg;base64,' . $img_data . '" alt="Product Image" class="img-fluid product-thumbnail">';
                                ?>
                            <?php else: ?>
                                <img src="img/unnamed.png" alt="No Image Available" class="img-fluid product-thumbnail">
                            <?php endif; ?>
                            <h3 class="product-title"><?= htmlspecialchars($product['ProductName']) ?></h3>
                            <strong class="product-price">$<?= htmlspecialchars($product['Price']) ?></strong>
                            <span class="icon-cross">
                                <img href="add_to_cart.php" src="img/cross.svg" class="img-fluid">
                            </span>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php
include 'partials/footer.php';
?>
