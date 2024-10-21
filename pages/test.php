<?php
session_start();
include "../includes/db.php";

$query = "SELECT * FROM Products";
$stmt = $conn->query($query);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];

    // Fetch product details from the database
    $stmt = $conn->prepare("SELECT * FROM Products WHERE product_id = :product_id");
    $stmt->execute(['product_id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $_SESSION['cart'][$productId] = [
            'name' => $product['product_name'],
            'price' => $product['price'],
            'quantity' => ($_SESSION['cart'][$productId]['quantity'] ?? 0) + 1,
            'image' => 'path/to/image/' . $product['product_id'] . '.jpg' // Adjust this path accordingly
        ];
    }
    header("Location: cart.php");
    exit();
}

try {
    // Enable error reporting for PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Default customer ID (for testing)
    $customerId = 1; // This should eventually come from the logged-in user's session

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
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
} catch (PDOException $e) {
    // Output the error message
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
                        <img src="path/to/image/<?php echo $product['product_id']; ?>.jpg" alt="Image" class="card-img-top"> <!-- Adjust this path -->
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['product_name']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                            <p class="card-text"><strong>Price: $<?php echo number_format($product['price'], 2); ?></strong></p>
                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                                  <!-- Add to Wishlist Button -->
                                  <input type="hidden" name="product_id" value="1">
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
