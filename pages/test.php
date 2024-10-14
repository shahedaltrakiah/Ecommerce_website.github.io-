<?php
session_start();

// Sample product data (you can add more random products)
$products = [
    [
        'id' => 1,
        'name' => 'Sofa 1',
        'description' => 'Comfortable 3-seater sofa.',
        'price' => 299.99,
        'height' => 85, // in cm
        'width' => 200, // in cm
        'image' => '../images/product-2.png' // Placeholder image
    ],
    [
        'id' => 2,
        'name' => 'Sofa 2',
        'description' => 'Stylish L-shaped sofa.',
        'price' => 499.99,
        'height' => 85,
        'width' => 250,
        'image' => '../images/product-2.png' // Placeholder image
    ],
    [
        'id' => 3,
        'name' => 'Sofa 3',
        'description' => 'Modern recliner sofa.',
        'price' => 399.99,
        'height' => 90,
        'width' => 220,
             'image' => '../images/product-2.png'
    ],
    [
        'id' => 4,
        'name' => 'Sofa 4',
        'description' => 'Classic leather sofa.',
        'price' => 599.99,
        'height' => 85,
        'width' => 210,
        'image' => '../images/product-2.png'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>

.notification-badge {
    display: inline-block;
    background-color: red;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    text-align: center;
    line-height: 20px;
    /* position: absolute; */
    /* top: 0; */
    /* right: 0; */
    font-size: 12px;
    position: absolute;
    left: 40px;
    top: 36px;
}
.notfi
{
    position: relative;
}
</style>
</head>
<body style="background-color:black">
    <div class="notfi">
<li><a class="nav-link" href="cart.php"><img src="../images/cart.svg"></a></li>
<span class="notification-badge"></span>
    </div>
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
<script src="../js/addtocart.js"></script> 
</body>
</html>
