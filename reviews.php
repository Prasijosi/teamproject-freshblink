<?php include 'start.php';
	
	$pid = '';

if (!isset($_SESSION['username'])) {
	header('Location:sign_in_customer.php');
}

if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
	echo "<script>alert('" . $msg . "')</script>";
}
?>
<style type="text/css">
	.fa-star {
		color: orange;
		font-size: 1.5vw;
	}
</style>
<div class="container">
	<?php include 'header.php' ?>
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
					<a href="#" class="display-5">Product Reviews</a>
				</div>
			</div>
		</div>
		<div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 mt-5 border">
			<div class="row mt-4">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start h3 mt-4">
					My Reviews
				</div>

				<?php
				include 'connection.php';
				$username = $_SESSION['username'];

				echo " 	<div class='col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center justify-content-start h5 mt-2'>
					<button class='btn btn-success'>To be Reviewed</button>
				</div>
				<div class='col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 d-flex align-items-center justify-content-start'>
				</div> ";


				$sql1 = "SELECT * from customer where username= '$username'";
				$result1 = oci_parse($connection, $sql1);
				oci_execute($result1);

				while ($row = oci_fetch_assoc($result1)) {
					$cid = $row['CUSTOMER_ID'];
					$sql2 = " SELECT * FROM orders WHERE Customer_Id='$cid'";
					$result2 = oci_parse($connection, $sql2);
					oci_execute($result2);

					while ($row = oci_fetch_assoc($result2)) {
						include 'connection.php';
						$pid = $row['PRODUCT_ID'];

					}
						$sql3 = " SELECT * FROM review WHERE Customer_Id='$cid' and Product_Id='$pid'";
						$result3 = oci_parse($connection, $sql3);
						oci_execute($result3);

						$count2 = oci_fetch_all($result3, $connection);
						oci_execute($result3);

						if ($count2 == 0) {

							//echo "reviewd";
							include 'connection.php';
							$sql4 = "SELECT * FROM orders INNER JOIN product ON orders.PRODUCT_ID=product.PRODUCT_ID inner join shop on shop.shop_id=product.shop_id WHERE Customer_Id='$cid'";
							$result4 = oci_parse($connection, $sql4);
							oci_execute($result4);

							while ($row = oci_fetch_assoc($result4)) {
								$productid = $row['PRODUCT_ID'];
								$odate = $row['ORDER_DATE'];
								$pname = $row['PRODUCT_NAME'];
								$pimage = $row['PRODUCT_IMAGE'];
								$sid = $row['SHOP_ID'];
								$sname = $row['SHOP_NAME'];

								

							

									
										

										echo "	<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start'>
				<table class='table mt-2'>
					<thead class='thead-dark'>
						<tr>
							<th>
								Purchased On : <input type='text' class='h6' name='order_No' value='$odate' style='background-color:#212529; border: none; color: white;' disabled>
							</th>
							<th>
							</th>
							<th>
							</th>
						</tr>
					</thead>
					<tbody>
						<tr class='border'>
							<td class='col text-center' style='width:4vw;'>
								<a href='#'>
									<img src='$pimage' class='img-fluid'>
								</a>
							</td>
						<td class='col border text-center'>
						$pname
						</td>
						<td class='col text-center h6'>
							Sold By : 
							<br>
							$sname
							<br>
							<button type='btn btn-success'><a href='review_product.php?product_id=$pid'>Review</a></button>
						</td>
						</tr>
					</tbody>
				</table>
			</div>
";
									
								
							}



						}
						
						else
						{
							
						}
					
				}
				?>


				<?php
				include 'connection.php';
				$username = $_SESSION['username'];

				$sql1 = "select * from customer where username= '$username'";
				$result1 = oci_parse($connection, $sql1);
				oci_execute($result1);

				while ($row = oci_fetch_assoc($result1)) {
					$cid = $row['CUSTOMER_ID'];
					$sql2 = " SELECT Review_Id FROM review WHERE Customer_Id='$cid'";
					$result2 = oci_parse($connection, $sql2);
					oci_execute($result2);

					$count1 = oci_fetch_all($result2, $connection);
					oci_execute($result2);
					echo " 
					<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start h4 mt-5'>
					History ($count1)
				</div>
				";
				}

				?>

				<?php
				include 'connection.php';
				$username = $_SESSION['username'];

				$sql1 = "SELECT * from customer where username= '$username'";

				$result = oci_parse($connection, $sql1);
				oci_execute($result);

				while ($row = oci_fetch_assoc($result)) {
					$cid = $row['CUSTOMER_ID'];
					$sql2 = " SELECT * FROM review WHERE Customer_Id='$cid'";
					$result2 = oci_parse($connection, $sql2);
					oci_execute($result2);

					while ($row = oci_fetch_assoc($result2)) {
						$rdate = $row['DATES'];
						$desc = $row['DESCRIPTION'];
						$rating2 = $row['RATING'];
						$rid = $row['REVIEW_ID'];
						$pid = $row['PRODUCT_ID'];


						$sql3 = " SELECT * FROM product WHERE Product_Id='$pid'";
						$result3 = oci_parse($connection, $sql3);
						oci_execute($result3);

						while ($row = oci_fetch_assoc($result3)) {
							$pname = $row['PRODUCT_NAME'];
							$sid = $row['SHOP_ID'];
							$pimage = $row['PRODUCT_IMAGE'];

							$sql4 = " SELECT * FROM shop WHERE Shop_Id='$sid'";
							$result4 = oci_parse($connection, $sql4);
							oci_execute($result4);

							while ($row = oci_fetch_assoc($result4)) {
								$sname = $row['SHOP_NAME'];

								echo "<table class='table mt-2'>
							<thead class='thead-dark'>
								<tr>
									<th>
										Reviewed On : <br><input type='text' class='h6' name='order_No' value='$rdate' style='background-color:#212529; border: none; color: white;' disabled>
									</th>
								</tr>
							</thead>
						</table>
						<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start mb-5'>
							<div class='row h6'>
								<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h5'>
									Your product rating & review : 
								</div>";








								echo " <div class='col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 mt-2'>
								<img src='$pimage' class='img-fluid'>
							</div>
							<div class='col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 mt-2 h6 d-flex align-items-center justify-content-start'>
								$pname
							</div>
						</div>
					</div>
					<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 border-left'>
						<div class='row'>
							<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h5 d-flex align-items-center justify-content-center'>
								Sold by : $sname
							</div>
							<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h5 d-flex align-items-center justify-content-center'>
								";
								include 'condition_checker/rating_conditional_2.php';
								echo "
							</div>
							<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center'>
								<form class='mt-2' method='POST' action='#' class='d-flex align-items-center justify-content-center'>
									<div class='form-group'>
									  <textarea>$desc</textarea><br>
									  
									</div>
								</form>
							</div>
							<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center h6 mt-2'>
								Approved Status
							</div>
						</div>
					</div>
					";
							}
						}
					}
				}






				?>



				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-4">
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
include 'end.php' ?>