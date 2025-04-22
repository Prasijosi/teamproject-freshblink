<?php include 'start.php';
if (!isset($_SESSION['username'])) {
	header('Location:sign_in_customer.php');
} elseif (isset($_SESSION['username'])) {


	$username_1 = $_SESSION['username'];
	@$profile_picture = $_SESSION['profile_picture'];

	include 'connection.php';

	$query = "select * from customer where username='$username_1'";

	$result = oci_parse($connection, $query);
	oci_execute($result);

	while ($row = oci_fetch_assoc($result)) {
		$full_name = ucwords($row['FULL_NAME']);
		$email = strtolower($row['EMAIL']);
	}
}
?>
<div class="container">
	<?php include 'header.php' ?>
	<?php
	if (isset($_GET['msg'])) {
		echo "<h4 style='text-align: center; color:green;'>" . $_GET['msg'] . "</h4>";
	}
	?>
	<div class="row mt-5">
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
					<a href="reviews.php" class="display-5">Product Reviews</a>
				</div>
			</div>
		</div>
		<div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 p-4 mt-5">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
					<a href="#" class="d-flex align-items-center justify-content-center">
						<img src="<?php echo $profile_picture ?>" alt="No Picture" class="img-fluid mt-4 img-thumbnail" style="width: 18vw; height: 12vw;">
					</a>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-4">
					<a href="customer_profile_picture.php" class="d-flex align-items-center justify-content-center h6">
						Change Profile Picture
					</a>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h5 mt-5 d-flex align-items-center justify-content-center">
					Account Information
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h6 mt-2 d-flex align-items-center justify-content-center">
					<?php echo $_SESSION['username']; ?>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h6 d-flex align-items-center justify-content-center">
					<?php echo $_SESSION['email']; ?>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h5">
					<div class="row ml-5 mt-3">
						<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
						</div>
						<div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2 d-flex align-items-center justify-content-center">
							<?php
								include('connection.php');
							$sql = "SELECT * from customer where USERNAME='$username_1'";

							

							$qry = oci_parse($connection, $sql);
							oci_execute($qry);
							while ($row = oci_fetch_assoc($qry)) {
								echo "<a href=customer_edit.php?id=" . $row['CUSTOMER_ID'] . ">Edit</a>  ";
							}

							?>
						</div>
						<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-flex align-items-center justify-content-start">
							<a href="change_password.php">Change Password</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h4 ml-4 mt-5">
			Recent Orders
		</div>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
			<table class="table mt-2">
				<thead class="thead-dark">
					<tr>
						<th class="text-center" style='width:25%;'>
							Product Image
						</th>
						<th class="text-center" style='width:25%;'>
							Order Date
						</th>
						<th class="text-center" style='width:25%;'>
							Order Number
						</th>
						<th class="text-center" style='width:25%;'>
							Product Price
						</th>
					</tr>
				</thead>
				<tbody>



					<?php
					include "connection.php";
					$un = $_SESSION['username'];
					$sql1 = "SELECT Customer_ID FROM customer WHERE Username = '$un'";


					$result1 = oci_parse($connection, $sql1);
					oci_execute($result1);

					while ($row = oci_fetch_array($result1)) {

						$cid = $row['CUSTOMER_ID'];

						$sql2 = "SELECT Order_Id, Order_Date, Quantity, Order_price, Customer_Id, Product_Id FROM orders WHERE Customer_Id='$cid'";

						$result2 = oci_parse($connection, $sql2);
						oci_execute($result2);

						while ($row = oci_fetch_array($result2)) {
							$oid = $row['ORDER_ID'];
							$odate = $row['ORDER_DATE'];
							$onumber = $row['ORDER_ID'];
							$oprice = $row['ORDER_PRICE'];


							$sql3 = "SELECT Product_Image FROM product INNER JOIN orders ON product.Product_Id=orders.Product_Id and orders.Order_Id='$oid'";

							$result3 = oci_parse($connection, $sql3);
							oci_execute($result3);

							while ($row = oci_fetch_array($result3)) {
								$pp = $row['PRODUCT_IMAGE'];
								echo "
										<tr class='border'>
										<td class='col text-center' style='width:25%;'>
							<a href='#'>
								<img src='$pp' class='img-fluid'>
							</a>
						</td>

										<td class='col border text-center' style='width:25%;'>
											$odate
										</td>
										<td class='col border text-center' style='width:25%;'>
											$onumber
										</td>
										<td class='col border text-center' style='width:25%;'>
											$oprice
				";
							}
						}
					}


					?>
					</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
</div>
<?php include 'footer.php';
include 'end.php';
?>