<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="images/logoo">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="css/tiny-slider.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <title> Nest & Buy </title>
</head>

<body>

    <!-- Start Header/Navigation -->
    <nav class="custom-navbar navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">

        <div class="container">
            <a class="navbar-brand" href="index.php"><img class="logo-img" src="images/Logo"
                    style="max-width:150px;"></a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
                aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarsFurni">
                <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li><a class="nav-link" href="pages/shop.php">Shop</a></li>
                    <li><a class="nav-link" href="pages/about.html">About us</a></li>
                    <li><a class="nav-link" href="pages/contact.php">Contact us</a></li>
                </ul>

                <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                    <li><a class="nav-link" href="pages/login.php"><i class="fa-solid fa-right-to-bracket"></i></a></li>
                    <li><a class="nav-link" href="pages/cart.php"><img src="images/cart.svg"></a></li>
                </ul>
            </div>
        </div>

    </nav>
    <!-- End Header/Navigation -->

    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Modern Interior <span clsas="d-block">Design Studio</span></h1>
                        <p class="mb-4">Transforming your vision into stunning, personalized spaces. Let’s create your
                            dream environment together!</p>
                        <p><a href="pages/login.php" class="btn btn-secondary me-2">Shop Now</a>
                            <a href="pages/shop.php" class="btn btn-white-outline">Explore</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="hero-img-wrap">
                        <img src="images/couch.png" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <!-- Start Product Slider Section -->
    <div class="product-section untree_co-section">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12 text-center">
                    <h2 class="section-title mb-3">Crafted with Excellent Materials</h2>
                    <p class="mb-4">Discover our premium collection, where quality meets style. Each piece is crafted
                        for durability and comfort, perfect for any occasion.</p>
                </div>
            </div>

            <!-- Slider -->
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    <!-- First slide with 4 products -->
                    <div class="carousel-item active">
                        <div class="row justify-content-center g-5">
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="team-member text-center category-card">
                                    <a class="category-item" href="category.html">
                                        <img src="images/beds.png" class="img-fluid" alt="Beds">
                                        <h3 class="category-title">Beds</h3>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="team-member text-center category-card">
                                    <a class="category-item" href="category.html">
                                        <img src="images/cafe_furniture.jpeg" class="img-fluid" alt="Café Furniture">
                                        <h3 class="category-title">Café Furniture</h3>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="team-member text-center category-card">
                                    <a class="category-item" href="category.html">
                                        <img src="images/chairs.jpeg" class="img-fluid" alt="Chairs">
                                        <h3 class="category-title">Chairs</h3>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="team-member text-center category-card">
                                    <a class="category-item" href="category.html">
                                        <img src="images/nursery_furniture.jpeg" class="img-fluid"
                                            alt="Nursery Furniture">
                                        <h3 class="category-title">Nursery Furniture</h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second slide with 4 products -->
                    <div class="carousel-item">
                        <div class="row justify-content-center g-5">
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="team-member text-center category-card">
                                    <a class="category-item" href="category.html">
                                        <img src="images/gaming_furniture.png" class="img-fluid" alt="Gaming Furniture">
                                        <h3 class="category-title">Gaming Furniture</h3>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="team-member text-center category-card">
                                    <a class="category-item" href="category.html">
                                        <img src="images/outdoor_furniture.jpeg" class="img-fluid"
                                            alt="Outdoor Furniture">
                                        <h3 class="category-title">Outdoor Furniture</h3>
                                    </a>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="team-member text-center category-card">
                                    <a class="category-item" href="category.html">
                                        <img src="images/sofas.jpeg" class="img-fluid" alt="Sofas">
                                        <h3 class="category-title">Sofas</h3>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="team-member text-center category-card">
                                    <a class="category-item" href="category.html">
                                        <img src="images/tables_desks.jpeg" class="img-fluid" alt="Tables & Desks">
                                        <h3 class="category-title">Tables & Desks</h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="carousel-item">
                        <div class="row justify-content-center g-5">
                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="team-member text-center category-card">
                                    <a class="category-item" href="category.html">
                                        <img src="images/room_dividers.jpeg" class="img-fluid" alt="Room Dividers">
                                        <h3 class="category-title">Room Dividers</h3>
                                    </a>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-4 mb-4">
                                <div class="team-member text-center category-card">
                                    <a class="category-item" href="category.html">
                                        <img src="images/trolleys.jpeg" class="img-fluid" alt="Trolleys">
                                        <h3 class="category-title">Trolleys</h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-controls text-center mt-4">
                    <a href="#" class="carousel-control-prev" data-bs-target="#productCarousel"
                        data-bs-slide="prev">Previous</a>
                       <a > Previous </a> |  Next
                    <a href="#" class="carousel-control-next" data-bs-target="#productCarousel"
                        data-bs-slide="next">Next</a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Product Slider Section -->


    <!-- Start Why Choose Us Section -->
    <div class="why-choose-section" style="margin-top: -90px;">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-lg-6">
                    <h2 class="section-title">Why Choose Us</h2>
                    <p>At Nest & Buy, we are dedicated to providing premium-quality furniture with exceptional
                        service.
                        Our mission is to make your shopping experience as seamless and enjoyable as possible,
                        from
                        browsing to delivery.</p>

                    <div class="row my-5">
                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="images/truck.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>Fast &amp; Free Shipping</h3>
                                <p>We offer fast, reliable, and free shipping on all orders, ensuring your
                                    furniture
                                    arrives quickly and hassle-free.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="images/bag.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>Easy to Shop</h3>
                                <p>Our user-friendly website makes it easy to browse, select, and purchase the
                                    perfect
                                    pieces for your home.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="images/support.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>24/7 Support</h3>
                                <p>Our dedicated support team is available around the clock to answer any
                                    questions
                                    and
                                    provide assistance whenever you need it.</p>
                            </div>
                        </div>

                        <div class="col-6 col-md-6">
                            <div class="feature">
                                <div class="icon">
                                    <img src="images/return.svg" alt="Image" class="img-fluid">
                                </div>
                                <h3>Hassle-Free Returns</h3>
                                <p>Not satisfied with your purchase? No problem! We offer easy returns to ensure
                                    you're
                                    completely happy with your order.</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="img-wrap" style="margin-top: -20px;">
                        <img src="images/why-choose-us-img.jpg" alt="Image" class="img-fluid">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Why Choose Us Section -->

    <!-- awesome_shop start -->
    <section class="our_offer why-choose-section" style="margin-bottom: 70px;">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-4 col-md-4">
                    <div class="offer_img">
                        <img src="images/offer_img.png" alt="" style="max-width:400px;">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="offer_text ">
                        <h2>Weekly Sale on 60% Off All Products</h2>
                        <div class="date_countdown">
                            <div id="timer">
                                <div class="label">Days</div>
                                <div id="days" class="date"></div>
                                <div class="label">Hours</div>
                                <div id="hours" class="date"></div>
                                <div class="label">Minutes</div>
                                <div id="minutes" class="date"></div>
                                <div class="label">Seconds</div>
                                <div id="seconds" class="date"></div>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Enter email address"
                                aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <a href="#" class="input-group-text btn_2" id="basic-addon2">Book Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- awesome_shop end -->


    <!-- Start We Help Section -->
    <div class="we-help-section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-7 mb-5 mb-lg-0">
                    <div class="imgs-grid">
                        <div class="grid grid-1"><img src="images/img-grid-1.jpg" alt="Untree.co"></div>
                        <div class="grid grid-2"><img src="images/img-grid-2.jpg" alt="Untree.co"></div>
                        <div class="grid grid-3"><img src="images/img-grid-3.jpg" alt="Untree.co"></div>
                    </div>
                </div>
                <div class="col-lg-5 ps-lg-5">
                    <h2 class="section-title mb-4">We Help You Create Modern Interior Designs</h2>
                    <p>Transform your spaces with our expert design services. Our team combines creativity and
                        functionality to craft interiors that reflect your style and enhance your lifestyle.</p>

                    <ul class="list-unstyled custom-list my-4">
                        <li>Tailored design solutions for every room.</li>
                        <li style=" margin-left: 30px;">Expert guidance on material selection.</li>
                        <li>3D visualizations for your peace of mind.</li>
                        <li style=" margin-left: 30px;">Lighting design that enhances ambiance.</li>
                        <li>Seamless project management from start to finish.</li>
                        <li style=" margin-left: 30px;">Sustainable design options for eco-friendly living.</li>
                        <li>Customized furniture design to fit your space.</li>
                        <li style=" margin-left: 30px;">Space planning for maximum functionality.</li>
                        <li>Color consultation to create the perfect mood.</li>
                        <li style=" margin-left: 30px;">Renovation and remodeling services.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End We Help Section -->

    <!-- Start Popular Product -->
    <div class="popular-product product-section">
        <div class="container">
            <h2 class="section-title mb-5">Best Sellers</h2>
            <div class="row">

                <!-- Start Column 1 -->
                <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
                    <a class="product-item" href="cart.html">
                        <img src="images/product-1.png" class="img-fluid product-thumbnail">
                        <h3 class="product-title">Nordic Chair</h3>
                        <strong class="product-price">$50.00</strong>

                        <span class="icon-cross">
                            <img src="images/cross.svg" class="img-fluid">
                        </span>
                    </a>
                </div>

                <!-- End Column 1 -->

                <!-- Start Column 2 -->
                <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                    <a class="product-item" href="cart.html">
                        <img src="images/product-1.png" class="img-fluid product-thumbnail">
                        <h3 class="product-title">Nordic Chair</h3>
                        <strong class="product-price">$50.00</strong>

                        <span class="icon-cross">
                            <img src="images/cross.svg" class="img-fluid">
                        </span>
                    </a>
                </div>
                <!-- End Column 2 -->

                <!-- Start Column 3 -->
                <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                    <a class="product-item" href="cart.html">
                        <img src="images/product-2.png" class="img-fluid product-thumbnail">
                        <h3 class="product-title">Kruzo Aero Chair</h3>
                        <strong class="product-price">$78.00</strong>

                        <span class="icon-cross">
                            <img src="images/cross.svg" class="img-fluid">
                        </span>
                    </a>
                </div>
                <!-- End Column 3 -->

                <!-- Start Column 4 -->
                <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                    <a class="product-item" href="cart.html">
                        <img src="images/product-3.png" class="img-fluid product-thumbnail">
                        <h3 class="product-title">Ergonomic Chair</h3>
                        <strong class="product-price">$43.00</strong>

                        <span class="icon-cross">
                            <img src="images/cross.svg" class="img-fluid">
                        </span>
                    </a>
                </div>
                <!-- End Column 4 -->
            </div>
        </div>
    </div>
    <!-- End Popular Product -->

    <!-- Start Testimonial Slider -->
    <div class="testimonial-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                    <h2 class="section-title">Testimonials</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="testimonial-slider-wrap text-center">

                        <div id="testimonial-nav">
                            <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                            <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                        </div>

                        <div class="testimonial-slider">

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;Working with this team transformed my vision into
                                                    reality!
                                                    Their attention to detail and creative insights made the
                                                    entire
                                                    process enjoyable.&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="images/person-1.png" alt="Maria Jones" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Maria Jones</h3>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;The level of professionalism and commitment was
                                                    outstanding. I
                                                    highly recommend them for any interior design
                                                    project!&rdquo;
                                                </p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="images/person_2.jpg" alt="John Smith" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">John Smith</h3>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                            <div class="item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-8 mx-auto">

                                        <div class="testimonial-block text-center">
                                            <blockquote class="mb-5">
                                                <p>&ldquo;They took the time to understand my needs and
                                                    delivered
                                                    beyond
                                                    my expectations. Truly remarkable work!&rdquo;</p>
                                            </blockquote>

                                            <div class="author-info">
                                                <div class="author-pic">
                                                    <img src="images/person_4.jpg" alt="Sarah Lee" class="img-fluid">
                                                </div>
                                                <h3 class="font-weight-bold">Sarah Lee</h3>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- END item -->

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonial Slider -->


    <!-- Start Footer Section -->
    <footer class="footer-section">
        <div class="container relative" style="margin-bottom: -50px; margin-top: 50px;">

            <div class="sofa-img">
                <img src="images/sofa.png" alt="Image" class="img-fluid">
            </div>

            <div class="row">
                <div class="col-lg-8">
                    <div class="subscription-form">
                        <h3 class="d-flex align-items-center"><span class="me-1"><img src="images/envelope-outline.svg"
                                    alt="Image" class="img-fluid"></span><span>Subscribe to Newsletter</span></h3>

                        <form action="php/process_contact.php" method="POST" onsubmit="return validateSubscribeForm()"
                            class="row g-3">
                            <div class="col-auto">
                                <input type="text" class="form-control" placeholder="Enter your name" id="name"
                                    name="first_name" required>
                            </div>
                            <div class="col-auto">
                                <input type="email" class="form-control" placeholder="Enter your email" id="email"
                                    name="email" required>
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
                                <img src="images/Logo (2).png" style="max-width: 130px;">
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

    <script src="js/main.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/tiny-slider.js"></script>
    <script src="js/custom.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>