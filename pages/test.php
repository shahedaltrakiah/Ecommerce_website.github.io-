<?php
session_start();
$products = [
    [
        'id' => 1,
        'name' => 'Sofa 1',
        'description' => 'Comfortable 3-seater sofa.',
        'price' => 299.99,
        'height' => 85,
        'width' => 200, 
        'image' => '../images/product-2.png' 
    ],
    [
        'id' => 2,
        'name' => 'Sofa 1',
        'description' => 'Comfortable 3-seater sofa.',
        'price' => 299.99,
        'height' => 85, 
        'width' => 200,
        'image' => '../images/product-2.png' 
    ],
    [
        'id' => 3,
        'name' => 'Sofa 1',
        'description' => 'Comfortable 3-seater sofa.',
        'price' => 299.99,
        'height' => 85, 
        'width' => 200, 
        'image' => '../images/product-2.png' 
    ],
    [
        'id' => 4,
        'name' => 'Sofa 1',
        'description' => 'Comfortable 3-seater sofa.',
        'price' => 299.99,
        'height' => 85,
        'width' => 200,
        'image' => '../images/product-2.png' 
    ],
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['id'];
    $productName = $_POST['name'];
    $productDescription = $_POST['description'];
    $productPrice = $_POST['price'];
    $productHeight = $_POST['height'];
    $productWidth = $_POST['width'];
    $productImage = $_POST['image'];
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][$productId] = [
        'name' => $productName,
        'description' => $productDescription,
        'price' => $productPrice,
        'height' => $productHeight,
        'width' => $productWidth,
        'image' => $productImage,
        'quantity' => isset($_SESSION['cart'][$productId]['quantity']) ? $_SESSION['cart'][$productId]['quantity'] + 1 : 1
    ];
    
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    </style>
</head>
<body style="background-color:black">
    <div class="container mt-5">
        <h1>Available Sofas</h1>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-3">
                    <div class="card mb-4">
                        <img src="<?= $product['image'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $product['name'] ?></h5>
                            <p class="card-text"><?= $product['description'] ?></p>
                            <p class="card-text">Price: $<?= number_format($product['price'], 2) ?></p>
                            <p class="card-text">Height: <?= $product['height'] ?> cm</p>
                            <p class="card-text">Width: <?= $product['width'] ?> cm</p>
                            <form method="post" action="test.php">
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                <input type="hidden" name="name" value="<?= $product['name'] ?>">
                                <input type="hidden" name="description" value="<?= $product['description'] ?>">
                                <input type="hidden" name="price" value="<?= $product['price'] ?>">
                                <input type="hidden" name="height" value="<?= $product['height'] ?>">
                                <input type="hidden" name="width" value="<?= $product['width'] ?>">
                                <input type="hidden" name="image" value="<?= $product['image'] ?>">
                                <button type="submit" class="btn btn-primary btn-dua">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
