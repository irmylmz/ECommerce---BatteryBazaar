<?php
require 'config.php'; // Admin klasöründeki config.php dosyasını dahil ediyoruz

// Fetch all products
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
								<h1>Modern Address of <span clsas="d-block">Quality Battery</span></h1>
								<p class="mb-4">Keep your car running smoothly with our top-quality batteries. Designed for reliability and long-lasting performance, our batteries are the power you can count on. Shop now and drive with confidence!</p>
								<p><a href="" class="btn btn-secondary me-2">Shop Now</a></p>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="hero-img-wrap">
								<img src="img/aküler.png" href="shop.php" class="img-fluid">
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- End Hero Section -->


		<!-- Start Why Choose Us Section -->
		<div class="why-choose-section">
			<div class="container">
				<div class="row justify-content-between">
					<div class="col-lg-6">
						<h2 class="section-title">Why Choose Us</h2>
						<p>Choosing the right battery supplier is crucial for your vehicle's longevity and performance. At Battery Bazaar, we are a reliable and trustworthy partner for all your battery needs. Our commitment to excellence and customer satisfaction sets us apart. Here’s why you can confidently choose us:</p>

						<div class="row my-5">
							<div class="col-6 col-md-6">
								<div class="feature">
									<div class="icon">
										<img src="img/truck.svg" alt="Image" class="imf-fluid">
									</div>
									<h3>Fast &amp; Free Shipping</h3>
									<p>Get your battery promptly and without extra charges, ensuring a smooth journey.
									</p>
								</div>
							</div>

							<div class="col-6 col-md-6">
								<div class="feature">
									<div class="icon">
										<img src="img/bag.svg" alt="Image" class="imf-fluid">
									</div>
									<h3>Easy to Shop</h3>
									<p>Find the right battery effortlessly on our user-friendly website, simplifying your shopping experience.
									</p>
								</div>
							</div>

							<div class="col-6 col-md-6">
								<div class="feature">
									<div class="icon">
										<img src="img/support.svg" alt="Image" class="imf-fluid">
									</div>
									<h3>24/7 Support</h3>
									<p>Receive expert assistance anytime you need it, empowering confident decisions with round-the-clock support.
									</p>
								</div>
							</div>

							<div class="col-6 col-md-6">
								<div class="feature">
									<div class="icon">
										<img src="img/return.svg" alt="Image" class="imf-fluid">
									</div>
									<h3>Hassle Free Returns</h3>
									<p>Enjoy a straightforward returns process for exchanges or returns, ensuring confident shopping.
									</p>
								</div>
							</div>

						</div>
					</div>

					<div class="col-lg-5">
						<div class="img-wrap">
							<img src="img/whyus.jpeg" alt="Image" class="img-fluid">
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- End Why Choose Us Section -->

		<div class="popular-product">
    	<div class="container" href="shop.php">
        	<div class="row">

            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
                        <div class="product-item-sm d-flex">
                            <div class="thumbnail">
                                <?php if (!empty($product['Picture'])): ?>
                                    <?php
                                    $img_data = base64_encode($product['Picture']);
                                    echo '<img src="data:image/jpeg;base64,' . $img_data . '" href="product_detail.php?product_id=' . $product['ProductID'] . '" alt="Product Image" class="img-fluid">';
                                    ?>
                                <?php else: ?>
                                    <img src="img/unnamed.png" href="product_detail.php?product_id=<?= $product['ProductID'] ?>" alt="No Image Available" class="img-fluid">
                                <?php endif; ?>
                            </div>
                            <div class="pt-3">
                                <h3><?= htmlspecialchars($product['ProductName']) ?></h3>
                                <p><?= htmlspecialchars($product['Description']) ?></p>
                                <p><strong>Price: $<?= htmlspecialchars($product['Price']) ?></strong></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No popular products found.</p>
            <?php endif; ?>

        </div>
    </div>
</div>


        <!-- Start Popular Product -->
		<div class="popular-product">
			<div class="container">
				<div class="row">

					<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
						<div class="product-item-sm d-flex">
							<div class="thumbnail">
								<img src="img/d24.png" href="product_detail.php" alt="Image" class="img-fluid">
							</div>
							<div class="pt-3">
								<h3>VARTA BLUE DYNAMIC</h3>
								<p>60 ahm, 12 volt</p>
								<p>Provides superior energy and durability for high performance vehicles.</p>
							</div>
						</div>
					</div>

					<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
						<div class="product-item-sm d-flex">
							<div class="thumbnail">
								<img src="img/inci60ah.png" href="product_detail.php" alt="Image" class="img-fluid">
							</div>
							<div class="pt-3">
								<h3>İNCİ TAURUS</h3>
								<p>60 ahm, 12 volt</p>
								<p>Stable power for standard vehicles, ensuring effortless starts.</p>
							</div>
						</div>
					</div>

					<div class="col-12 col-md-6 col-lg-4 mb-4 mb-lg-0">
						<div class="product-item-sm d-flex">
							<div class="thumbnail">
								<img src="img/n70.png" href="product_detail.php" alt="Image" class="img-fluid">
							</div>
							<div class="pt-3">
								<h3>VARTA BLUE DYNAMIC EFB</h3>
								<p>70 ahm, 12 volt</p>
								<p>Offers improved energy efficiency and durability for demanding rides.</p>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<!-- End Popular Product -->

<?php
include 'partials/footer.php';
?>