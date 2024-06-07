<?php
require '../config.php';

// Check if user is logged in
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: ../login.php');
    exit;
}

// Fetch user information
$user_id = $_SESSION['user_id'];
$user_info = berkhoca_query_parser("SELECT * FROM Users WHERE UserID = $user_id")[0];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];

    $update_sql = "UPDATE Users SET 
                    FirstName='$first_name', 
                    LastName='$last_name', 
                    Email='$email', 
                    Address='$address', 
                    PhoneNumber='$phone_number' 
                   WHERE UserID = $user_id";
    
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
        <h1>Edit User Information</h1>
        <form method="post" action="edit_user.php">
            <div class="form-group mb-3">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($user_info['FirstName']) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($user_info['LastName']) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user_info['Email']) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user_info['Address']) ?>" required>
            </div>
            <div class="form-group mb-3">
                <label for="phone_number">Phone Number</label>
                <input type="tel" class="form-control" id="phone_number" name="phone_number" value="<?= htmlspecialchars($user_info['PhoneNumber']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</body>
</html>
