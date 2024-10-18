<?php 
session_start(); 
include 'core/sessions.php';

if (!isset($_SESSION['user'])) {
    header('location:index.php');
    exit;
}

if (isset($_POST['logout'])) {
    unset($_SESSION["user"]); 
    header('location:index.php'); 
    exit; 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<div class="container profile-container mt-5">
    <h1>Profile</h1>
    <h2>Name: <?php echo sessionGet('user')['name'] ?? ''; ?></h2>
    <h2>Email: <?php echo sessionGet('user')['email'] ?? ''; ?></h2>
    
    <form action="" method="POST"> 
        <button type="submit" name="logout" class="btn btn-danger">Logout</button>
    </form>
</div>
</body>
</html>
