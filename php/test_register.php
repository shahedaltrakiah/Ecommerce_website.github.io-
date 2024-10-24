<!-- <?php
session_start(); 
include("../includes/request.php");
include("../includes/validations.php");
include("../includes/sessions.php");
include('../includes/db.php'); 

$database = new Database();
$conn = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $image_url = ''; 
    $address = ''; 
    
    try {

        $check_email = "SELECT email FROM customers WHERE email = :email";
        $check_stmt = $conn->prepare($check_email);
        $check_stmt->bindParam(':email', $email);
        $check_stmt->execute();
        
        if ($check_stmt->rowCount() > 0) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'This email is already in use',
                    confirmButtonColor: '#3B5D50'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../pages/register.php';
                    }
                });
            </script>";
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
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Successful',
                    text: 'You will be redirected to the login page',
                    confirmButtonColor: '#3B5D50'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../pages/login.php';
                    }
                });
            </script>";
            exit();
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred during registration. Please try again.',
                    confirmButtonColor: '#3B5D50'
                });
            </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Database Error',
                text: 'An error occurred while connecting to the database: " . addslashes($e->getMessage()) . "',
                confirmButtonColor: '#3B5D50'
            });
        </script>";
    }
}
?> -->
