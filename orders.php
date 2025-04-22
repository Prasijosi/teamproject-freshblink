<?php include 'start.php';
if (!isset($_SESSION['username'])) {
	header('Location:sign_in_customer.php');
}
@$profile_picture = $_SESSION['profile_picture'];
?>
<div class="container">
	<?php include 'header.php'; ?>
	<div class="row mt-5">
		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 p-4 mt-5">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<a href="#" class="d-flex align-items-center justify-content-center">
						<img src="<?php echo $profile_picture ?>" alt="No Picture" class="img-fluid">
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
					<a href="#" class="display-5">Orders</a>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start h5 mt-2">
					<a href="reviews.php" class="display-5">Product Reviews</a>
				</div>
			</div>
		</div>
		<div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 p-4 mt-5 border">
			<div class="row p-2">
				<table class="table mt-2">
					<thead class="thead-dark">
						<tr>
							<th class="text-center h5">
								My Orders
								<!-- <select style="background-color:#212529; color: white;" name="sort">
										<option value="Last_7_Days" style="background-color:#212529; color: white;">Last 7 Days</option>
										<option value="Lifetime" style="background-color:#212529; color: white;">Lifetime</option>
									</select>
									<input type="submit" name="submit" class="btn btn-secondary" value="Go" style="background-color: #212529;"> -->
							</th>
						</tr>
					</thead>
				</table>
				<?php
				include 'connection.php';

				$customer_id = $_SESSION['customer_id'];

				$sql = "SELECT * FROM orders o, product p, customer c where '$customer_id' = c.Customer_Id and c.Customer_Id = o.Customer_Id and o.Product_Id = p.Product_ID";

				$result = oci_parse($connection, $sql);
				oci_execute($result);

				while ($row = oci_fetch_assoc($result)) {
					$order_no = $row['ORDER_ID'];
					$order_date = $row['ORDER_DATE'];
					$qty = $row['QUANTITY'];
					$order_status = $row['DELIVERY_STATUS'];
					$Product_Image = $row['PRODUCT_IMAGE'];
					$product_name = $row['PRODUCT_NAME'];
					echo '<table class="table mt-2">
					<thead class="thead-dark">
						<tr>
							<th>
								Order Number<input type="text" class="h6" name="order_No" value="' . $order_no . '" style="background-color:#212529; border: none; color: white;" disabled><br>
								
							</th>
							<th>
							</th>
							<th>
								<span style="background-color: #212529; color: #212529;">Quantity</span>
							</th>
							<th class="text-center">
							Order Date<input type="text" class="h6 text-center" name="order_Date" value="' . $order_date . '" style="background-color:#212529; border: none; color: white;" disabled><br>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr class="border">
							<td class="col text-center" style="width:25%;">
								<a href="#">
									<img src="' . $Product_Image . '" class="img-fluid">
								</a>
							</td>
						<td class="col border text-center" style="width:25%;">
							' . $product_name . '
						</td>
						<td class="col border text-center" style="width:25%;">
							Qty : ' . $qty . '
						</td>
						<td class="col border text-center" style="width:25%;">
							';
					if ($order_status == 0) {
						echo "Order Pending";
					} else {
						echo "Order Delivered";
					}
					echo "" . '
						</td>
						</tr>
					</tbody>
				</table>';
				}

				?>

				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="row">
						<div class="col-6"></div>
						<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-end">
							<a href="#"><i class="fas fa-chevron-circle-left"></i></a>
							<a href="#" class="display-5 ml-2"><u>1</u></a>
							<a href="#" class="display-5 ml-2">2</a>
							<a href="#"><i class="fas fa-chevron-circle-right ml-2"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include 'footer.php';
include 'end.php'; ?>