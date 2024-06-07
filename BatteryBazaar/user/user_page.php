<?php
require '../config.php';

// Check if user is logged in
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

// Fetch user information
$user_id = $_SESSION['user_id'];
$user_info = berkhoca_query_parser("SELECT * FROM Users WHERE UserID = $user_id");

// Fetch products associated with the logged-in user
$products = berkhoca_query_parser("SELECT * FROM Products WHERE ProductSeller = $user_id");

// Fetch credit cards associated with the logged-in user
$credit_cards = berkhoca_query_parser("SELECT * FROM CreditCards WHERE UserID = $user_id");
?>

<?php
include 'partial/header.php';
?>

<body>
    <div class="container mt-5">
        <h1>Welcome to Your Dashboard, <?= htmlspecialchars($user_info[0]['FirstName']) ?></h1>
        <div class="mb-4">
            <a href="edit_user.php" class="btn btn-primary">Edit User Info</a>
            <a href="add_product.php" class="btn btn-success">Add Product</a>
        </div>

        <h2>Product List</h2>
        <table class="table table-bordered">
    <thead>
        <tr>
            <th>Picture</th>
            <th>Product Name</th>
            <th>Description</th>
            <th>Price</th>
            <th>Discount</th>
            <th>Stock Quantity</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td>
                <?php if (!empty($product['PictureUrl']) && file_exists($product['PictureUrl'])): ?>
                    <img src="<?= htmlspecialchars($product['PictureUrl']) ?>" alt="Product Image" style="max-width: 100px; max-height: 100px;">
                <?php else: ?>
                    <img src="img/d24" alt="No Image Available" style="max-width: 100px; max-height: 100px;">
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($product['ProductName']) ?></td>
            <td><?= htmlspecialchars($product['Description']) ?></td>
            <td><?= htmlspecialchars($product['Price']) ?></td>
            <td><?= htmlspecialchars($product['Discount']) ?></td>
            <td><?= htmlspecialchars($product['StockQuantity']) ?></td>
            <td>
                <a href="edit_product.php?product_id=<?= $product['ProductID'] ?>" class="btn btn-warning">Edit</a>
                <a href="delete_product.php?product_id=<?= $product['ProductID'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

        <h2>Credit Cards</h2>
        <div class="mb-4">
            <a href="add_card.php" class="btn btn-success">Add Credit Card</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Card Number</th>
                    <th>Expiry Date</th>
                    <th>CVC</th>
                    <th>Card Holder Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($credit_cards as $card): ?>
                <tr>
                    <td><?= htmlspecialchars($card['CardNumber']) ?></td>
                    <td><?= htmlspecialchars($card['ExpiryDate']) ?></td>
                    <td><?= htmlspecialchars($card['CVC']) ?></td>
                    <td><?= htmlspecialchars($card['CardHolderName']) ?></td>
                    <td>
                        <a href="edit_card.php?card_id=<?= $card['CardID'] ?>" class="btn btn-warning">Edit</a>
                        <a href="delete_card.php?card_id=<?= $card['CardID'] ?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
