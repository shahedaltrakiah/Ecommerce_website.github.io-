<?php
session_start(); // Start the session to access cart data
include "../includes/db.php";
$database = new Database();
$conn = $database->getConnection();
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['c_fname'];
    $lastName = $_POST['c_lname'];
    $address = $_POST['c_address'];
    $stateCountry = $_POST['c_state_country'];
    $postalZip = $_POST['c_postal_zip'];
    $email = $_POST['c_email_address'];
    $phone = $_POST['c_phone'];
    $orderNotes = $_POST['c_order_notes'];
	$couponCode = $_POST['coupon_code'] ?? '';

    // Calculate total amount from cart items
    $totalAmount = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $totalAmount += $item['price'] * $item['quantity']; // Assuming each item has 'price' and 'quantity'
        }
    }
	$discount = 0; // Initialize discount amount
    if (!empty($couponCode)) {
        $stmt = $conn->prepare("SELECT * FROM coupons WHERE code = :code");
        $stmt->execute(['code' => $couponCode]);
        $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($coupon && $coupon['usage_limit'] > 0) {
            // Apply discount logic here, for example:
            $discount = $coupon['discount_amount']; // Assume there's a discount_amount column
            $totalAmount -= $discount; // Subtract discount from total amount

            // Decrement usage limit
            $stmt = $conn->prepare("UPDATE coupons SET usage_limit = usage_limit - 1 WHERE code = :code");
            $stmt->execute(['code' => $couponCode]);
        }
    }

    // Insert order into the database
    $sql = "INSERT INTO `orders` (customer_id, total_amount, status) VALUES (:customer_id, :total_amount, 'pending')";
    $stmt = $conn->prepare($sql);
    
    // Assuming you have a way to get customer_id
    $customerId = 1; // Placeholder: replace with actual customer ID retrieval logic
    $stmt->bindParam(':customer_id', $customerId);
    $stmt->bindParam(':total_amount', $totalAmount);

    if ($stmt->execute()) {
        // Get the last inserted order ID
        $orderId = $conn->lastInsertId();

        // Insert order items into order_items table
        foreach ($_SESSION['cart'] as $item) {
            $sql = "INSERT INTO orderitems (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':order_id', $orderId);
            $stmt->bindParam(':product_id', $item['product_id']);
            $stmt->bindParam(':quantity', $item['quantity']);
            $stmt->bindParam(':price', $item['price']);
            $stmt->execute();
        }

        // Clear the cart after order is placed
		unset($_SESSION['cart']);
        unset($_SESSION['subtotal']);
        unset($_SESSION['discounts']);
        unset($_SESSION['applied_coupons']);


        // Redirect to thank you page
        header("Location: thankyou.html");
        exit();
    } else {
        echo "Error: Could not place order.";
    }
}
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
				</ul>
			</div>
		</div>

	</nav>
	<!-- End Header/Navigation -->

	<div class="untree_co-section">
		<div class="container">
			<div class="row mb-5">
				<div class="col-md-12">
					<div class="border p-4 rounded" role="alert">
						Returning customer? <a href="login.php">Click here</a> to login
					</div>
				</div>
			</div>
			<div class="row">
    <div class="col-md-6 mb-5 mb-md-0">
        <h2 class="h3 mb-3 text-black">Billing Details</h2>
        <div class="p-3 p-lg-5 border bg-white">
		<form action="checkout.php" method="POST" onsubmit="return validateForm() ">
    <div class="form-group row">
        <div class="col-md-6">
            <label for="c_fname" class="text-black">First Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="c_fname" name="c_fname" required>
        </div>
        <div class="col-md-6">
            <label for="c_lname" class="text-black">Last Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="c_lname" name="c_lname" required>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            <label for="c_address" class="text-black">Address <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="c_address" name="c_address" placeholder="Street address" required>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-md-6">
            <label for="c_state_country" class="text-black">State / Country <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="c_state_country" name="c_state_country" required>
        </div>
        <div class="col-md-6">
            <label for="c_postal_zip" class="text-black">Postal / Zip <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="c_postal_zip" name="c_postal_zip" required>
        </div>
    </div>

    <div class="form-group row mb-5">
        <div class="col-md-6">
            <label for="c_email_address" class="text-black">Email Address <span class="text-danger">*</span></label>
            <input type="email" class="form-control" id="c_email_address" name="c_email_address" required>
        </div>
        <div class="col-md-6">
            <label for="c_phone" class="text-black">Phone <span class="text-danger">*</span></label>
            <input type="tel" class="form-control" id="c_phone" name="c_phone" placeholder="Phone Number" required>
        </div>
    </div>

    <div class="form-group m-2">
        <label for="c_order_notes" class="text-black">Order Notes</label>
        <textarea name="c_order_notes" id="c_order_notes" cols="30" rows="5" class="form-control" placeholder="Write your notes here..."></textarea>
    </div>

    <button type="submit" class="btn btn-primary m-auto d-flex p-3">Proceed to Payment</button>
</form>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row mb-5">
            <div class="col-md-12">
                <h2 class="h3 mb-3 text-black">Coupon Code</h2>
                <div class="p-3 p-lg-5 border bg-white">
                    <label for="c_code" class="text-black mb-3">Enter your coupon code if you have one</label>
                    <div class="input-group w-75 couponcode-wrap">
                        <input type="text" class="form-control me-2" id="c_code" name="c_code" placeholder="Coupon Code" aria-label="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-black btn-sm" type="button" id="apply-coupon">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="row mb-5">
						<div class="col-md-12">
							<h2 class="h3 mb-3 text-black">Your Order</h2>
							<div class="p-3 p-lg-5 border bg-white">
								<table class="table site-block-order-table mb-5">
									<thead>
										<th>Product</th>
										<th>Total</th>
									</thead>
									<tbody>
										<tr>
											<td>Top Up T-Shirt <strong class="mx-2">x</strong> 1</td>
											<td>$250.00</td>
										</tr>
										<tr>
											<td>Polo Shirt <strong class="mx-2">x</strong> 1</td>
											<td>$100.00</td>
										</tr>
										<tr>
											<td class="text-black font-weight-bold"><strong>Cart Subtotal</strong></td>
											<td class="text-black">$350.00</td>
										</tr>
										<tr>
											<td class="text-black font-weight-bold"><strong>Order Total</strong></td>
											<td class="text-black font-weight-bold"><strong>$350.00</strong></td>
										</tr>
									</tbody>
								</table>

								<div class="form-group">
									<button class="btn btn-black btn-lg py-3 btn-block d-flex m-auto"
										onclick="window.location='thankyou.html'">Place Order</button>
								</div>

							</div>
						</div>
					</div>

				</div>
			</div>
    </div>
</div>


			<!-- </form> -->
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

<script>
function validateForm() {
    const firstName = document.getElementById('c_fname').value;
    const lastName = document.getElementById('c_lname').value;
    const email = document.getElementById('c_email_address').value;
    const phone = document.getElementById('c_phone').value;
    const postal = document.getElementById('c_postal_zip').value;
    const namePattern = /^[A-Za-z]{3,}$/; 
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 
    const phonePattern = /^07\d{8}$/;
    const postalPattern = /^\d{5}(-\d{4})?$/; 
    if (!firstName || !lastName || !email || !phone || !postal) {
        Swal.fire({
            icon: 'error',
            title: 'Required Fields',
            text: 'All fields are required.',
            confirmButtonColor: '#3B5D50'
        });
        return false;
    }
    if (!namePattern.test(firstName)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Input',
            text: 'First name must contain at least 3 letters.'
			,
			confirmButtonColor: '#3B5D50'

        });
        return false;
    }
    if (!namePattern.test(lastName)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Input',
            text: 'Last name must contain at least 3 letters.',
			confirmButtonColor: '#3B5D50'

        });
        return false;
    }
    if (!emailPattern.test(email)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Input',
            text: 'Please enter a valid email address.'
			,
			confirmButtonColor: '#3B5D50'

        });
        return false;
    }
    if (!postalPattern.test(postal)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Input',
            text: 'Please enter a valid postal/ZIP code.'
			,
			confirmButtonColor: '#3B5D50'

        });
        return false;
    }
    if (!phonePattern.test(phone)) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Input',
            text: 'Phone number must be exactly 10 digits and start with "07".'
			,
			confirmButtonColor: '#3B5D50'

        });
        return false;
    }

    return true; 
}

</script>
	<script src="../js/bootstrap.bundle.min.js"></script>
	<script src="../js/tiny-slider.js"></script>
	<script src="../js/custom.js"></script>
	<script src="../js/checkoutvald.js"></script>
</body>

</html>