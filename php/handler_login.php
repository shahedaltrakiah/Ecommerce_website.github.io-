<?php
session_start();
include_once("../includes/request.php");
include_once("../includes/validations.php");
include_once("../includes/sessions.php");
include_once('../includes/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {  
  
    $email = $_POST['email'];
    $password = $_POST['password'];


    try {
        $query ="SELECT password, username, image_url, customer_ID FROM Customers WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':image_url', $image_url); 
        $stmt->execute();

     
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if ($user && password_verify($password, $user['password'])) {
           
            $_SESSION['user'] = [
                'name' => $user['username'],
                'email' => $email,
                'image_url' => $user['image_url'],
                'customer_ID' => $user['customer_ID'],
            ];
           
            header("Location: ../index.php");
            exit();
        } else {
        
            
            echo '<script>window.location.href = "../pages/login.php";</script>';
            exit();
        }
    } catch (Exception $e) {
     
     
        echo '<script>window.location.href = "../pages/login.php";</script>';
        exit();
    }
} else {
    echo "Method not allowed";
}
?>
