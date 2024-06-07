<?php
require 'config/db.php';
// Kategorileri veritabanından çekin
$categories = berkhoca_query_parser("SELECT * FROM Categories");
?>

<?php
require 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user_logged_in']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../login.php');
    exit;
}

// Fetch user information
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM Users WHERE UserID = $user_id";
$user_info = berkhoca_query_parser($sql);

?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">

  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />
		<!-- Bootstrap CSS -->
		<link href="<?= ROOT_URL?>css/bootstrap.min.css" rel="stylesheet">
		<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
		<link href="<?= ROOT_URL?>css/tiny-slider.css" rel="stylesheet">
		<link href="<?= ROOT_URL?>css/style.css" rel="stylesheet">
		<link href="<?= ROOT_URL?>css/custom.css" rel="stylesheet">
		<title>Battery Bazaar</title>
	</head>

	<body>

		<!-- Start Header/Navigation -->
		<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">
			<div class="container">
				<a class="navbar-brand" href="<?= ROOT_URL?>home.php">BatteryBazaar<span>.</span></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarsFurni">
					<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
						<li class="nav-item"><a class="nav-link" href="<?= ROOT_URL?>home.php">Home</a></li>
						<li><a class="nav-link" href="<?= ROOT_URL?>shop.php">Shop</a></li>
						<li><a class="nav-link" href="<?= ROOT_URL?>about.php">About us</a></li>
						<li class="nav-item dropdown"> <!-- Added dropdown class -->
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
								Categories
							</a>
							<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
        					<?php foreach ($categories as $category): ?>
            				<li><a class="dropdown-item" href="<?= ROOT_URL ?>category.php?category_id=<?= $category['CategoryID'] ?>"><?= htmlspecialchars($category['CategoryName']) ?></a></li>
    						<?php endforeach; ?>
    						</ul>
						</li>
						<li><a class="nav-link" href="<?= ROOT_URL?>blog.php">Blog</a></li>
						<li><a class="nav-link" href="<?= ROOT_URL?>contact.php">Contact us</a></li>
					</ul>
					<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
						<li><a class="nav-link" href="<?= ROOT_URL?>login.php"><img src="<?= ROOT_URL?>img/user.svg"></a></li>
						<li><a class="nav-link" href="<?= ROOT_URL?>cart.php"><img src="<?= ROOT_URL?>img/cart.svg"></a></li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- End Header/Navigation -->
