<?php
session_start();
include "../includes/db.php";

$database = new Database();
$conn = $database->getConnection();

try {
    // Enable error reporting for PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all products with their images
    $query = "
        SELECT p.*, MIN(pi.image_url) AS image_url
        FROM Products p
        LEFT JOIN ProductImages pi ON p.product_id = pi.product_id
        GROUP BY p.product_id
    ";
    $stmt = $conn->query($query);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Default customer ID (for testing)
    $customerId = 1; // This should eventually come from the logged-in user's session

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Handle adding to the cart
        if (isset($_POST['add_to_cart'])) {
            $productId = $_POST['product_id'];

            // Fetch product details from the database using the product_id
            $stmt = $conn->prepare("SELECT * FROM Products WHERE product_id = :product_id");
            $stmt->execute(['product_id' => $productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                // Add the product to the cart
                $_SESSION['cart'][$productId] = [
                    'name' => htmlspecialchars($product['product_name']),
                    'price' => $product['price'],
                    'quantity' => ($_SESSION['cart'][$productId]['quantity'] ?? 0) + 1,
                    'image' => $product['image_url'] ?? 'default_image.jpg' // Use the image from the database or a default image
                ];
            }
            header("Location: cart.php");
            exit();
        }

        // Handle adding to the wishlist
        if (isset($_POST['add_to_wishlist'])) {
            $productId = $_POST['product_id'];

            // Check if the product is already in the wishlist
            $stmt = $conn->prepare("SELECT * FROM wishlists WHERE customer_id = :customer_id AND product_id = :product_id");
            $stmt->execute(['customer_id' => $customerId, 'product_id' => $productId]);
            $wishlistItem = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$wishlistItem) {
                // Insert into wishlist
                $stmt = $conn->prepare("INSERT INTO wishlists (customer_id, product_id, created_at, updated_at) VALUES (:customer_id, :product_id, NOW(), NOW())");
                $stmt->execute([
                    'customer_id' => $customerId,
                    'product_id' => $productId
                ]);
            }

            // Redirect back to the wishlist page
            header("Location: wishlist.php");
            exit();
        }
    }

} catch (PDOException $e) {
    // Output the error message (consider logging this instead)
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Test Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Products</h1>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                        <img width="261px" height="261px" src="http://localhost/php-project/Ecommerce_website.github.io-/<?= htmlspecialchars($product['image_url']); ?>" class="img-fluid product-thumbnail" alt="<?= htmlspecialchars($product['product_name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="card-text"><strong>Price: $<?php echo number_format($product['price'], 2); ?></strong></p>
                        
                        <!-- Add to Cart Form -->
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                        </form>

                        <!-- Add to Wishlist Form -->
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <button type="submit" name="add_to_wishlist" class="btn btn-secondary">Add to Wishlist</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
