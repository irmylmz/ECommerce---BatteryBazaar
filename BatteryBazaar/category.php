<?php
require_once 'config.php'; // Veritabanı bağlantısı için config dosyasını dahil edin

// Kategori ID'sini GET parametresinden alın
$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Kategoriye ait ürünleri veritabanından çekin
$products = berkhoca_query_parser("SELECT * FROM Products WHERE CategoryID = $category_id");

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
            <div class="col-lg-7"></div>
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
                        <div class="product-item">
                            <a href="product_detail.php?product_id=<?= $product['ProductID'] ?>">
                                <?php if (!empty($product['Picture'])): ?>
                                    <?php
                                    $img_data = base64_encode($product['Picture']);
                                    echo '<img src="data:image/jpeg;base64,' . $img_data . '" alt="Product Image" class="img-fluid product-thumbnail">';
                                    ?>
                                <?php else: ?>
                                    <img src="images/no_image_available.png" alt="No Image Available" class="img-fluid product-thumbnail">
                                <?php endif; ?>
                                <h3 class="product-title"><?= htmlspecialchars($product['ProductName']) ?></h3>
                                <strong class="product-price">$<?= htmlspecialchars($product['Price']) ?></strong>
                                <br>
                                <a href="add_to_cart.php?product_id=<?= $product['ProductID'] ?>&quantity=1" class="btn btn-primary">Add to Cart</a>
                            </a>
                            
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found for this category.</p>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php
include 'partials/footer.php';
?>
