<?php
require 'config.php'; // Admin klasöründeki config.php dosyasını dahil ediyoruz

// Check if user is logged in and is admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../login.php');
    exit;
}

// Check if user_id is provided
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    header('Location: dashboard.php');
    exit;
}

$user_id = intval($_GET['user_id']); // Güvenlik için tam sayıya çeviriyoruz

// Fetch user information
$user_info = berkhoca_query_parser("SELECT * FROM Users WHERE UserID = $user_id");

if (empty($user_info)) {
    header('Location: dashboard.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $update_sql = "UPDATE Users SET 
                   FirstName = '$first_name', 
                   LastName = '$last_name', 
                   Email = '$email', 
                   Address = '$address', 
                   PhoneNumber = '$phone_number', 
                   IsAdmin = '$is_admin'
                   WHERE UserID = $user_id";
    
    berk_hoce_insert_or_delete($update_sql);

    header('Location: dashboard.php');
    exit;
}
?>

<?php
include 'partial/header.php';
?>

<div class="container mt-5">
    <h1>Edit User Information</h1>
    <form method="post" action="edit_user.php?user_id=<?= htmlspecialchars($user_id) ?>">
        <div class="form-group mb-3">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($user_info[0]['FirstName']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($user_info[0]['LastName']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user_info[0]['Email']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user_info[0]['Address']) ?>" required>
        </div>
        <div class="form-group mb-3">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?= htmlspecialchars($user_info[0]['PhoneNumber']) ?>" required>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" <?= ($user_info[0]['IsAdmin'] == 1) ? 'checked' : '' ?>>
            <label class="form-check-label" for="is_admin">Is Admin</label>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
</body>
</html>
