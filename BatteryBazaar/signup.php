
<?php
require 'config.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Form verilerini al
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $address = $_POST['address'];
    $phoneNumber = $_POST['phoneNumber'];

    // Şifrelerin eşleştiğini kontrol et
    if ($password !== $confirmPassword) {
        $error = 'Passwords do not match!';
    } else {
        // Veritabanına bağlan
        $servername = "localhost";
        $username = "root";
        $password_db = "";
        $dbname = "BatteryBazaar";

        $conn = new mysqli($servername, $username, $password_db, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Kullanıcıyı ekle
        $sql = "INSERT INTO Users (FirstName, LastName, Email, Password, Address, PhoneNumber, IsAdmin) VALUES (?, ?, ?, ?, ?, ?, FALSE)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssss", $firstName, $lastName, $email, $password, $address, $phoneNumber);

        if ($stmt->execute()) {
            echo "User registered successfully!";
        } else {
            $error = "Error: " . $sql . "<br>" . $conn->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>
 
 <?php
include 'partials/header.php';
?>

<div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-center">Sign Up</h3>
                        </div>
                        <div class="card-body">
                            <form method="post" action="signup.php">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="firstName">First Name</label>
                                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="lastName">Last Name</label>
                                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="email">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm password" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Address" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="phoneNumber">Phone Number</label>
                                    <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Phone number" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Sign Up</button>
                                <?php if (isset($error)) echo "<p>$error</p>"; ?>
                            </form>
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