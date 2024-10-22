<?php
session_start();
include_once("../includes/request.php");
include_once("../includes/validations.php");
include_once("../includes/sessions.php");
include_once('../includes/db.php');
$errors = [];
if (postMethod()) {  
    foreach ($_POST as $key => $value) {
        $$key = receivedInput($value);
    }
    try {
        $query = "SELECT password, username FROM Customers WHERE email = :email";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
      
        if ($user && password_verify($password, $user['password'])) {
          

            $_SESSION['user'] = [
                'name' =>  $user['username'],
                'email' => $email,
                'image_url' => $user['image_url'],
                'customer_ID'=> $user['customer_ID'],
            ];
            exit();
        } 
    } catch (Exception $e) {
        $errors[] = $e->getMessage();
    }

    if (!empty($errors)) {
        sessionStore("signInErrors", $errors);
        echo '<script>
                window.location.href = "../pages/login.php";
              </script>';
        exit();
    }
} else {
    echo "Method not allowed";
}
?>
