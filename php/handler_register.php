<?php
session_start(); 
include("../includes/request.php");
include("../includes/validations.php");
include("../includes/sessions.php");
include('../includes/db.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $username = $_POST['username'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone_number = $_POST['phone_number'];
    $image_url = ''; 
    $address = ''; 
    
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
       
        $query ="INSERT INTO customers(username, first_name, last_name, email, password, phone_number, image_url, address, created_at, updated_at)
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
           header('Location:../pages/login.php' );
            
        exit();
        }
         else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong. Please try again later.',
                    confirmButtonColor: '#3B5D50' 
                });
            </script>";

        }

    } catch (PDOException $e) {
       
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Database Error',
                text: 'There was an issue connecting to the database: " . $e->getMessage() . "',
                confirmButtonColor: '#3B5D50' 
            });
        </script>";
    }
}
?>  
