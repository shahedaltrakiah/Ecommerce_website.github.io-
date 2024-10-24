<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
include '../includes/db.php';
    try {
$database = new Database();
$conn = $database->getConnection();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$productId = $_POST['product_id'];
$stmt = $conn->prepare("
SELECT p.*, 
(SELECT pi.image_url 
FROM productimages pi 
WHERE pi.product_id = p.product_id 
ORDER BY pi.image_url ASC 
LIMIT 1) as image_url
FROM Products p
WHERE p.product_id = :product_id
");
$stmt->execute(['product_id' => $productId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if ($product) {
    $imagePath = $product['image_url']
        ? '../images/' . basename($product['image_url'])
        : '../images/default.jpg';
    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$productId] = [
            'name' => $product['product_name'],
            'price' => $product['price'],
            'quantity' => 1,
            'image' => $imagePath
        ];
    }
}
header("Location: cart.php");
exit();
} catch (PDOException $e) {
echo "Error: " . $e->getMessage();
}
} else {
header("Location: productdetails.php");
exit();
}
?>
