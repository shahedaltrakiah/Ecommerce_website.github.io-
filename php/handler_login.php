<?php
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
        echo '************************************<br>';

        // Debug: Check if user was fetched
        if ($user) {
            echo '********************2****************<br>';
            echo 'Fetched user data:<br>';
            echo 'Username: ' . htmlspecialchars($user['username']) . '<br>';
            echo 'Password Hash: ' . htmlspecialchars($user['password']) . '<br>'; // Debugging the stored password hash
            
            // Verify the password
            if ($user && password_verify($password, $user['password'])){
                echo '********************3****************<br>';
                echo 'Password verified successfully.<br>';

                // Set session variables on successful login
                $_SESSION['user'] = [
                    'name' => $user['username'],
                    'email' => $email,
                    'image_url' => $user['image_url'],
                    'customer_id' => $user['customer_ID'],
                ];
                 echo $user['username'] .'<br>';
                 echo ''. htmlspecialchars($user['customer_ID']) .'<br>';
                 header('Location:../index.php' );
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
                echo 'Password verification failed.<br>';
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
                header('Location:../pages/login.php' );
                exit();

            }
        } else {
    
            echo 'No user found with that email.<br>';
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
        // Redirect to login page on error
        echo 'Error occurred: ' . htmlspecialchars($e->getMessage()) . '<br>'; // Debugging the error message
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Something went wrong, please try again.",
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
?>
