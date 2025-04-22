<?php
include 'start.php';

if (isset($_SESSION['username'])) {
	@$customer_id = $_SESSION['customer_id'];
	@$profile_picture = $_SESSION['profile_picture'];

	if (isset($_POST['submit'])) {

		$Profile_Image = $_FILES['Profile_Image'];
		$filename = $Profile_Image['name'];
		$fileerror = $Profile_Image['error'];
		$filetmp = $Profile_Image['tmp_name'];

		$imgext = explode('.', $filename);
		$filecheck = strtolower(end($imgext));

		$fileextstored = array('png', 'jpg', 'jpeg');

		if (in_array($filecheck, $fileextstored)) {
			$destinationfile = 'images/customer/' . $filename;
			move_uploaded_file($filetmp, $destinationfile);

			include 'connection.php';

			$sql = "UPDATE customer SET Profile_Image = '$destinationfile' where Customer_ID='$customer_id'";

			$query = oci_parse($connection, $sql);
			oci_execute($query);
			unset( $_SESSION['profile_picture']); //


			include('connection.php');
     
			$sql = "SELECT * FROM customer where  Customer_ID='$customer_id'";
			$qry = oci_parse($connection, $sql);
			oci_execute($qry);
	
			while ($r = oci_fetch_array($qry)) {
				$_SESSION['profile_picture']=$r['PROFILE_IMAGE'];
	
			}


			header('Location:customer_profile.php'); //


		} else {
			echo "
				<div class='row border p-4 mt-4'> 
	        	<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center' style='color:red;'>";
			echo "Error while Uploading!</div></div>";
		}
	}
} else {
	header('Location:sign_in_customer.php');
	exit();
}
?>
<div class="container">
	<?php include 'header.php'; ?>
	<br />
	<div class="row">
		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 p-4 mt-5">
			<div class="row">
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
			<form action="#" method="POST" enctype="multipart/form-data">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
						<a href="#" class="d-flex align-items-center justify-content-center">
							<img src="<?php echo $profile_picture ?>" class="img-fluid mt-4 img-thumbnail" style="width: 18vw; height: 12vw;" alt="No Picture">
						</a>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
					<div class="form-group d-flex align-items-center justify-content-center">
						<!-- <label for="ProductImage" class="h6 text-center mt-5">Choose your picture </label> -->
						<input type="file" name="Profile_Image" id="ProductImage" class="form-control w-75 mt-5">
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
					<input type="submit" name="submit" value="Submit" class="btn btn-success my-4" />
				</div>
			</form>
		</div>
	</div>
</div>
<?php
include 'footer.php';
include 'end.php';
?>