<?php include 'start.php'; ?>
<?php include 'header.php'; ?>

<style>
    .signin-container {
        max-width: 500px;
        width: 100%;
        margin: 2rem auto;
        padding: 2rem;
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }
    .signin-logo {
        width: 80px;
        height: 80px;
        margin-bottom: 1.5rem;
    }
    .signin-title {
        color: #2c3e50;
        font-weight: 600;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    .form-control {
        border-radius: 5px;
        padding: 0.75rem;
        border: 1px solid #dee2e6;
    }
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
    }
    .btn-signin {
        background: #28a745;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 5px;
        border: none;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        max-width: 200px;
    }
    .btn-signin:hover {
        background: #218838;
        transform: translateY(-1px);
    }
    .signup-link {
        color: #007bff;
        text-decoration: none;
        font-size: 0.9rem;
        transition: color 0.3s ease;
    }
    .signup-link:hover {
        color: #0056b3;
        text-decoration: underline;
    }
    .remember-me {
        font-size: 0.9rem;
        color: #6c757d;
    }
    .form-check-input {
        margin-right: 0.5rem;
    }
    .alert {
        border-radius: 5px;
        margin-bottom: 1rem;
    }
    @media (max-width: 576px) {
        .signin-container {
            margin: 1rem;
            padding: 1.5rem;
        }
        .signin-logo {
            width: 60px;
            height: 60px;
        }
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-10 col-md-8 col-lg-6">
            <div class="signin-container">
                <?php
                if (isset($_GET['msg'])) {
                    $user_created_msg = $_GET['msg'];
                    echo "<div class='alert alert-danger text-center'>" . $user_created_msg . "</div>";
                }
                if (isset($_GET['message'])) {
                    $user_created_msg = $_GET['message'];
                    echo "<div class='alert alert-success text-center'>" . $user_created_msg . "</div>";
                }
                ?>
                
                <div class="text-center">
                    <a href="index.php">
                        <img src="images/logo.png" class="signin-logo" alt="Logo">
                    </a>
                    <h4 class="signin-title">Customer Sign In</h4>
                </div>

                <form method="POST" action="customer/customer_sign_in.php">
                    <div class="form-group">
                        <label for="inputEmail" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="inputEmail" 
                               placeholder="Enter your email" name="email" 
                               value="<?php if (isset($_COOKIE["email"])) { echo $_COOKIE["email"]; } ?>">
                    </div>

                    <div class="form-group">
                        <label for="inputPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="inputPassword" 
                               placeholder="Enter your password" name="password" 
                               value="<?php if (isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>">
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" 
                                   id="checkBox" <?php if (isset($_COOKIE["email"])) { ?> checked <?php } ?>>
                            <label class="form-check-label remember-me" for="checkBox">
                                Remember Me
                            </label>
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-signin" name="submit">Sign In</button>
                    </div>

                    <div class="text-center mt-3">
                        <a href="sign_up_customer.php" class="signup-link">New Member? Sign Up Here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<?php include 'end.php' ?>