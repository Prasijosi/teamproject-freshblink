<?php include 'start.php';
include 'connection.php';
if (isset($_GET['product_id'])) {
	$product_id = $_GET['product_id'];

	$query = "select * from product,shop where product_id = '$product_id' and product.shop_id = shop.shop_id";

	$result = oci_parse($connection, $query);
	oci_execute($result);

	while ($row = oci_fetch_assoc($result)) {
		$product_type = $row['PRODUCT_TYPE'];
		$product_name = $row['PRODUCT_NAME'];
		$product_price = $row['PRODUCT_PRICE'];
		$product_details = $row['PRODUCT_DETAILS'];
		$stock = $row['STOCK'];
		$product_image = $row['PRODUCT_IMAGE'];
		$shop_id = $row['SHOP_ID'];
		$shop_name = $row['SHOP_NAME'];
	}
} else {
	header('Location:index.php');
	exit();
}
?>
<style type="text/css">
	.fa-star {
		color: orange;
		font-size: 1.5vw;
	}
</style>
<div class="container">
	<?php include 'header.php'; ?>
	<?php if (isset($_POST['addtoCart'])) {
		$qty = $_POST['quantity'];
		if (!isset($_SESSION['username'])) {
			echo "
			<div class='row border p-4 mt-4'> 
        	<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center' style='color:red;'>";
			echo "Please<a href='sign_in_customer.php' style='color:red;' class='mx-1'>Sign-In</a>to place an Order!
			</div></div>";
		}
	} ?>
	<form action="manage_cart.php" method="POST" class="border my-5">
		<div class="row mt-5">
			<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-center mt-5">
				<div class="row w-50">
					<img src="<?php echo $product_image; ?>" class="img-fluid w-100" alt="Products">
				</div>
			</div>
			<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-5">
				<div class="row h3">
					<?php echo $product_name; ?>
				</div>
				<div class="row h5 mt-4">Rating</div>
				<div class="row mt-2">
					<?php include 'condition_checker/rating_conditional.php'; ?>
				</div>
				<div class="row mt-4">
					<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start">
						<a href="search_product.php?search_Cat=<?php echo $shop_name; ?>" class="h6">Sold By : <?php echo $shop_name; ?></a>
					</div>
					<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 border-left -flex align-items-center justify-content-start">
						<a href="search_product.php?search_Cat=<?php echo $shop_name; ?>" class="h6">More Products from <?php echo $shop_name; ?></a>
					</div>
				</div>
				<div class="row h5 mt-2">Short Product Information</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 p-2">
						<textarea class="w-50 p-1 text-justify" disabled style="height: 15vw;">
							<?php echo $product_details; ?>
						</textarea>
					</div>
				</div>
				<div class="row h6 mt-3">
					Availability : <input type="text" name="stock_checker" class="w-25" disabled style="border: none;" value="<?php if ($stock == 0 || $stock == "Out of Stock") {
																																	echo "Out of Stock";
																																} else {
																																	echo $stock;
																																} ?>">
				</div>
				<div class="row h6 mt-3">
					Price : <input type="text" name="price" class="w-25" disabled style="border: none;" value="<?php echo $product_price; ?>">
				</div>
				<div class="row h6 mt-3">
					Quantity : <input type="number" name="quantity" class="w-25 text-center" value="In Stock" min="1" max="<?php echo $stock; ?>" required>
				</div>
				<div class="row h6 mt-3">
					<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-center">

						<input type='hidden' name='itemname' value='<?php echo $product_name; ?>'>
						<input type='hidden' name='itemprice' value='<?php echo $product_price; ?>'>
						<input type='hidden' name='itemimage' value='<?php echo $product_image; ?>'>
						<input type='hidden' name='pid' value='<?php echo $product_id; ?>'>
						<input type='hidden' name='stock' value='<?php echo $stock; ?>'>

						<?php if ($stock > 0) {
							echo "<button type='submit' name='addtoCart' class='btn btn-info'>Add to Cart</button> ";
						} else {
						} ?>


					</div>
				</div>
			</div>
		</div>
	</form>
	<div class="row border border-secondary my-5">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-4">
			<h6>Similar Products </h6>
		</div>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center my-4">
			<div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="carousel-item active">
						<div class="row">

							<?php
							include 'connection.php';
							if (isset($_GET['product_id'])) {
								$product_id = $_GET['product_id'];

								$query = "select Product_Type from product where product_id = '$product_id' ";

								$result = oci_parse($connection, $query);
								oci_execute($result);

								while ($row = oci_fetch_assoc($result)) {
									$product_type1 = $row['PRODUCT_TYPE'];

									$query1 = "select * from product where Product_Type = '$product_type1' ";

									$result1 = oci_parse($connection, $query1);
									oci_execute($result1);

									while ($row = oci_fetch_assoc($result1)) {
										$pid = $row['PRODUCT_ID'];
										$product_name1 = $row['PRODUCT_NAME'];
										$product_price1 = $row['PRODUCT_PRICE'];
										$product_image1 = $row['PRODUCT_IMAGE'];

										echo "   <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'>
													<a href='product_details.php?product_id=$pid'>
														<img src='$product_image1' alt='Similar_Products_1' class='rounded-0 img-fluid'>
													</a>
													<p class='h6 mt-2'>
													$product_name1<br>
													Price : $product_price1<br>";
										$query4 = "SELECT avg(Rating) from review, product where product.Product_Name='$product_name1' and '$pid' = review.Product_Id";

										$result4 = oci_parse($connection, $query4);
										oci_execute($result4);

										while ($row = oci_fetch_assoc($result4)) {
											$rating2 = $row['AVG(RATING)'];
										}
										include 'condition_checker/rating_conditional_2.php';
										echo "
													</p>
												</div> ";
									}
								}
							}
							?>



						</div>
					</div>
					<div class="carousel-item">
						<div class="row">
							<?php
							include 'connection.php';
							if (isset($_GET['product_id'])) {
								$product_id = $_GET['product_id'];

								$query = "SELECT Product_Type from product where product_id = '$product_id'";

								$result = oci_parse($connection, $query);
								oci_execute($result);

								while ($row = oci_fetch_assoc($result)) {
									$product_type1 = $row['PRODUCT_TYPE'];

									$query1 = "SELECT * from product where Product_Type = '$product_type1' order BY Product_Id DESC";

									$result1 = oci_parse($connection, $query1);
									oci_execute($result1);

									while ($row = oci_fetch_assoc($result1)) {
										$pid = $row['PRODUCT_ID'];
										$product_name1 = $row['PRODUCT_NAME'];
										$product_price1 = $row['PRODUCT_PRICE'];
										$product_image1 = $row['PRODUCT_IMAGE'];

										echo "   <div class='col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3'>
													<a href='product_details.php?product_id=$pid  '>
														<img src='$product_image1' alt='Similar_Products_1' class='rounded-0 img-fluid'>
													</a>
													<p class='h6 mt-2'>
													$product_name1<br>
													Price : $product_price1<br>
														";
										$query4 = "SELECT avg(Rating) from review, product where product.Product_Name='$product_name1' and '$pid' = review.Product_Id";

										$result4 = oci_parse($connection, $query4);
										oci_execute($result4);

										while ($row = oci_fetch_assoc($result4)) {
											$rating2 = $row['AVG(RATING)'];
										}
										include 'condition_checker/rating_conditional_2.php';

										echo "
													</p>
												</div> ";
									}
								}
							}
							?>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row border border-secondary">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h5 mt-4">
			Product Description
		</div>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h5 mt-4">
			<textarea class="w-100 text-justify text-center mb-5" disabled style="height: 15vw;">
				<?php echo $product_details; ?>
			</textarea>
		</div>
	</div>
	<div class="row border border-secondary mt-5 p-5">
		<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 h3 text-center mt-3">
			Rating & Reviews<br><br>
			<?php include 'condition_checker/rating_conditional.php'; ?>
		</div>
		<div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 h5 d-flex align-items-center justify-content-center mt-3">
			<div class="row text-center">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h3">
					Have you used this Product?
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2">
					<a href="review_product.php?product_id=<?php echo $product_id; ?>">
						<input type="submit" name="review" class="btn btn-success">
					</a>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-5 border border-secondary">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-4">
			<form action="#" method="POST">
				<table class="table mt-2 w-100">
					<thead class="thead-dark">
						<tr>
							<th>
								<span style="background-color:#212529; color: white;">Sort By:</span>
								<select style="background-color:#212529; color: white; " name="cat">
									<option value="ASC" <?php echo isset($_POST['cat']) && $_POST['cat'] == "ASC" ? 'selected="selected"' : ''; ?> style="background-color:#212529; color: white;">Recent</option>
									<option value="DESC" <?php echo isset($_POST['cat']) && $_POST['cat'] == "DESC" ? 'selected="selected"' : ''; ?> style="background-color:#212529; color: white;">Oldest</option>


								</select>
								<button class="btn btn-secondary" style="background-color:#212529; color: white;">Go</button>
							</th>
							<th>
							</th>
							<th>
								<span style="background-color: #212529; color: #212529;">Quantity</span>
							</th>
							<th>
							</th>
						</tr>
					</thead>
				</table>
			</form>



			<?php if (isset($_GET['product_id'])) {
				$product_id = $_GET['product_id'];
				$query = "SELECT * FROM review INNER JOIN customer ON review.Customer_Id=customer.Customer_Id INNER JOIN product ON review.Product_Id=product.Product_id AND product.Product_Id='$product_id' and Review_Status='1'";

				$result = oci_parse($connection, $query);
				oci_execute($result);

				if (isset($_POST['cat'])) {
					$c = $_POST['cat'];

					if ($c == "DESC") {
						$s = "DESC";
					} elseif ($c == "ASC") {
						$s = "ASC";
					} else {
						$s = "";
					}
					$qry2 = "SELECT * FROM review INNER JOIN customer ON review.Customer_Id=customer.Customer_Id INNER JOIN product ON review.Product_Id=product.Product_id AND product.Product_Id='$product_id' ORDER BY date '$s'";
					$r1 = oci_parse($connection, $qry2);
					oci_execute($r1);
					while ($row = oci_fetch_assoc($r1)) {
						echo "
		
							<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 px-5 mt-5'>
					
					<div class='row h6 mt-3'>
							Reviewed Date : ";
						echo $row['DATES'];
						echo "<input type='text' name='reviewed_date'  style='border: none;'>
						</div>
						<div class='row'>";

						$rating2 = $row['RATING'];
						include 'condition_checker/rating_conditional_2.php';

						echo " 
						</div>
						<div class='row h5 mt-1'>
							";
						echo "by " . $row['USERNAME'];
						echo " 
						</div>
						<div class='row h3 mt-4 w-100'>
							<textarea class='form-control' class='w-100 text-justify' placeholder='Lorem' disabled style='height: 10vw; padding-left: 0px;'>
							";
						echo $row['DESCRIPTION'];

						echo "
							
							</textarea>
						
						 ";
						echo "</div>
						 </div> ";
					}
				} else {
					while ($row = oci_fetch_assoc($result)) {
						echo "

					<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 px-5 mt-5'>
			
			<div class='row h6 mt-3'>
					Reviewed Date : ";
						echo $row['DATES'];
						echo "<input type='text' name='reviewed_date'  disabled style='border: none;'>
				</div>
				<div class='row'>";

						$rating2 = $row['RATING'];
						include 'condition_checker/rating_conditional_2.php';

						echo " 
				</div>
				<div class='row h5 mt-1'>
    				";
						echo "by " . $row['USERNAME'];
						echo " 
				</div>
				<div class='row h3 mt-4 w-100'>
    				<textarea class='w-100 text-justify' placeholder='Lorem' disabled style='height: 10vw;'>
					";
						echo $row['DESCRIPTION'];

						echo "
					
					</textarea>
				
				 ";
						echo "</div>
				 </div> ";
					}
				}
			} else {
				//header('Location:index.php');
				//header('Location:product_details.php');
				//exit();

				echo "not fund";
			} ?>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-5">
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
<?php
include 'footer.php';
include 'end.php';
?>