<?php include 'start.php';
if (!isset($_SESSION['username'])) {
	header('Location:sign_in_customer.php');
}
$profile_picture = $_SESSION['profile_picture'];
?>
<div class="container">
	<?php include 'header.php';
	if (isset($_GET['msg'])) {
		$msg = $_GET['msg'];
		echo "<script type='text/javascript'>alert('" . $msg . "')</script>";
	} else {
		echo "";
	}
	?>
	<div class="row mt-5">
		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 p-4 mt-5">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<a href="#" class="d-flex align-items-center justify-content-center">
						<img src="<?php echo $profile_picture ?>" class="img-fluid">
					</a>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
					<a href="customer_profile_picture.php" class="d-flex align-items-center justify-content-center h6">
						Change Profile Picture
					</a>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start mt-4 h3">
					My Account
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start h5 mt-2">
					<a href="customer_profile.php" class="display-5">Dashboard</a>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start h5 mt-2">
					<a href="orders.php" class="display-5">Orders</a>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start h5 mt-2">
					<a href="#" class="display-5">Product Reviews</a>
				</div>
			</div>
		</div>
		<div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 p-4 mt-5 border">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center h4">
					Change your Password
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
					<form class="mt-2" method="POST" action="change_password_process.php">
						<div class="form-group row">
							<label for="inputPassword" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Password</label>
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<input type="password" class="form-control" id="inputPassword" placeholder="Enter your Password" name="password">
							</div>
						</div>
						<div class="form-group row">
							<label for="inputPassword1" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Confirm your Password</label>
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<input type="password" class="form-control" id="inputPassword1" placeholder="Re-enter your Password" name="repassword">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center ml-2">
								<button type="submit" class="btn btn-success" name="submit">Save Changes</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php';
include 'end.php';
?>