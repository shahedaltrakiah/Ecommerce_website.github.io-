<?php 
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-commerce_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if product ID is set in the URL
    if (isset($_GET['id'])) {
        $productId = htmlspecialchars($_GET['id']);
        
        // Prepare and execute the query to fetch product details by ID
        $stmt = $conn->prepare("SELECT products.*, productimages.image_url FROM products 
                                 JOIN productimages ON products.product_id = productimages.product_id 
                                 WHERE products.product_id = :product_id");
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();
        
        // Fetch the product details
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Check if product exists
        if ($product === false) {
            echo "Product not found.";
            exit;
        }
    } else {
        echo "Product ID not found.";
        exit;
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <link rel="shortcut icon" href="../images/logoo">
    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="../css/tiny-slider.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <title><?= htmlspecialchars($product['product_name'] ?? 'Unknown Product'); ?> | Nest & Buy</title>
</head>
<body>

    <!-- Start Header/Navigation -->
    <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">
        <div class="container">
            <a class="navbar-brand" href="../index.php"><img class="logo-img" src="../images/Logo" style="max-width:150px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni" aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="active"><a class="nav-link" href="shop.php">Shop</a></li>
                    <li><a class="nav-link" href="about.html">About us</a></li>
                    <li><a class="nav-link" href="contact.php">Contact us</a></li>
                </ul>
                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li><a class="nav-link" href="login.php"><i class="fa-solid fa-right-to-bracket"></i></a></li>
                    <li><a class="nav-link" href="cart.php"><img src="../images/cart.svg"></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- End Header/Navigation -->

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img  width="261px" height="261px" src="http://localhost/Ecommerce_website.github.io-/<?= htmlspecialchars($product['image_url'] ?? '../images/default-product.png'); ?>" class="img-fluid" alt="<?= htmlspecialchars($product['product_name']); ?>">
            </div>
            <div class="col-md-6">
                <h1><?= htmlspecialchars($product['product_name']); ?></h1>
                <p><?= htmlspecialchars($product['description']); ?></p>
                <h3 class="text-success">$<?= htmlspecialchars($product['price']); ?></h3>
                <button class="btn btn-primary">Add to Cart</button>
                <button class="btn btn-light ms-2">
                    <i class="fa-solid fa-heart " ></i> Add to Wishlist
                </button>
            </div>
        </div>
    </div>

    <!-- Start Footer Section -->
    <footer class="footer-section">
        <div class="container relative" style="margin-bottom: -50px; margin-top: 30px;">
          
            <div class="row g-5 mb-5">
                <div class="col-lg-4">
                    <div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">Nest & Buy </a></div>
                    <p class="mb-4">At Nest & Buy, we bring you stylish, high-quality furniture to make your home cozy and beautiful. With a focus on craftsmanship and design, we’re here to help you create spaces you love.</p>
                </div>

                <div class="col-lg-8">
                    <div class="row links-wrap">
                        <div class="col-6 col-sm-6 col-md-3">
                            <ul class="list-unstyled">
                                <li><a href="about.html">About us</a></li>
                                <li><a href="shop.php">Shop</a></li>
                                <li><a href="#">Contact us</a></li>
                            </ul>
                        </div>

                        <div class="col-6 col-sm-6 col-md-3">
                            <ul class="list-unstyled">
                                <li><a href="#">Testimonials</a></li>
                                <li><a href="#">Our team</a></li>
                                <li><a href="#">Live chat</a></li>
                            </ul>
                        </div>

                        <div class="col-6 col-sm-6 col-md-3">
                            <ul class="list-unstyled">
                                <li><a href="#">Category</a></li>
                                <li><a href="#">Product</a></li>
                                <li><a href="#">Best seller</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-top copyright">
                <div class="row pt-4">
                    <div class="col-lg-6">
                        <p class="mb-2 text-center text-lg-start">Copyright &copy; 
                            <script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by Nest & Buy
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer Section -->

    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/tiny-slider.js"></script>
    <script src="../js/custom.js"></script>
</body>
</html>
