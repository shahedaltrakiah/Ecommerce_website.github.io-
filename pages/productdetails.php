<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-commerce_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if product ID is set in the URL
    if (isset($_GET['id'])) {
        $productId = htmlspecialchars($_GET['id']);

        // Fetch product details by ID
        $stmt = $conn->prepare("SELECT products.*, productimages.image_url FROM products 
                                 JOIN productimages ON products.product_id = productimages.product_id 
                                 WHERE products.product_id = :product_id");
        $stmt->bindParam(':product_id', $productId);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product === false) {
            echo "Product not found.";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Check if the form is submitted
            $fullName = htmlspecialchars($_POST['full_name']);
            $email = htmlspecialchars($_POST['email']);
            $phone = htmlspecialchars($_POST['phone']);
            $rating = htmlspecialchars($_POST['rating']);
            $comment = htmlspecialchars($_POST['comment']);
        
            // Prevent duplicate submissions by checking existing reviews (optional)
            $existingReviewStmt = $conn->prepare("SELECT * FROM reviews WHERE product_id = :product_id AND customer_id = :customer_id");
            $existingReviewStmt->bindParam(':product_id', $productId);
            $existingReviewStmt->bindParam(':customer_id', $customerId); // Assuming you have the customer ID stored
            $existingReviewStmt->execute();
        
            if ($existingReviewStmt->rowCount() == 0) {
                // Insert the review if not exists
                $stmt = $conn->prepare("INSERT INTO reviews (product_id, customer_id, rating, comment, created_at) 
                                        VALUES (:product_id, 1, :rating, :comment, NOW())");
                $stmt->bindParam(':product_id', $productId);
                $stmt->bindParam(':rating', $rating);
                $stmt->bindParam(':comment', $comment);
                $stmt->execute();
        
                echo "<script>alert('Thank you for your review!');</script>";
            } else {
                echo "<script>alert('You have already submitted a review for this product!');</script>";
            }
        }
        

        // Fetch reviews for the product
        $reviewsStmt = $conn->prepare("SELECT * FROM reviews WHERE product_id = :product_id");
        $reviewsStmt->bindParam(':product_id', $productId);
        $reviewsStmt->execute();
        $reviews = $reviewsStmt->fetchAll(PDO::FETCH_ASSOC);

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
    <div class="row s_product_inner justify-content-center mb-5">
        <!-- Product Images Section -->
        <div class="col-lg-7 col-xl-7">
            <div class="product_slider_img">
                <div id="vertical">
                    <!-- Main Product Image -->
                    <div>
                        <?php
                        // The main product image URL (base image)
                        $baseImageUrl = htmlspecialchars($product['image_url'] ?? '../images/default-product.png');
                        ?>
                        <img id="main-image" width="461px" height="461px" src="http://localhost/Ecommerce_website.github.io-/<?= $baseImageUrl; ?>" class="img-fluid" alt="<?= htmlspecialchars($product['product_name']); ?>">
                    </div>

                    <!-- Sub-images (Thumbnails) -->
                    <div class="sub-images mt-3">
                        <?php
                        // Extract base name and extension for image processing
                        $baseName = pathinfo($baseImageUrl, PATHINFO_FILENAME); 
                        $extension = pathinfo($baseImageUrl, PATHINFO_EXTENSION); 

                        // Loop through sub-images (from 1 to 9)
                        for ($i = 1; $i <= 9; $i++) {
                            // Generate sub-image URL
                            $subImageUrl = "http://localhost/Ecommerce_website.github.io-/images/{$baseName}{$i}.{$extension}";

                            // Check if the file exists locally
                            $localImagePath = "../images/{$baseName}{$i}.{$extension}";

                            // If the file doesn't exist, stop the loop
                            if (!file_exists($localImagePath)) {
                                break;
                            }

                            // Display the sub-image with a class for JavaScript handling
                            echo '<img class="sub-image img-thumbnail ms-1" width="60px" height="60px" src="' . $subImageUrl . '" alt="' . htmlspecialchars($product['product_name']) . '">';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="col-lg-5 col-xl-4">
    <div class="s_product_text ">
        <?php
        // Function to format the product name
        function formatProductName($name) {
            // Replace dashes with spaces and capitalize each word
            return ucwords(str_replace('-', ' ', $name));
        }
        ?>
        
        <h3><?= htmlspecialchars(formatProductName($product['product_name'])); ?></h3>
        <h2>$<?= htmlspecialchars($product['price']); ?></h2>
        
        <p><?= htmlspecialchars($product['description']); ?></p>
        <ul class="list list-unstyled">
            <li>
                <a class="active" href="#"><span>Category</span> : Household</a>
            </li>
            <li>
                <a href="#">
                    <span>Availability</span> :
                    <?php
                    // Check stock quantity for availability
                    if (is_null($product['stock_quantity'])) {
                        echo "Sold Out";
                    } elseif ($product['stock_quantity'] <= 5) {
                        echo "Don't miss out, stock running low!";
                    } else {
                        echo "In Stock";
                    }
                    ?>
                </a>
            </li>
        </ul>
        <div class="card_area d-flex justify-content-between align-items-center">
            <div class="product_count">
                <span class="inumber-decrement"> <i class="ti-minus"></i></span>
                <input class="input-number" type="text" value="1" min="0" max="10">
                <span class="number-increment"> <i class="ti-plus"></i></span>
            </div>
            <a href="#" class="btn btn-secondary me-1">Add to Cart</a>
            <a href="#" class="like_us btn-secondary"> <i class="ti-heart"></i> </a>
        </div>
    </div>
    
</div>
<div class="container mt-5">
        <!-- Review Form -->
        <h4>Add Your Review</h4>
    <form method="POST" action="">
        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" id="full_name" class="form-control w-50" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" class="form-control w-50" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone:</label>
            <input type="text" name="phone" id="phone" class="form-control w-50" required>
        </div>
        <div class="form-group">
            <label for="rating">Rating:</label>
            <select name="rating" id="rating" class="form-control w-50" required>
                <option value="1">1 Star</option>
                <option value="2">2 Stars</option>
                <option value="3">3 Stars</option>
                <option value="4">4 Stars</option>
                <option value="5">5 Stars</option>
            </select>
        </div>
        <div class="form-group">
            <label for="comment">Comment:</label>
            <textarea name="comment" id="comment" class="form-control w-50" rows="4" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Review</button>
               
    </form>
    </div>

    <!-- Display Reviews -->
    <h4 class="mt-5">Reviews</h4>
    <?php if (count($reviews) > 0): ?>
        <?php foreach ($reviews as $review): ?>
            <div class="review">
                <p><strong>Rating:</strong> <?= htmlspecialchars($review['rating']); ?> Stars</p>
                <p><strong>Comment:</strong> <?= htmlspecialchars($review['comment']); ?></p>
                <p><em>Reviewed on <?= htmlspecialchars($review['created_at']); ?></em></p>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No reviews yet. Be the first to leave a review!</p>
    <?php endif; ?>
    </div>
</form>


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

<!-- JavaScript for Image Swap -->
<script>
// Select all sub-images
const subImages = document.querySelectorAll('.sub-image');

// Select the main image
const mainImage = document.getElementById('main-image');

// Loop through each sub-image and add a click event listener
subImages.forEach(function(subImage) {
    subImage.addEventListener('click', function() {
        // Set the src of the main image to the clicked sub-image src
        mainImage.src = subImage.src;
    });
});
</script>
    <script src="../js/bootstrap.bundle.min.js"></script>
    <script src="../js/tiny-slider.js"></script>
    <script src="../js/custom.js"></script>
</body>
</html>
