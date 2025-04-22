<?php

$c = 0;

if (isset($_SESSION['cart'])) {
    $c = count($_SESSION['cart']);  //for displaying how many items are there in cart
}

?>

<header class="container w-100 text-center">
    <div class="row mt-2">
        <div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
            <span class="h6 text-center d-flex align-items-center justify-content-start"></span>
        </div>
        <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
            <div class="h6 text-center d-flex align-items-center justify-content-end">
                <i class="fas fa-user"></i>
                <?php
                if (!isset($_SESSION['username'])) {
                    echo "<a href='sign_in_customer.php'><span class='ml-2'>Sign In</span></a>";
                } else {
                    @$username = ucfirst($_SESSION['username']);
                    echo "<div class='dropdown'>
                          <button class='btn  dropdown-toggle' type='button' style='border:none;' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <a href='customer_profile.php'><span class='ml-2'> Welcome, " . $username . "</span></a>
                          </button>
                          <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                            <a class='dropdown-item' href='customer_profile.php'>My Profile</a>
                            <a class='dropdown-item' href='orders.php'>My Orders</a>
                            <a class='dropdown-item' href='reviews.php'>My Reviews</a>
                            <a class='dropdown-item' href='session_destroy.php'>Log Out</a>
                          </div>
                        </div>";
                }
                ?>
            </div>
        </div>
        <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
            <div class="h6 text-center d-flex align-items-center justify-content-end">
                <?php
                if (!isset($_SESSION['username'])) {
                    echo "<i class='fas fa-shopping-cart'></i>
                        <a href='cart.php'><span class='ml-2'>Cart</span></a>";
                } elseif (isset($_SESSION['username'])) {
                    echo "
                        <a href='cart.php'><span class='ml-2 btn btn-outline-success'>Cart ($c)</span></a>";
                }
                ?>

            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9"></div>
        <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <div class="h6 text-center d-flex align-items-center justify-content-end">
                <i class="fas fa-warehouse"></i>
                <a href="trader/sign_in_trader.php"><span class="ml-3" style="font-size: 1vw;">Sell on goCart</span></a>
            </div>
        </div>
    </div>
    <div class="row my-4 d-flex align-items-center justify-content-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <a href="index.php">
                <img src="images/logo.png" class="img-fluid" style="width: 70px; height: 70px;">
            </a>
        </div>
    </div>
    <div class="row my-2 d-flex align-items-center justify-content-center">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xl-12">
            <i>"We’re in Business to Improve Lives"</i>
        </div>
    </div>
    <form action="search_product.php" method="GET">
        <div class="row my-4 d-flex align-items-center justify-content-center">
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <div class="form-horizontal">
                    <div class="input-group">

                        <input id="txtkey" type="text" name="search_Txt" class="form-control" placeholder="Search" aria-describedby="ddlsearch">

                        <div class="ddl-select input-group-btn">
                            <select id="ddlsearch" class="selectpicker form-control" data-style="btn-primary" name="search_Cat">
                                <option value="all">All Categories</option>
                                <option value="Bakery">Bakery</option>
                                <option value="Butcher">Butcher</option>
                                <option value="Greengrocery">Greengrocery</option>
                                <option value="Fishmonger">Fishmonger</option>
                                <option value="Delicatesssen">Delicatesssen</option>
                            </select>
                        </div>
                        <span class="input-group-btn">
                            <button id="btn-search" class="btn btn-info" type="submit"><i class="fas fa-search" style="background-color: #17a2b8;"></i></button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </form>
</header>