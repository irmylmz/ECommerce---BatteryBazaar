<?php
require '../config.php';

// Check if user is logged in
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $card_holder_name = $_POST['card_holder_name'];
    $cvc = $_POST['cvc'];
    $user_id = $_SESSION['user_id'];

    $insert_sql = "INSERT INTO CreditCards (CardNumber, ExpiryDate, CardHolderName, CVC, UserID) VALUES ('$card_number', '$expiry_date', '$card_holder_name', '$cvc', '$user_id')";
    
    berk_hoce_insert_or_delete($insert_sql);

    header('Location: dashboard.php');
    exit;
}
?>

<?php
include 'partial/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
    <div class="container mt-5">
        <h1>Add Credit Card</h1>
        <form method="post" action="add_card.php">
            <div class="form-group mb-3">
                <label for="card_holder_name">Card Holder Name</label>
                <input type="text" class="form-control" id="card_holder_name" name="card_holder_name" placeholder="Ali Cabbar" required>
            </div>
            <div class="form-group mb-3">
                <label for="card_number">Card Number</label>
                <input type="text" class="form-control" id="card_number" name="card_number" maxlength="16" placeholder="1111-2222-3333-4444" required>
            </div>
            <div class="form-group mb-3">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
            </div>
            <div class="form-group mb-3">
                <label for="cvc">CVC</label>
                <input type="text" class="form-control" id="cvc" name="cvc" maxlength="3" placeholder="123" required>
            </div>
            <button type="submit" class="btn btn-success">Add Credit Card</button>
        </form>
    </div>
</body>
</html>
