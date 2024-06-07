<?php
require 'config.php'; // Admin klasöründeki config.php dosyasını dahil ediyoruz

// Check if user is logged in and is admin
if (!isset($_SESSION['user_logged_in']) || $_SESSION['is_admin'] != 1) {
    header('Location: ../login.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Parolayı hash'liyoruz
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    $insert_sql = "INSERT INTO Users (FirstName, LastName, Email, Password, Address, PhoneNumber, IsAdmin) 
                   VALUES ('$first_name', '$last_name', '$email', '$password', '$address', '$phone_number', '$is_admin')";
    
    berk_hoce_insert_or_delete($insert_sql);

    header('Location: dashboard.php');
    exit;
}
?>

<?php
include 'partial/header.php';
?>

<div class="container mt-5">
    <h1>Add User</h1>
    <form method="post" action="add_user.php">
        <div class="form-group mb-3">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="form-group mb-3">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-group mb-3">
            <label for="address">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="form-group mb-3">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" id="phone_number" name="phone_number" required>
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin">
            <label class="form-check-label" for="is_admin">Is Admin</label>
        </div>
        <button type="submit" class="btn btn-primary">Add User</button>
    </form>
</div>
</body>
</html>
