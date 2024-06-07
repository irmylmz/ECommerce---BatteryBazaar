<?php
require '../config.php';
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST['category_id'];
    $battery_id = $_POST['battery_id'];
    $product_name = $_POST['product_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $discount = $_POST['discount'];
    $discount_percentage = $_POST['discount_percentage'];
    $product_seller = $_SESSION['user_id']; // Assuming user ID is stored in the session
    $stock_quantity = $_POST['stock_quantity'];
    $created_at = date('Y-m-d H:i:s'); // Current timestamp

    // Image upload handling
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["picture"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            $picture = basename($_FILES["picture"]["name"]);

            $sql = "INSERT INTO Products (CategoryID, BatteryID, ProductName, Description, Price, Discount, DiscountPercentage, ProductSeller, Picture, StockQuantity, CreatedAt) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("iissdisssis", $category_id, $battery_id, $product_name, $description, $price, $discount, $discount_percentage, $product_seller, $picture, $stock_quantity, $created_at);
                $result = $stmt->execute();

                if ($result) {
                    echo "New product added successfully";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Statement preparation failed: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

$conn->close();
?>

<?php include 'partial/header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="author" content="Untree.co">
  <link rel="shortcut icon" href="favicon.png">
  <meta name="description" content="" />
  <meta name="keywords" content="bootstrap, bootstrap4" />
  <!-- Bootstrap CSS -->
  <link href="<?= ROOT_URL ?>css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="<?= ROOT_URL ?>css/tiny-slider.css" rel="stylesheet">
  <link href="<?= ROOT_URL ?>css/style.css" rel="stylesheet">
  <link href="<?= ROOT_URL ?>css/custom.css" rel="stylesheet">
  <title>Battery Bazaar</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Add Product</h1>
        <form method="post" action="add_product.php" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="category_id">Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['CategoryID'] ?>"><?= $category['CategoryName'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="battery_id">Battery</label>
                <select class="form-control" id="battery_id" name="battery_id" required>
                    <option value="">Select Battery</option>
                    <!-- Batteries will be populated based on the selected category -->
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="price">Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>
            <div class="form-group mb-3">
                <label for="discount">Discount</label>
                <input type="number" class="form-control" id="discount" name="discount" required>
            </div>
            <div class="form-group mb-3">
                <label for="discount_percentage">Discount Percentage</label>
                <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" required>
            </div>
            <div class="form-group mb-3">
                <label for="stock_quantity">Stock Quantity</label>
                <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
            </div>
            <div class="form-group mb-3">
                <label for="picture">Picture</label>
                <input type="file" class="form-control" name="picture" required>
            </div>
            <button type="submit" class="btn btn-success">Add Product</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#category_id').change(function() {
                var category_id = $(this).val();
                $.ajax({
                    url: 'fetch_batteries.php',
                    method: 'POST',
                    data: {category_id: category_id},
                    success: function(data) {
                        $('#battery_id').html(data);
                    }
                });
            });
        });
    </script>
</body>
</html>
