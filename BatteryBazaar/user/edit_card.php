<?php
require '../config.php';

// Check if user is logged in
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

// Fetch the card details
if (isset($_GET['card_id'])) {
    $card_id = $_GET['card_id'];
    $user_id = $_SESSION['user_id'];

    $select_sql = "SELECT * FROM CreditCards WHERE CardID = '$card_id' AND UserID = '$user_id'";
    $card_info = berkhoca_query_parser($select_sql);

    if (count($card_info) == 0) {
        header('Location: user_page.php');
        exit;
    }
} else {
    header('Location: user_page.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $card_holder_name = $_POST['card_holder_name'];
    $cvc = $_POST['cvc'];
    $user_id = $_SESSION['user_id'];

    $update_sql = "UPDATE CreditCards SET CardNumber = '$card_number', ExpiryDate = '$expiry_date', CardHolderName = '$card_holder_name', CVC = '$cvc' WHERE CardID = '$card_id' AND UserID = '$user_id'";
    
    berk_hoce_insert_or_delete($update_sql);

    header('Location: user_page.php');
    exit;
}
?>

<?php
include 'partial/header.php';
?>

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
  <link href="<?= ROOT_URL?>css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="<?= ROOT_URL?>css/tiny-slider.css" rel="stylesheet">
  <link href="<?= ROOT_URL?>css/style.css" rel="stylesheet">
  <link href="<?= ROOT_URL?>css/custom.css" rel="stylesheet">
  <title>Battery Bazaar</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Credit Card</h1>
        <form method="post" action="edit_card.php?card_id=<?= $card_id ?>">
            <div class="form-group mb-3">
                <label for="card_holder_name">Card Holder Name</label>
                <input type="text" class="form-control" id="card_holder_name" name="card_holder_name" value="<?= htmlspecialchars($card_info[0]['CardHolderName']) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="card_number">Card Number</label>
                <input type="text" class="form-control" id="card_number" name="card_number" maxlength="16" value="<?= htmlspecialchars($card_info[0]['CardNumber']) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="<?= htmlspecialchars($card_info[0]['ExpiryDate']) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="cvc">CVC</label>
                <input type="text" class="form-control" id="cvc" name="cvc" maxlength="3" value="<?= htmlspecialchars($card_info[0]['CVC']) ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update Credit Card</button>
        </form>
    </div>
</body>
</html>
