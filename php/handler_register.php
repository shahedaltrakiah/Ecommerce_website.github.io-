<?php

session_start(); 
include_once("../core/request.php");
include_once("../core/validations.php");
include_once("../core/sessions.php");
include_once('../data/config.php');


$errors = [];

if(postMethod()){
 
    foreach($_POST as $key => $value){
        $$key = receivedInput($value);
    }
    // var_dump($name, $email, $phone, $password, $confirm_password);

  
    if(requiredInput($username)){
        $errors[] = "username required";
    } elseif(minInput($username, 4)) {
        $errors[] = "username must be greater than 4 characters";
    } elseif(maxInput($username, 25)) {
        $errors[] = "username must be smaller than 25 characters";
    }
   


    if(requiredInput($first_name)){
        $errors[] = "Last name required";
    } elseif(minInput($first_name, 4)) {
        $errors[] = "Last name must be greater than 4 characters";
    } elseif(maxInput($first_name, 10)) {
        $errors[] = "Last name must be smaller than 10 characters";
    }
    if(requiredInput($last_name)){
        $errors[] = "Last name required";
    } elseif(minInput($last_name, 4)) {
        $errors[] = "Last name must be greater than 4 characters";
    } elseif(maxInput($last_name, 15)) {
        $errors[] = "Last name must be smaller than 15 characters";
    }
    if(requiredInput($email)){
        $errors[] = "Email required";
    } elseif(emailInput($email)) {
        $errors[] = "Please type a valid email";
    }

    if(requiredInput($phone_number)){
        $errors[] = "Phone number is required";
    } elseif (!isValidJordanianMobile($phone_number)) {
        $errors[] = "Please enter a valid Jordanian mobile number.";
    }
   

    if(requiredInput($address)){
        $errors[] = "address required";
    } elseif(minInput($address, 4)) {
        $errors[] = "address must be greater than 4 characters";
    } elseif(maxInput($address, 50)) {
        $errors[] = "address must be smaller than 50 characters";
    }




    if (requiredInput($password)) {
        $errors[] = "Password is required.";
    } elseif (minInput($password, 6)) {
        $errors[] = "Password must be at least 6 characters long.";
    } elseif (maxInput($password, 25)) {
        $errors[] = "Password must be smaller than 25 characters.";
    } elseif (!isPassword($password)) {
        $errors[] = "Password must contain at least one uppercase letter and one special character.";
    }
    

    if(requiredInput($confirm_password)){
        $errors[] = "Confirm password required";
    } elseif(sameInput($password, $confirm_password)) {
        $errors[] = "Confirm password must match the password";
    }

  
 
    if(empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
        try {
            $insertQuery = "INSERT INTO Customers(username, first_name, last_name, email, password, phone_number, image_url, address, created_at, updated_at)
                            VALUES (:username, :first_name, :last_name, :email, :password_hash, :phone_number, :image_url, :address, NOW(), NOW())";
            $stmt = $conn->prepare($insertQuery);
    

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':first_name', $first_name);
            $stmt->bindParam(':last_name', $last_name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password_hash', $hashed_password); 
            $stmt->bindParam(':phone_number', $phone_number);
            $stmt->bindParam(':image_url', $image_url); 
            $stmt->bindParam(':address', $address);
    
            
            $stmt->execute();
    
      
            $user = [
                'name' => $username,
                'email'=> $email,
                'phone'=> $phone_number
            ];
            sessionStore('user', $user);
            removeSession("signInErrors");
            removeSession("signUpErrors");
            header("location:../profile.php");
            exit();
    
        } catch(Exception $e) {
            $errors[] = $e->getMessage();
            $errors[] = 'This email is already registered, please use another email.';
            sessionStore("signUpErrors", $errors);
            header("location:../index.php");
            exit();
        }
    } else {
        sessionStore("signUpErrors", $errors);
        header("location:../index.php");
        exit();
    }
    
    

} else {
    echo "Method not allowed";
}
