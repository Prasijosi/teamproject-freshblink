<?php include 'start.php';
if (!isset($_SESSION['username'])) {
	header('Location:sign_in_customer.php');
}
	$profile_picture = $_SESSION['profile_picture'];
?>
<div class="container">
	<?php include 'header.php';


	if (isset($_GET['msg'])) {
		echo "<h4 style='text-align: center; color:red;'>" . $_GET['msg'] . "</h4>";
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
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start h4">
					Edit Account Information
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start h5 mt-3">
					Account Information
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start">


					<?php

					if (isset($_GET['id'])) {

						$editid = $_GET['id'];
						$sql = "SELECT * FROM customer WHERE Customer_ID='$editid'";
						include('connection.php');

						$qry = oci_parse($connection, $sql);
						oci_execute($qry);


						if ($qry) {
							while ($r = oci_fetch_assoc($qry)) {
								$cid = $r['CUSTOMER_ID'];
								$uname = $r['USERNAME'];
								$fname = $r['FULL_NAME'];
								$email = $r['EMAIL'];
								$password = $r['PASSWORD'];
								$address = $r['ADDRESS'];
								$phone = $r['CONTACT_NUMBER'];
								$gender = $r['SEX'];
								$dob = $r['DATE_OF_BIRTH'];
							}
						}
					}


					?>
					<form class="mt-2" method="POST" action="edituserprocess.php">
						<div class="form-group mt-3">

							<input type="hidden" name="cid" value="<?php echo $cid; ?>" />
							<label for="inputUsername">Username</label>
							<input type="text" class="form-control" id="inputUsername" name="uname" placeholder="Username" value="<?php echo $uname; ?>">
						</div>
						<div class="form-group">
							<label for="inputfullName">Full Name</label>
							<input type="text" class="form-control" id="inputfullName" name="fname" placeholder="Full Name" value="<?php echo $fname; ?>">
						</div>
						<div class="form-group row">
							<label for="inputEmail" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Email</label>
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email Address" value="<?php echo $email; ?>">
							</div>
						</div>
						<div class="form-group">
							<label for="inputAddress">Address</label>
							<input type="text" class="form-control" id="inputAddress" name="address" placeholder="Address" value="<?php echo $address; ?>">
						</div>
						<div class="form-group">
							<label for="inputphoneNumber">Phone Number</label>
							<input type="text" class="form-control" id="inputphoneNumber" name="phone" placeholder="Phone Number" value="<?php echo $phone; ?>">
						</div>
						<fieldset class="form-group">
							<div class="row">
								<legend class="col-form-label col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 pt-0">Gender</legend>
								<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
									<div class="form-check">
										<input class="form-check-input" type="radio" name="gender" id="genderRadio" value="Male" <?php if ($gender == "Male") {
																																		echo "checked";
																																	} ?> checked style="width: 1vw; height: 1vw;">
										<label class="form-check-label" for="genderRadio">
											Male
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="gender" id="genderRadio1" value="Female" <?php if ($gender == "Female") {
																																		echo "checked";
																																	} ?> style="width: 1vw; height: 1vw;">
										<label class="form-check-label" for="genderRadio1">
											Female
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="gender" id="genderRadio2" value="Other" <?php if ($gender == "Other") {
																																		echo "checked";
																																	} ?> style="width: 1vw; height: 1vw;">
										<label class="form-check-label" for="genderRadio2">
											Other
										</label>
									</div>
								</div>
							</div>
						</fieldset>
						<div class="form-group row">
							<label for="inputDOB" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Date of Birth</label>
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<input type="date" class="form-control" id="inputDOB" name="dob" value="<?php echo $dob; ?>">
							</div>
						</div>
						<div class="form-group row">
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center ml-2">
								<button type="submit" class="btn btn-success" name="update">Update</button>
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