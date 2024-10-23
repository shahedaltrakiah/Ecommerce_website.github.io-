<?php
session_start();
include "../includes/db.php";

$subtotal = 0; // Initialize subtotal
$database = new Database();
$conn = $database->getConnection();

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add products to cart
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
    $productId = $_POST['product_id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = :product_id");
    $stmt->execute(['product_id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $_SESSION['cart'][$productId] = [
            'name' => $product['product_name'],
            'price' => $product['price'],
            'quantity' => ($_SESSION['cart'][$productId]['quantity'] ?? 0) + 1,
            'image' => $product['image'],
            'description' => $product['description'],
        ];
    }
}

// Calculate subtotal
foreach ($_SESSION['cart'] as $product) {
    $subtotal += $product['price'] * $product['quantity'];
}

// Set subtotal in session to ensure it's updated
$_SESSION['subtotal'] = $subtotal;

// Initialize discount variables
$discountAmount = 0;
if (!isset($_SESSION['discount'])) {
    $_SESSION['discount'] = 0; // Initialize if it doesn't exist
}

// Apply coupon logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['apply_coupon'])) {
        $couponCode = $_POST['coupon_code'];

        // Fetch the coupon from the database
        $stmt = $conn->prepare("SELECT discount, expiration_date FROM coupons WHERE code = :code");
        $stmt->execute(['code' => $couponCode]);
        $coupon = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if coupon exists and is not expired
        if ($coupon) {
            $currentDate = date('Y-m-d H:i:s');
            if ($currentDate <= $coupon['expiration_date']) {
                // Initialize the applied_coupons array in the session if it doesn't exist
                if (!isset($_SESSION['applied_coupons'])) {
                    $_SESSION['applied_coupons'] = [];
                }

                // Add coupon to the session array if not already applied
                if (!in_array($couponCode, $_SESSION['applied_coupons'])) {
                    $_SESSION['applied_coupons'][] = $couponCode;

                    // Calculate the discount based on the coupon
                    $discountAmount = ($_SESSION['subtotal'] * $coupon['discount']) / 100;
                    $_SESSION['discount'] += $discountAmount; // Aggregate discounts

                    // Update subtotal after applying the discount
                    $_SESSION['subtotal'] -= $discountAmount; // Store the new subtotal
                } else {
                    $_SESSION['error_message'] = "Coupon has already been applied.";
                }
            } else {
                $_SESSION['error_message'] = "Coupon has expired.";
            }
        } else {
            $_SESSION['error_message'] = "Invalid coupon code.";
        }
    } elseif (isset($_POST['remove_coupon'])) {
        $couponCode = $_POST['coupon_code'];

        // Check if the coupon is applied
        if (in_array($couponCode, $_SESSION['applied_coupons'])) {
            // Remove the coupon from the session
            $key = array_search($couponCode, $_SESSION['applied_coupons']);
            unset($_SESSION['applied_coupons'][$key]);

            // Reset discount amount for the removed coupon
            $stmt = $conn->prepare("SELECT discount FROM coupons WHERE code = :code");
            $stmt->execute(['code' => $couponCode]);
            $coupon = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($coupon) {
                // Recalculate the discount based on the coupon
                $removedDiscountAmount = ($_SESSION['subtotal'] * $coupon['discount']) / 100;
                $_SESSION['discount'] -= $removedDiscountAmount; // Deduct the removed coupon discount

                // Revert the subtotal
                $_SESSION['subtotal'] += $removedDiscountAmount; // Restore subtotal
            }

            if (empty($_SESSION['applied_coupons'])) {
                // Reset discount if no coupons are applied
                $_SESSION['discount'] = 0;
            }
        } else {
            $_SESSION['error_message'] = "Coupon not found in applied coupons.";
        }
    }
}

// Redirect to cart page only if not already there
if (!isset($_SESSION['redirected'])) {
    $_SESSION['redirected'] = true; // Prevents redirect loop
    header("Location: cart.php");
    exit();
} else {
    unset($_SESSION['redirected']); // Reset for the next request
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

  <title>Furni Free Bootstrap 5 Template for Furniture and Interior Design Websites by Untree.co</title>
</head>

<body>

  <!-- Start Header/Navigation -->
  <nav class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" aria-label="Furni navigation bar">

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
          <li><a class="nav-link" href="contact.php">Contact us</a></li>
        </ul>

        <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
          <li><a class="nav-link" href="login.php"><i class="fa-solid fa-right-to-bracket"></i></a></li>
          <a class="nav-link" href="cart.php">
            <img src="../images/cart.svg">
            <span class="cart-count"><?php echo isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?></span>
          </a>
        </ul>
      </div>
    </div>

  </nav>
  <!-- End Header/Navigation -->


        <div class="untree_co-section before-footer-section">
          <div class="container">
            <div class="row mb-5">
              <form class="col-md-12" method="post">
                <div class="site-blocks-table">
                  <table class="table">
                    <thead>
                      <tr>
                        <th class="product-thumbnail">Image</th>
                        <th class="product-name">Product</th>
                        <th class="product-price">Price</th>
                        <th class="product-quantity">Quantity</th>
                        <th class="product-total">Total</th>
                        <th class="product-remove">Remove</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
                        <?php foreach ($_SESSION['cart'] as $product_id => $product): ?>
                          <?php
                          $total = $product['price'] * $product['quantity'];
                          $subtotal += $total;
                          ?>
                          <tr>
                            <td class="product-thumbnail"><img src="path/to/image/<?php echo $product_id; ?>.jpg" alt="Image"
                                class="img-fluid"></td>
                            <td class="product-name"><?php echo htmlspecialchars($product['name']); ?></td>
                            <td class="product-price">$<?php echo number_format($product['price'], 2); ?></td>
                            <td class="product-quantity"><?php echo htmlspecialchars($product['quantity']); ?></td>
                            <td class="product-total">$<?php echo number_format($total, 2); ?></td>
                            <td class="product-remove"><a
                                href="remove_from_cart.php?id=<?php echo urlencode($product_id); ?>">Remove</a></td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="6" class="text-center">No items in the cart</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </form>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="row mb-5">
                  <div class="col-md-6 mb-3 mb-md-0">
                    <button class="btn btn-black btn-sm btn-block">Update Cart</button>
                  </div>
                  <div class="col-md-6">
                    <button class="btn btn-outline-black btn-sm btn-block">Continue Shopping</button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <label class="text-black h4" for="coupon">Coupon</label>
                    <p>Enter your coupon code if you have one.</p>
                  </div>
                  <form method="post">
                    <div class="col-md-8 mb-3 mb-md-0">
                      <input type="text" class="form-control py-3" id="coupon" name="coupon_code" placeholder="Coupon Code">
                    </div>
                    <div class="col-md-4">
                      <button type="submit" name="apply_coupon" class="btn btn-black">Apply Coupon</button>
                    </div>
                  </form>
                </div>
              </div>
              <div class="col-md-6 pl-5">
                <div class="row justify-content-end">
                  <div class="col-md-7">
                    <div class="row">
                      <div class="col-md-12 text-right border-bottom mb-5">
                        <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                      </div>
                      <?php if (isset($_SESSION['error_message'])): ?>
          <div class="alert alert-danger">
            <?php echo $_SESSION['error_message']; ?>
            <?php unset($_SESSION['error_message']); // Clear the message after displaying ?>
          </div>
        <?php endif; ?>
                    </div>
                    <div class="row mb-5">
    <div class="col-md-6">
        <span class="text-black">Subtotal</span>
    </div>
    <div class="col-md-6 text-right">
        <strong class="text-black">
            $<?php echo number_format(isset($_SESSION['subtotal']) ? $_SESSION['subtotal'] : 0, 2); ?>
        </strong>
    </div>
</div>

<?php
// Initialize discountAmount from session if it exists
$discountAmount = isset($_SESSION['discount']) ? $_SESSION['discount'] : 0;

// Check if discount is set
if ($discountAmount > 0): ?>
    <div class="row mb-5">
        <div class="col-md-6">
            <span class="text-black">Discount</span>
        </div>
        <div class="col-md-6 text-right">
            <strong class="text-black">-$<?php echo number_format($discountAmount, 2); ?></strong>
        </div>
    </div>
<?php endif; ?>

<div class="row mb-5">
    <div class="col-md-6">
        <span class="text-black">Total</span>
    </div>
    <div class="col-md-6 text-right">
        <strong class="text-black">
            $<?php
            // Calculate the total as subtotal minus discount
            $total = isset($_SESSION['subtotal']) ? $_SESSION['subtotal'] : 0;
            // Using $discountAmount which was set above
            echo number_format($total - $discountAmount, 2);
            ?>
        </strong>
    </div>
</div>
<div class="row mb-5">
                        <div class="col-md-12">
                          <a href="checkout.php" class="btn btn-black btn-lg btn-block">Proceed to Checkout</a>
                        </div>
                      </div>
                    </div> <!-- End of Cart Totals -->

                  </div> <!-- End of col-md-7 -->
                </div> <!-- End of row justify-content-end -->
              </div> <!-- End of col-md-6 pl-5 -->
            </div> <!-- End of row -->
          </div> <!-- End of container -->
        </div> <!-- End of untree_co-section before-footer-section -->
  <!-- Start Footer Section -->
  <footer class="footer-section">
        <div class="container relative" style="margin-top: 50px;">

            <div class="sofa-img">
                <img src="../images/sofa.png" alt="Image" class="img-fluid">
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="subscription-form">
                        <h3 class="d-flex align-items-center"><span class="me-1"><img src="../images/envelope-outline.svg"
                                    alt="Image" class="img-fluid"></span><span>Subscribe to Newsletter</span></h3>

                        <form class="row g-3" id="subscribeForm">
                            <div class="col-auto">
                                <input type="text" class="form-control" placeholder="Enter your name" id="name"
                                    name="first_name">
                            </div>
                            <div class="col-auto">
                                <input type="email" class="form-control" placeholder="Enter your email" id="email"
                                    name="email">
                            </div>
                            <div class="col-auto" style="margin-top: 25px;">
                                <button type="submit" class="btn btn-primary">
                                    <span class="fa fa-paper-plane"></span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="row g-5 mb-5">
                <div class="col-lg-4">
                    <div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">Nest & Buy </a></div>
                    <p class="mb-4">At Nest & Buy, we bring you stylish, high-quality furniture to make your
                        home
                        cozy
                        and beautiful. With a focus on craftsmanship and design, we’re here to help you create
                        spaces
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
                            <script>document.write(new Date().getFullYear());</script>. All Rights Reserved.
                            &mdash;
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

  <!-- Bootstrap JS -->
  <script src="../js/bootstrap.bundle.min.js"></script>
  <script src="../js/tiny-slider.js"></script>
  <script src="../js/main.js"></script>

</body>

</html>
