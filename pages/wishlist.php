<?php
session_start();
include "../includes/db.php";

// Initialize the wishlist session array if it doesn't exist
if (!isset($_SESSION['wishlists'])) {
    $_SESSION['wishlists'] = []; // Ensure this is always an array
}

// Customer ID for demonstration purposes
$customerId = 1; 

// Check if a product is being added to the wishlist
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];

    try {
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
            $_SESSION['message'] = "Product added to wishlist successfully."; // Feedback message

            // Add product ID to the session wishlist array
            $_SESSION['wishlists'][] = $productId; // Store product ID
            
            // Debug output: Check what's in the wishlist
            error_log('Wishlist session after adding: ' . print_r($_SESSION['wishlists'], true)); // Log current wishlist session
        } else {
            $_SESSION['message'] = "Product is already in your wishlist."; // Feedback message
        }

        // Redirect back to wishlist page
        header("Location: wishlist.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors
        $_SESSION['error'] = "Error adding product to wishlist: " . $e->getMessage(); // Capture error message
        header("Location: wishlist.php");
        exit();
    }
}

// Fetch wishlist items to display
$stmt = $conn->prepare("SELECT p.product_id, p.product_name, p.price FROM wishlists w JOIN Products p ON w.product_id = p.product_id WHERE w.customer_id = :customer_id");
$stmt->execute(['customer_id' => $customerId]);
$wishlist = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Untree.co">
	<link rel="shortcut icon" href="../images/logo">
	<meta name="description" content="" />
	<meta name="keywords" content="bootstrap, bootstrap4" />

	<!-- Bootstrap CSS -->
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	<link href="../css/tiny-slider.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
	<title>Furni Free Bootstrap 5 Template for Furniture and Interior Design Websites by Untree.co </title>
</head>
<style>
.card {
    border: 1px solid #ddd; 
    border-radius: 5px; 
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); 
    transition: transform 0.3s; 
}

.card:hover {
    transform: scale(1.02);
}

.card-title {
    color: #A0051B;
}

.alert {
    margin-top: 20px; 
}
</style>

<body>

	<!-- Start Header/Navigation -->
	<nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

		<div class="container">
			<a class="navbar-brand" href="../index.php"><img class="logo-img" src="../images/Logo"
					style="max-width:150px;"></a>

			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
				aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarsFurni">
				<ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
					<li class="nav-item ">
						<a class="nav-link" href="../index.php">Home</a>
					</li>
					<li><a class="nav-link" href="shop.php">Shop</a></li>
					<li><a class="nav-link" href="about.html">About us</a></li>
					<li><a class="nav-link" href="#">Contact us</a></li>
				</ul>

				<ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
					<li><a class="nav-link" href="login.php"><i class="fa-solid fa-right-to-bracket"></i></a></li>
                    <li><a class="nav-link" href="cart.php"><img src="../images/cart.svg"></a></li>
                    <li>
                        <a class="nav-link" href="wishlist.php">
                            <i class="fa-solid fa-heart"></i>
                            <span class="wishlist-count"><?php echo count($_SESSION['wishlists']); ?></span> <!-- Updated wishlist count -->
                        </a>
                    </li>
				</ul>
			</div>
		</div>

	</nav>

    <div class="container mt-5">
    <h1>Your Wishlist</h1>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']); // Clear the message after displaying
            ?>
        </div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']); // Clear the error after displaying
            ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <?php if (!empty($wishlist)): ?>
            <?php foreach ($wishlist as $item): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($item['product_name']); ?></h5>
                            <p class="card-text">$<?php echo number_format($item['price'], 2); ?></p>
                            <form method="POST" action="remove_wishlist.php" style="display:inline;">
                                <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                                <button type="submit" name="remove_wishlist" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-warning">Your wishlist is empty.</div>
            </div>
        <?php endif; ?>
    </div>
</div>
    	<!-- Start Footer Section -->
	<footer class="footer-section">
		<div class="container relative" style="margin-bottom: -50px;">

			<div class="sofa-img">
				<img src="../images/sofa.png" alt="Image" class="img-fluid">
			</div>

			<div class="row">
				<div class="col-lg-8">
					<div class="subscription-form">
					</div>
				</div>
			</div>

			<div class="row g-5 mb-5">
				<div class="col-lg-4">
					<div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">Nest & Buy </a></div>
					<p class="mb-4">At Nest & Buy, we bring you stylish, high-quality furniture to make your home cozy
						and beautiful. With a focus on craftsmanship and design, we’re here to help you create spaces
						you love.
					</p>

					<ul class="list-unstyled custom-social">
						<li><a href="#"><span class="fa fa-brands fa-facebook-f"></span></a></li>
						<li><a href="#"><span class="fa fa-brands fa-twitter"></span></a></li>
						<li><a href="#"><span class="fa fa-brands fa-instagram"></span></a></li>
						<li><a href="#"><span class="fa fa-brands fa-linkedin"></span></a></li>
					</ul>
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
								<li><a href="about.html#ourTeam">Our team</a></li>
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

						<div class="col-6 col-sm-6 col-md-3">
							<ul class="list-unstyled">
								<img src="../images/Logo (2).png" style="max-width: 130px;">
							</ul>
						</div>
					</div>
				</div>

			</div>

			<div class="border-top copyright">
				<div class="row pt-4">
					<div class="col-lg-6">
						<p class="mb-2 text-center text-lg-start">Copyright &copy;
							<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash;
							Designed with love by Nest & Buy
						</p>
					</div>

					<div class="col-lg-6 text-center text-lg-end">
						<ul class="list-unstyled d-inline-flex ms-auto">
							<li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
							<li><a href="#">Privacy Policy</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- End Footer Section -->

</body>
</html>
