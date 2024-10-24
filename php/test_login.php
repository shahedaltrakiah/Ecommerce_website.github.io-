<!-- <!-- <?php
session_start();

include('../includes/db.php');

// Create a new instance of the Database class and get the connection
$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prepare SQL query to fetch user data by email
        $query = "SELECT username, password, image_url, customer_ID FROM customers WHERE email = :email"; 
        $stmt = $conn->prepare($query); // Prepare the statement
        $stmt->execute([':email' => $email]); // Execute with the email parameter
        
        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user was fetched
        if ($user) {
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Password verified successfully
                // Set session variables on successful login
                $_SESSION['user'] = [
                    'name' => $user['username'],
                    'email' => $email,
                    'image_url' => $user['image_url'],
                    'customer_id' => $user['customer_ID'],
                ];
                // Show success message using SweetAlert
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Login Successful!",
                        text: "Welcome back, ' . htmlspecialchars($user['username']) . '!",
                        confirmButtonColor: "#3B5D50"
                    }).then(function() {
                        window.location.href = "../index.php";  
                    });
                </script>';
                exit();
            } else {
                // Password mismatch
                echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Login Failed!",
                        text: "Invalid email or password.",
                        confirmButtonColor: "#FF4B2B"
                    }).then(function() {
                        window.location.href = "../pages/login.php";  
                    });
                </script>';
                exit();
            }
        } else {
            // User not found
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Login Failed!",
                    text: "No user found with that email.",
                    confirmButtonColor: "#FF4B2B"
                }).then(function() {
                    window.location.href = "../pages/login.php";  
                });
            </script>';
            exit();
        }
    } catch (Exception $e) {
        // Handle any exceptions that occur
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "An unexpected error occurred. Please try again later.",
                confirmButtonColor: "#FF4B2B"
            }).then(function() {
                window.location.href = "../pages/login.php";  
            });
        </script>';
        exit();
    }
} else {
    echo "Method not allowed";
}
?> -->


<?php
// test_login.php
session_start();

include('../includes/db.php');

// Create a new instance of the Database class and get the connection
$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get email and password from POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Prepare SQL query to fetch user data by email
        $query = "SELECT username, password, image_url, customer_ID FROM customers WHERE email = :email"; 
        $stmt = $conn->prepare($query);
        $stmt->execute([':email' => $email]);
        
        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $response = array();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'name' => $user['username'],
                    'email' => $email,
                    'image_url' => $user['image_url'],
                    'customer_id' => $user['customer_ID'],
                ];
                $response = [
                    'status' => 'success',
                    'message' => 'Login successful!',
                    'username' => $user['username'],
                    'redirect' => '../index.php'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Invalid email or password.',
                    'redirect' => '../pages/login.php'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No user found with that email.',
                'redirect' => '../pages/login.php'
            ];
        }
    } catch (Exception $e) {
        $response = [
            'status' => 'error',
            'message' => 'An unexpected error occurred. Please try again later.',
            'redirect' => '../pages/login.php'
        ];
    }
    
    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>

 -->
