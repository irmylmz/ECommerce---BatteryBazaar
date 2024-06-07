<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query to check user credentials
    $sql = "SELECT * FROM Users WHERE Email='$email' AND Password='$password'";
    $result = berkhoca_query_parser($sql);

    if (count($result) > 0) {
        $_SESSION['user_logged_in'] = true;
        $_SESSION['user_id'] = $result[0]['UserID'];
        $_SESSION['is_admin'] = $result[0]['IsAdmin'];

        // If the user is an admin, check if they are in the AdminUsers table
        if ($result[0]['IsAdmin']) {
            $admin_check_sql = "SELECT * FROM AdminUsers WHERE UserID = " . $result[0]['UserID'];
            $admin_check_result = berkhoca_query_parser($admin_check_sql);

            // If the user is not already an admin, insert them into the AdminUsers table
            if (count($admin_check_result) == 0) {
                $insert_admin_sql = "INSERT INTO AdminUsers (UserID) VALUES (" . $result[0]['UserID'] . ")";
                berk_hoce_insert_or_delete($insert_admin_sql);
            }

            header('Location: admin/dashboard.php');
            exit;
        } else {
            header('Location: user/user_page.php');
            exit;
        }
    } else {
        $error = "Invalid email or password";
    }
}
?>


<?php
include 'partials/header.php';
?>

<!-- Login Form -->
<div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Login</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="login.php">
                                <div class="form-group mb-3">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                            </form>
                            <a href="<?= ROOT_URL?>signup.php" class="btn btn-secondary w-100 mt-3">Sign Up</a>
                            <?php if (isset($error)) echo "<p>$error</p>"; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <br>

        <?php
include 'partials/footer.php';
?>