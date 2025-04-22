<?php include '../start.php';
if(isset($_POST['submit'])){
    unset($_SESSION['trader_id']);
    unset($_SESSION['trader_email']);
    unset($_SESSION['trader_username']);
    header('Location:../index.php');
}

?>
<div class="container w-100 d-flex align-items-center justify-content-center">
	<div class="row mt-5">
		<?php
		if (isset($_GET['msg'])) {
			$user_created_msg = $_GET['msg'];
			echo "<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 d-flex align-items-center justify-content-center' style='color:red;'>" . $user_created_msg . "
		            </div>";
		}
		?>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center mt-5">
			<a href="../index.php">
				<img src="../images/logo.png" class="img-fluid" style="width: 70px; height: 70px;">
			</a>
		</div>

        <div class="col-3"></div>
		<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-center mt-3 ">
			<form method="POST" action="new_trader_request.php">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12  align-items-center justify-content-center">
						<div class="h5"><?php echo  $_SESSION['trader_email'] ?></div>
                        <p class="h5">Request Sent</p>
                        <br><br>
                         <p>We've notified your Trader request to the admin. Please check email or check back here in future to see if you were approved</p>
					</div>
				</div>
		

			


			
				<div class="form-group row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center ml-2">
						<button type="submit" class="btn btn-success" name="submit">OK</button>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
						<a href="sign_up_trader.php" style="font-size: 16px">Wanna be one of Us? Sign Up Here</a>
					</div>
				</div>
			</form>
		</div>
        <div class="col-3"></div>
	</div>
</div>
<?php include '../end.php' ?>