<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Kullanıcının sepetindeki ürünleri al
$cart_items = berkhoca_query_parser("SELECT * FROM Cart WHERE UserID = $user_id");

if (empty($cart_items)) {
    echo "Sepetiniz boş.";
    exit;
}

// Toplam tutarı hesapla
$total_amount = 0;
foreach ($cart_items as $item) {
    $product = berkhoca_query_parser("SELECT Price FROM Products WHERE ProductID = " . $item['ProductID']);
    $total_amount += $product[0]['Price'] * $item['Quantity'];
}

// Sipariş oluştur
$insert_order_query = "INSERT INTO Orders (UserID, TotalAmount, OrderStatus) VALUES ($user_id, $total_amount, 'Pending')";
berk_hoce_insert_or_delete($insert_order_query);

// Oluşturulan siparişin ID'sini al
$order_id = $conn->insert_id;

// Sipariş detaylarını ekle
foreach ($cart_items as $item) {
    $product = berkhoca_query_parser("SELECT Price FROM Products WHERE ProductID = " . $item['ProductID']);
    $price_at_purchase = $product[0]['Price'];
    $insert_order_details_query = "INSERT INTO OrderDetails (OrderID, ProductID, Quantity, PriceAtPurchase) VALUES ($order_id, " . $item['ProductID'] . ", " . $item['Quantity'] . ", $price_at_purchase)";
    berk_hoce_insert_or_delete($insert_order_details_query);
}

// Sepeti temizle
$delete_cart_query = "DELETE FROM Cart WHERE UserID = $user_id";
berk_hoce_insert_or_delete($delete_cart_query);

// Sipariş başarıyla oluşturulduktan sonra kullanıcıyı sipariş onay sayfasına yönlendir
header('Location: order_detail.php?order_id=' . $order_id);
exit;
?>
