<?php
// Ana dizindeki config.php dosyasını dahil ediyoruz
require_once '../config.php';

// Admin klasörü için ek yapılandırmalar veya fonksiyonlar buraya eklenebilir
if (!function_exists('admin_specific_function')) {
    function admin_specific_function() {
        // Admin'e özel işlevler burada tanımlanabilir
    }
}
?>
