<?php
session_start(); //--we started session--

//--to display PHP errors--
ini_set('display_errors', '1'); // 1 is on, 0 is off
ini_set('display_startup_errors', '1'); // 1 is on, 0 is off
error_reporting(E_ALL);

// config.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BatteryBazaar";

// Veritabanı bağlantısını oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//--query function--
function berkhoca_query_parser($sql='') {
    //--to connect database--
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "BatteryBazaar";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($sql)) {
        return 'sql statement is empty';
    }
    $query_result = $conn->query($sql);

    $array_result = [];
    while ($row = $query_result->fetch_assoc()) {
        $array_result[] = $row;
    }
    return $array_result;
}

function berk_hoce_insert_or_delete($sql='') {
    //--to connect database--
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "BatteryBazaar";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (empty($sql)) {
        return 'sql statement is empty';
    }
    $query_result = $conn->query($sql);
    return $query_result;
}
?>
