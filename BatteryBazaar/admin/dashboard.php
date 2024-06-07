<?php
require 'config.php'; // Admin klasöründeki config.php dosyasını dahil ediyoruz

// Check if user is logged in and is admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../login.php');
    exit;
}

// Tüm siparişleri al
$orders = berkhoca_query_parser("SELECT o.*, u.FirstName, u.LastName FROM Orders o JOIN Users u ON o.UserID = u.UserID");

// Fetch admin information
$user_id = $_SESSION['user_id'];
$user_info = berkhoca_query_parser("SELECT * FROM Users WHERE UserID = $user_id");

// Fetch all users
$users = berkhoca_query_parser("SELECT * FROM Users");

// Fetch all products
$products = berkhoca_query_parser("SELECT * FROM Products");

// Fetch all credit cards
$credit_cards = berkhoca_query_parser("SELECT * FROM CreditCards");

// Fetch all batteries
$batteries = berkhoca_query_parser("SELECT * FROM Batteries");
?>

<?php
include 'partial/header.php';
?>

<div class="container mt-5">
    <h1>Welcome to Admin Dashboard, <?= htmlspecialchars($user_info[0]['FirstName'] ?? 'Admin') ?></h1>
    <div class="mb-4">
        <a href="add_product.php" class="btn btn-success">Add Product</a>
        <a href="add_battery.php" class="btn btn-success">Add Battery</a>
        <a href="add_user.php" class="btn btn-primary">Add User</a>
        <a href="add_card.php" class="btn btn-primary">Add Credit Card</a>
        <a href="add_category.php" class="btn btn-primary">Add Category</a>
    </div>

    <h2>Users List</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['FirstName']) ?></td>
            <td><?= htmlspecialchars($user['LastName']) ?></td>
            <td><?= htmlspecialchars($user['Email']) ?></td>
            <td>
                <a href="edit_user.php?user_id=<?= htmlspecialchars($user['UserID']) ?>" class="btn btn-warning">Edit</a>
                <a href="delete_user.php?user_id=<?= htmlspecialchars($user['UserID']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>All Orders</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Total Amount</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['OrderID']) ?></td>
                    <td><?= htmlspecialchars($order['FirstName'] . ' ' . $order['LastName']) ?></td>
                    <td>$<?= number_format($order['TotalAmount'], 2) ?></td>
                    <td><?= htmlspecialchars($order['OrderDate']) ?></td>
                    <td><?= htmlspecialchars($order['OrderStatus']) ?></td>
                    <td>
                        <a href="order_detail.php?order_id=<?= $order['OrderID'] ?>" class="btn btn-primary btn-sm">View Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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
                    <?php if (!empty($product['Picture'])): ?>
                        <img src="img/<?= htmlspecialchars($product['Picture']) ?>" alt="Product Image" style="max-width: 100px; max-height: 100px;">
                    <?php else: ?>
                        <img src="img/no_image_available.png" alt="No Image Available" style="max-width: 100px; max-height: 100px;">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($product['ProductName']) ?></td>
                <td><?= htmlspecialchars($product['Description']) ?></td>
                <td><?= htmlspecialchars($product['Price']) ?></td>
                <td><?= htmlspecialchars($product['Discount']) ?></td>
                <td><?= htmlspecialchars($product['StockQuantity']) ?></td>
                <td>
                    <a href="edit_product.php?product_id=<?= htmlspecialchars($product['ProductID']) ?>" class="btn btn-warning">Edit</a>
                    <a href="delete_product.php?product_id=<?= htmlspecialchars($product['ProductID']) ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <h2>Battery List</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Battery Name</th>
                <th>Capacity (mAh)</th>
                <th>Voltage (V)</th>
                <th>Width (mm)</th>
                <th>Depth (mm)</th>
                <th>Height (mm)</th>
                <th>Number of Terminals</th>
                <th>Weight (kg)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($batteries as $battery): ?>
            <tr>
                <td><?= htmlspecialchars($battery['Name']) ?></td>
                <td><?= htmlspecialchars($battery['Capacity']) ?></td>
                <td><?= htmlspecialchars($battery['Voltage']) ?></td>
                <td><?= htmlspecialchars($battery['Width']) ?></td>
                <td><?= htmlspecialchars($battery['Depth']) ?></td>
                <td><?= htmlspecialchars($battery['Height']) ?></td>
                <td><?= htmlspecialchars($battery['NumberOfTerminals']) ?></td>
                <td><?= htmlspecialchars($battery['Weight']) ?></td>
                <td>
                    <a href="edit_battery.php?battery_id=<?= $battery['BatteryID'] ?>" class="btn btn-warning">Edit</a>
                    <a href="delete_battery.php?battery_id=<?= $battery['BatteryID'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this battery?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Credit Cards</h2>
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
                    <a href="delete_card.php?card_id=<?= $card['CardID'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this card?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
