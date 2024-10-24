<?php
session_start();
include "../includes/db.php";

try {
    // Create a new database connection
    $database = new Database();
    $conn = $database->getConnection();

    // Enable error reporting for PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all products with their first image
    $query = "
        SELECT p.*, 
               (SELECT pi.image_url 
                FROM productimages pi 
                WHERE pi.product_id = p.product_id 
                ORDER BY pi.image_url ASC 
                LIMIT 1) as image_url
        FROM Products p";
    $stmt = $conn->query($query);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Handle adding to cart
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
        $productId = $_POST['product_id'];

        // Fetch product details with its first image
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
            // Format the image path correctly
            $imagePath = $product['image_url']
                ? '../images/' . basename($product['image_url'])
                : '../images/default.jpg';

            // Check if the product is already in the cart
            if (isset($_SESSION['cart'][$productId])) {
                // Increment the quantity if it already exists
                $_SESSION['cart'][$productId]['quantity'] += 1;
            } else {
                // Add the product to the cart
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
    }

    // Handle removing from cart
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_from_cart'])) {
        $productId = $_POST['product_id'];
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
        header("Location: cart.php");
        exit();
    }

    // Handle adding to wishlist (unchanged)
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_wishlist'])) {
        // ... (keeping existing wishlist code)
    }

} catch (PDOException $e) {
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
                    <?php
                    $imagePath = $product['image_url']
                        ? '../images/' . basename($product['image_url'])
                        : '../images/default.jpg';
                    ?>
                    <img src="<?= htmlspecialchars($imagePath) ?>"
                         class="card-img-top"
                         style="width: 100%; height: 261px; object-fit: cover;"
                         alt="<?= htmlspecialchars($product['product_name']) ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                        <p class="card-text"><strong>Price: $<?= number_format($product['price'], 2) ?></strong></p>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
                            <button type="submit" name="add_to_wishlist" class="btn btn-secondary">Add to Wishlist</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <h2 class="mt-5">Shopping Cart</h2>
    <div class="row">
        <?php if (!empty($_SESSION['cart'])): ?>
            <?php foreach ($_SESSION['cart'] as $productId => $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="<?= htmlspecialchars($item['image']) ?>"
                             class="card-img-top"
                             style="width: 100%; height: 261px; object-fit: cover;"
                             alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($item['name']) ?></h5>
                            <p class="card-text">Price: $<?= number_format($item['price'], 2) ?></p>
                            <p class="card-text">Quantity: <?= $item['quantity'] ?></p>
                            <form method="POST">
                                <input type="hidden" name="product_id" value="<?= $productId ?>">
                                <button type="submit" name="remove_from_cart" class="btn btn-danger">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>