<?php
session_start();
include "../includes/db.php";
$database = new Database();
$conn = $database->getConnection();
$customerId = 1; // Hardcoded customer ID for now

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    try {
        $stmt = $conn->prepare("DELETE FROM wishlists WHERE customer_id = :customer_id AND product_id = :product_id");
        $stmt->execute([
            'customer_id' => $customerId,
            'product_id' => $productId
        ]);

        $_SESSION['message'] = "Item removed from wishlists successfully.";
        header("Location: wishlist.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error removing item from wishlists: " . $e->getMessage();
        header("Location: wishlist.php");
        exit();
    }
} else {
    header("Location: wishlist.php");
    exit();
}
?>
