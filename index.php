<?php include 'start.php'; ?>
<div class="container-fluid">
    <section class="container">
        <?php include 'header.php';
        if (isset($_GET['msg'])) {
            $user_created_msg = $_GET['msg'];
            echo "
                    <div class='row'>
                        <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 d-flex align-items-center justify-content-center' style='text-align: center; color:green;'>" . $user_created_msg . "
                        </div>
                    </div>";
        }
        ?>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100 img-fluid" src="images/image_slider_01.jpg" alt="First Slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100 img-fluid" src="images/image_slider_02.jpg" alt="Second Slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100 img-fluid" src="images/image_slider_03.jpg" alt="Third Slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <p class="h4">Explore Popular Categories</p>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <img src="images/bakery.png" class="img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                <br>
                <p class="h6 mt-2 text-center">
                    <a href="search_product.php?search_Txt=&search_Cat=Bakery">
                        Bakery
                    </a>
                </p>
            </div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <img src="images/butcher.png" class="img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                <p class="h6 mt-2 text-center">
                    <a href="search_product.php?search_Txt=&search_Cat=Butcher">
                        Butcher
                    </a>
                </p>
            </div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <img src="images/delicatessen.png" class="img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                <p class="h6 mt-2 text-center">
                    <a href="search_product.php?search_Txt=&search_Cat=Delicatesssen">
                        Delicatessen
                    </a>
                </p>
            </div>
            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <img src="images/fishmonger.png" class="img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                <p class="h6 mt-2 text-center">
                    <a href="search_product.php?search_Txt=&search_Cat=Fishmonger">
                        Fish Monger
                    </a>
                </p>
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <img src="images/greengrocery.png" class="img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                <p class="h6 mt-2 text-center">
                    <a href="search_product.php?search_Txt=&search_Cat=Greengrocery">
                        Green Grocery
                    </a>
                </p>
            </div>
        </div>
        <div class="row border border-secondary my-5">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-4">
                <h6> New Arrivals | <a href="#">See All</a></h6>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-4 text-center">
                <div id="carouselExampleControls1" class="carousel slide p-4" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="row">
                                <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/bakery_03.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1001">
                                            Cake
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/bakery_04.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1002">
                                            Donught
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/bakery_01.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1003">
                                            Wholegrain Bread
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/bakery_02.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1004">
                                            Cookies
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/butcher_02.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1005">
                                            Mutton
                                        </a>
                                    </p>
                                </div>
                                <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row mt-2">
                                <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/butcher_03.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1006">
                                            Chicken
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/butcher_01.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1007">
                                            Pork
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/butcher_04.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1008">
                                            Buff Meat
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/greengrocery_01.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1008">
                                            Brocolli
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/greengrocery_02.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1010">
                                            Spinach
                                        </a>
                                    </p>
                                </div>
                                <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="row mt-2">
                                <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/greengrocery_03.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1011">
                                            Apple
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/greengrocery_04.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1012">
                                            Avocado
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/fishmonger_01.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1013">
                                            Rohu Fish
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/fishmonger_02.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1014">
                                            Cat Fish
                                        </a>
                                    </p>
                                </div>
                                <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                                    <img src="images/fishmonger_03.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1015">
                                            Prawn
                                        </a>
                                    </p>
                                </div>
                                <div class="col-1 col-sm-1 col-md-1 col-lg-1 col-xl-1">
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls1" data-slide="prev">
                        <span class="carousel-control-prev-icon rounded-circle" style="background-color: #1A1110; position: relative; right: 2vw; bottom: 0.5vw;"></span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls1" data-slide="next">
                        <span class="carousel-control-next-icon rounded-circle" style="background-color: #1A1110; position: relative; left: 2vw; bottom: 0.5vw;"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row border border-secondary my-5 text-center">
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 p-5" style="border-right-style: groove;">
                <div class="row" style="position: relative; top:0.2vw;">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <div class="h2">
                            GET 25% OFF
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
                        <img src="images/discount.png" class="img-fluid" style="width:10vw; height:10vw;">
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
                        <a href="#">
                            <button type="button" class="btn btn-success mt-4">View More</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-8 col-sm-8 col-md-8 col-xl-8 col-lg-8 text-center my-4">
                <div id="carouselExampleControls2" class="carousel slide mt-5 p-5" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active my-3">
                            <div class="row">
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <img src="images/fishmonger_04.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1016">
                                            Crab
                                        </a>
                                    </p>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <img src="images/delicatessen_01.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1017">
                                            Steaks
                                        </a>
                                    </p>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <img src="images/delicatessen_02.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1018">
                                            Cheese
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item my-3">
                            <div class="row">
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <img src="images/delicatessen_03.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1019">
                                            Hotdog
                                        </a>
                                    </p>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <img src="images/delicatessen_04.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1020">
                                            Sausage
                                        </a>
                                    </p>
                                </div>
                                <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <img src="images/bakery_03.png" alt="Products" class="rounded-0 img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                                    <p class="h6 mt-2">
                                        <a href="product_details.php?product_id=1001">
                                            Cake
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls2" data-slide="prev">
                        <span class="carousel-control-prev-icon rounded-circle" style="background-color: #1A1110; position:relative; right:4vw;"></span>
                    </a>
                    <a class="carousel-control-next d-flex align-items-center" href="#carouselExampleControls2" data-slide="next">
                        <span class="carousel-control-next-icon rounded-circle" style="background-color: #1A1110; position:relative; left:4vw;"></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row text-center border border-secondary p-5">
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3" style="border-right-style: groove;">
                <img src="images/secure.png" class="img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                <div class="h5 mt-3">100% Secure Payments</div>
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3" style="border-right-style: groove;">
                <img src="images/trust.png" class="img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                <div class="h5 mt-3">TrustPay</div>
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3" style="border-right-style: groove;">
                <img src="images/verified.png" class="img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                <div class="h5 mt-3">Verified Seller</div>
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <img src="images/customer_service.png" class="img-fluid" style="width:6.588579795021962vw; height:6.588579795021962vw;">
                <div class="h5 mt-3">Excellent Customer Service</div>
            </div>
        </div>
    </section>
</div>
<?php include 'footer.php';
include 'end.php'; ?>