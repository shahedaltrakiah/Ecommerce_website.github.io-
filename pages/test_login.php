<!-- <?php
session_start();
include("../includes/request.php");
include("../includes/validations.php");
include("../includes/sessions.php");
include('../includes/db.php'); 

$database = new Database();
$conn = $database->getConnection();

// Handle form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['register'])) {
        // Registration logic
        $username = $_POST['username'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phone_number = $_POST['phone_number'];
        $image_url = ''; 
        $address = ''; 

        try {
            // Check if the email is already in use
            $check_email = "SELECT email FROM customers WHERE email = :email";
            $check_stmt = $conn->prepare($check_email);
            $check_stmt->bindParam(':email', $email);
            $check_stmt->execute();
            
            if ($check_stmt->rowCount() > 0) {
                echo "<script> Swal.fire({icon: 'error', title: 'Error', text: 'This email is already in use', confirmButtonColor: '#3B5D50'}); </script>";
                exit();
            }

            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO customers(username, first_name, last_name, email, password, phone_number, image_url, address, created_at, updated_at)
                      VALUES (:username, :first_name, :last_name, :email, :password_hash, :phone_number, :image_url, :address, NOW(), NOW())";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $hashed_password); 
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->bindParam(':image_url', $image_url); 
            $stmt->bindParam(':address', $address);

            if ($stmt->execute()) {
                echo "<script> Swal.fire({icon: 'success', title: 'Registration Successful', text: 'You will be redirected to the login page', confirmButtonColor: '#3B5D50'}).then(() => { window.location.href = '../pages/login.php'; }); </script>";
                exit();
            } else {
                echo "<script> Swal.fire({icon: 'error', title: 'Error', text: 'An error occurred during registration. Please try again.', confirmButtonColor: '#3B5D50'}); </script>";
            }
        } catch (PDOException $e) {
            echo "<script> Swal.fire({icon: 'error', title: 'Database Error', text: 'An error occurred: " . addslashes($e->getMessage()) . "', confirmButtonColor: '#3B5D50'}); </script>";
        }
    } elseif (isset($_POST['login'])) {
        // Login logic
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            // Prepare SQL query to fetch user data by email
            $query = "SELECT username, password, image_url, customer_ID FROM customers WHERE email = :email"; 
            $stmt = $conn->prepare($query);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'name' => $user['username'],
                        'email' => $email,
                        'image_url' => $user['image_url'],
                        'customer_id' => $user['customer_ID'],
                    ];
                    echo '<script> Swal.fire({icon: "success", title: "Login Successful!", text: "Welcome back, ' . htmlspecialchars($user['username']) . '!", confirmButtonColor: "#3B5D50"}).then(() => { window.location.href = "../index.php"; }); </script>';
                    exit();
                } else {
                    echo '<script> Swal.fire({icon: "error", title: "Login Failed!", text: "Invalid email or password.", confirmButtonColor: "#FF4B2B"}); </script>';
                }
            } else {
                echo '<script> Swal.fire({icon: "error", title: "Login Failed!", text: "No user found with that email.", confirmButtonColor: "#FF4B2B"}); </script>';
            }
        } catch (Exception $e) {
            echo '<script> Swal.fire({icon: "error", title: "Error!", text: "An unexpected error occurred. Please try again later.", confirmButtonColor: "#FF4B2B"}); </script>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/loginstyle.css" />
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/font-awesome.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form method="POST">
                <h1>Create Account</h1>
                <input type="text" id="userName" name="username" placeholder="Name" required />
                <input type="text" id="firstName" name="first_name" placeholder="First Name" required />
                <input class='m-3' type="text" id="lastName" name="last_name" placeholder="Last Name" required />
                <input type="text" id="floatingEmail" name="email" placeholder="Email" required />
                <input type="tel" id="phoneNumber" name="phone_number" placeholder="Enter your mobile number" required />
                <input type="password" placeholder="Password" id="floatingPassword" name="password" required />
                <input type="password" id="floatingConfirmPassword" placeholder="Confirm Password" required />
                <button type="submit" name="register">Sign Up</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form method="POST">
                <h1>Sign in</h1>
                <input type="text" placeholder="Email" name="email" id="loginEmail" required />
                <input type="password" placeholder="Password" name="password" id="loginPassword" required />
                <button type="submit" name="login">Sign In</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>Welcome Back!</h1>
                    <p>To keep connected with us please login with your personal info</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Hello, Friend!</h1>
                    <p>Enter your personal details and start with us</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="../js/auth.js"></script>
    <script src="../js/custom.js"></script>
</body>
</html> -->
