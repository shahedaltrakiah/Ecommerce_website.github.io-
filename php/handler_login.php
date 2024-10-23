<?php


session_start();
$_SESSION['errorMassing'] = '';

include('../includes/db.php');


$db = new Database();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
    
        $query = "SELECT username, password, image_url, customer_ID FROM customers WHERE email = :email"; 
        
        $stmt = $conn->prepare($query);
        $stmt->execute([':email' => $email]); 
      
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '************************************<br>';

      
        if ($user) {
            echo '********************2****************<br>';
            echo 'Fetched user data:<br>';
            echo 'Username: ' . htmlspecialchars($user['username']) . '<br>';
            echo 'Password Hash: ' . htmlspecialchars($user['password']) . '<br>'; 
            
          
            if ($user && password_verify($password, $user['password'])){
                echo '********************3****************<br>';
                echo 'Password verified successfully.<br>';

        
                $_SESSION['user'] = [
                    'name' => $user['username'],
                    'email' => $email,
                    'image_url' => $user['image_url'],
                    'customer_id' => $user['customer_ID'],
                ];
                 echo $user['username'] .'<br>';
                 echo ''. htmlspecialchars($user['customer_ID']) .'<br>';
                 header('Location:../index.php' );
               
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
            header('Location:../pages/login.php' );
    
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
     
        echo 'Error occurred: ' . htmlspecialchars($e->getMessage()) . '<br>';
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
