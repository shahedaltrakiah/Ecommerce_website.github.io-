<?php
session_start();
include_once("../core/request.php");
include_once("../core/validations.php");
include_once("../core/sessions.php");
include_once('../data/config.php');

$errors = [];

if (postMethod()) {

    foreach ($_POST as $key => $value) {
        $$key = receivedInput($value);
    }


    if (requiredInput($email)) {
        $errors[] = "Email is required";
    } elseif (emailInput($email)) {
        $errors[] = "Please enter a valid email";
    }

    if (requiredInput($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        try {
            $query = "SELECT password, username FROM Customers WHERE email = :email";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

        
            if ($user && password_verify($password, $user['password'])) {
                $userData = [
                    'name' => $user['username'],
                    'email' => $email,
                ];
                sessionStore('user', $userData);
                removeSession("signInErrors");
                removeSession("signUpErrors");
                header("Location: ../profile.php");
                
                exit();
            } else {
                $errors[] = "Invalid email or password";
            }
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
        }
    }

    if (!empty($errors)) {
        sessionStore("signInErrors", $errors);
        header("Location: ../index.php");
        exit();
    }
} else {
    echo "Method not allowed";
}
?>
