<?php
$dsn = 'mysql:host=localhost;dbname=e-commerce_db';
$username = 'root';
$password = ''; 

// Initialize the $results variable
$results = []; // Initialize as an empty array

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

   // Get filter criteria from the form
$product_name = isset($_GET['product_name']) ? $_GET['product_name'] : '';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 0;
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : 9999; // Ensure max price has a valid default value
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null; // Get category_id from the form

// Corrected SQL query to include category filtering
$sql = "SELECT products.*, productimages.image_url, categories.category_name
            FROM products 
            JOIN productimages ON products.product_id = productimages.product_id
            JOIN categories ON products.category_id = categories.category_id
            WHERE products.product_name LIKE :product_name 
            AND products.price BETWEEN :min_price AND :max_price
            AND productimages.image_url NOT REGEXP '[0-9]'";

// Add category filter if it exists
if ($category_id) {
    $sql .= " AND products.category_id = :category_id"; // Make sure your products table has a category_id column
}

$stmt = $pdo->prepare($sql);
$params = [
    'product_name' => "%$product_name%",
    'min_price' => $min_price,
    'max_price' => $max_price,
];

// Include the category filter if selected
if ($category_id) {
    $params['category_id'] = $category_id;
}

$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Handle the error (optional logging)
    echo "Connection failed: " . $e->getMessage();
}

// Displaying Filtered Products
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
	<title> Nest & Buy </title>
</head>

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
					<li class="active"><a class="nav-link" href="#">Shop</a></li>
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

	<!-- Start Hero Section -->
	<div class="hero" style="height: 60px;">
		<div class="container">
			<div class="row ">
				<div class="col-lg-12">
					<div class="intro-excerptt">
						<h1 style="margin-bottom: 20px; margin-top: -30px;"> Shop </h1>
						<p style="font-size: 15px;">Discover Your Perfect Style: Handpicked Furniture for Every Space.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Hero Section -->

<!-- Filter Form -->
<div class="container mt-4">
    <form method="GET" class="row g-3">
        <!-- Product Name -->
        <div class="col-md-3">
            <label for="product_name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="product_name" name="product_name" value="<?= htmlspecialchars($product_name); ?>">
        </div>

        <!-- Minimum Price -->
        <div class="col-md-2">
            <label for="min_price" class="form-label">Min Price</label>
            <input type="number" class="form-control" id="min_price" name="min_price" min="0" step="0.01" value="<?= htmlspecialchars($min_price); ?>">
        </div>

        <!-- Maximum Price -->
        <div class="col-md-2">
            <label for="max_price" class="form-label">Max Price</label>
            <input type="number" class="form-control" id="max_price" name="max_price" min="0" step="0.01" value="<?= htmlspecialchars($max_price); ?>">
        </div>

	<!-- Category Filter -->
<div class="col-md-3">
    <label for="category_id" class="form-label">Category</label>
    <select class="form-select" id="category_id" name="category_id">
        <option value="">All Categories</option>
        <?php
        // Fetch categories for the filter dropdown
        try {
            $category_stmt = $pdo->query("SELECT * FROM categories");
            $categories = $category_stmt->fetchAll(PDO::FETCH_ASSOC);

            // Initialize $category_id from GET or as an empty string if not set
            $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';

            foreach ($categories as $category) {
                // Check if the category_id from GET is the same as the current category
                $selected = $category_id == $category['category_id'] ? 'selected' : '';
                // Display the category_name
                echo "<option value=\"" . htmlspecialchars($category['category_id']) . "\" $selected>" . htmlspecialchars($category['category_name']) . "</option>";
            }
        } catch (PDOException $e) {
            echo "Error fetching categories: " . $e->getMessage();
        }
        ?>
    </select>
</div>



        <!-- Submit Button -->
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>
</div>

<!-- Start Displaying Filtered Products -->
<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            <?php if (!empty($results)): ?>
                <?php foreach ($results as $product): ?>
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                        <a class="product-item" href="productdetails.php?id=<?= htmlspecialchars($product['product_id']); ?>">
                            <!-- Adjusted the image path to include the full web path -->
                            <img  width="261px" height="261px" src="http://localhost/Ecommerce_website.github.io-\<?= htmlspecialchars($product['image_url']); ?>" class="img-fluid product-thumbnail" alt="<?= htmlspecialchars($product['product_name']);?>">
                            <h3 class="product-title"><?= htmlspecialchars($product['product_name']); ?></h3>
                            <strong class="product-price">$<?= htmlspecialchars($product['price']); ?></strong>

                            <span class="icon-cross">
                                <img src="../images/cross.svg" class="img-fluid">
                            </span>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center">No products found matching your criteria.</p>
            <?php endif; ?>
        </div>
    </div> 
</div>


	<!-- Start Footer Section -->
	<footer class="footer-section">
		<div class="container relative" style="margin-bottom: -50px; margin-top: 30px;">

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


	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/tiny-slider.js"></script>
	<script src="../js/custom.js"></script>
</body>

</html>