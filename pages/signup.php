<?php
session_start(); 
if (isset($_POST['logout'])) {
    unset($_SESSION['user']); 
    header('Location: ../index.php'); 
    exit();
}
?>
