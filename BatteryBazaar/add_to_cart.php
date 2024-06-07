<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
$quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;

if ($product_id > 0 && $quantity > 0) {
    // Ürünün veritabanında olup olmadığını kontrol et
    $product = berkhoca_query_parser("SELECT * FROM Products WHERE ProductID = $product_id");
    
    if (!empty($product)) {
        $product = $product[0];
        
        // Aynı üründen zaten sepette var mı kontrol et
        $cart_item = berkhoca_query_parser("SELECT * FROM Cart WHERE UserID = $user_id AND ProductID = $product_id");
        
        if (!empty($cart_item)) {
            // Sepette aynı üründen varsa miktarı güncelle
            $new_quantity = $cart_item[0]['Quantity'] + $quantity;
            $update_cart_query = "UPDATE Cart SET Quantity = $new_quantity WHERE UserID = $user_id AND ProductID = $product_id";
            berk_hoce_insert_or_delete($update_cart_query);
        } else {
            // Sepette aynı üründen yoksa yeni bir kayıt ekle
            $add_to_cart_query = "INSERT INTO Cart (UserID, ProductID, Quantity, AddedAt) VALUES ($user_id, $product_id, $quantity, NOW())";
            berk_hoce_insert_or_delete($add_to_cart_query);
        }
        
        // Sepet güncellendikten sonra kullanıcıyı sepet sayfasına yönlendir
        header('Location: cart.php');
        exit;
    } else {
        // Ürün bulunamadıysa hata mesajı göster
        echo "Ürün bulunamadı.";
    }
} else {
    // Geçersiz ürün veya miktar ise hata mesajı göster
    echo "Geçersiz ürün veya miktar.";
}
?>
