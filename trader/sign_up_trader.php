<?php include '../start.php'; ?>
<div class="container w-100 d-flex align-items-center justify-content-center">
    <div class="row mt-3">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center mt-5">
            <a href="index.php">
                <img src="../images/logo.png" class="img-fluid" style="width: 70px; height: 70px;">
            </a>
        </div>
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center mt-3">
            <form class="border p-5 mt-2" method="POST" action="trader_sign_up.php">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
                        <div class="h4 mt-1">Trader Registration</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
                        <div class="h6 mt-3">Welcome! You are one step away to sell on goCart
                        </div>

                    </div>
                </div>
                <?php
                if (isset($_SESSION['error'])) {
                    echo "<p style='color:red; text-align:center'>" . $_SESSION['error'] . "</p> ";
                }
                ?>
                <div class="form-group mt-3">
                    <label for="inputUsername">Username</label>
                    <input type="text" class="form-control" id="inputUsername" placeholder="Username" name="uname" value="<?php if (isset($_GET['uname'])) {
                                                                                                                                echo $_GET['uname'];
                                                                                                                            } ?>">
                </div>
                <div class="form-group">
                    <label for="inputfullName">Full Name</label>
                    <input type="text" class="form-control" id="inputfullName" placeholder="Full Name" name="fname" value="<?php if (isset($_GET['fname'])) {
                                                                                                                                echo $_GET['fname'];
                                                                                                                            } ?>">
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Email</label>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                        <input type="email" class="form-control" id="inputEmail" placeholder="Email Address" name="email" value="<?php if (isset($_GET['email'])) {
                                                                                                                                        echo $_GET['email'];
                                                                                                                                    } ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Shop Name</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Shop Name" name="shopname" value="<?php if (isset($_GET['shopname'])) {
                                                                                                                                    echo $_GET['shopname'];
                                                                                                                                } ?>">
                    <div class="mb-3 mt-3">
                        <label for="exampleFormControlTextarea1" class="form-label">Shop Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="what">
                    <?php if (isset($_GET['what'])) {
                        echo $_GET['what'];
                    } ?>
                    </textarea>
                    </div>

                    <div class="form-group row">
                        <label for="inputPassword" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Password</label>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <input type="password" class="form-control" id="inputPassword" placeholder="Enter your Password" name="password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword1" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Re-enter your Password</label>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <input type="password" class="form-control" id="inputPassword1" placeholder="Re-enter your Password" name="repassword">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="checkbox" name="cb">
                                <label class="form-check-label" for="checkBox">
                                    <span>By creating an account, you agree to goCart Privacy <br>Notice and Terms of Use.</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center ml-2">
                            <button type="submit" class="btn btn-success" name="submit">Sign Up</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
                            <a href="sign_in_trader.php" style="font-size: 16px;">Have an account? Sign In</a>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<?php include '../end.php' ?>