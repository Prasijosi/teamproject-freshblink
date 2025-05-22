<?php

$c = 0;

if (isset($_SESSION['cart'])) {
    $c = count($_SESSION['cart']);  //for displaying how many items are there in cart
}

?>

<header class="py-2" style="background: #fff;">
    <div class="">
        <div class="row align-items-center">
            <!-- Logo -->
            <div class="col-12 col-md-2 d-flex align-items-center mb-2 mb-md-0">
                <a href="index.php" class="d-flex align-items-center">
                    <img src="images/logo.png" alt="FreshBlink" style="height:40px;">
                    <span class="ml-2 font-weight-bold" style="color:#4BB543;font-size:0.9rem;">FreshBlink</span>
                </a>
            </div>
            <!-- Search Bar -->
            <div class="col-12 col-md-6 mb-2 mb-md-0">
                <form action="search_product.php" method="POST">
                    <div class="input-group" style="background:#f3faef; border-radius:6px;">
                        <input id="txtkey" type="text" name="search_Txt" class="form-control border-0" placeholder="Search products" style="background:transparent;">
                        <div class="input-group-append">
                            <button id="btn-search" class="btn" type="submit" style="background:#4BB543;" name="submit_search">
                                <i class="fas fa-search" style="color:#fff; background:#4BB543;"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Icons and Auth -->
            <div class="col-12 col-md-4 d-flex justify-content-md-end justify-content-center align-items-center">
                <a href="cart.php" class="d-flex align-items-center mx-2 text-dark" style="text-decoration:none;">
                    <i class="fas fa-shopping-cart" style="font-size:1.3rem;"></i>
                    <span class="ml-1 d-none d-md-inline">
                        Cart<?php if ($c > 0) echo " ($c)"; ?>
                    </span>
                </a>
                <?php if (!isset($_SESSION['username'])): ?>
                    <a href="sign_up_customer.php" class="mx-2 text-dark d-none d-md-inline" style="text-decoration:none;">Register</a>
                    <a href="sign_in_customer.php" class="btn btn-success ml-2 px-4 py-1" style="font-weight:500;">Login</a>
                <?php else: ?>
                    <div class="dropdown mx-2">
                        <button class="btn btn-link dropdown-toggle text-dark" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration:none;">
                            <span>Welcome, <?php echo ucfirst($_SESSION['username']); ?></span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="customer_profile.php">My Profile</a>
                            <a class="dropdown-item" href="orders.php">My Orders</a>
                            <a class="dropdown-item" href="reviews.php">My Reviews</a>
                            <a class="dropdown-item" href="session_destroy.php">Log Out</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>