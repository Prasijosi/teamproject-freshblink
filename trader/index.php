<?php include '../start.php';
if (!isset($_SESSION['trader_username'])) {
	header('Location:sign_in_trader.php');
	exit();
}
?>
<?php include 'theader.php';

if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
	echo "<script>alert('" . $msg . "');</script>";
} else {
	echo "";
}

if (isset($_SESSION['msg'])) {
	echo "<h4 style='text-align: center; color:green;'>" . $_SESSION['msg'] . "</h4>";
}

?>



<div class="container">
	<div class="row mt-5 border">
		<div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 p-5">
			<div class="row">
				<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-flex align-items-center justify-content-start">
					<?php

					include 'connection.php';

					$tn = $_SESSION['trader_username'];

					$sql = "SELECT * FROM trader where Username='$tn' ";
					$qry = oci_parse($connection, $sql);
					oci_execute($qry);

					while ($row = oci_fetch_assoc($qry)) {
						$tid = $row['TRADER_ID'];
						$timage = $row['PROFILE_IMAGE'];
						$tname = $row['NAME'];
						$temail = $row['EMAIL'];
					}

					echo "<img src='../$timage' class='img-fluid' width='100px' alt='No Trader Image' height='100px' >";

					?>
				</div>
				<div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9 d-flex align-items-center justify-content-start">
					<div class="row">
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h5 d-flex align-items-center justify-content-start">
							Account Information
						</div>
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h6 d-flex align-items-center justify-content-start">
							<?php echo $tname ?>
						</div>
						<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h6 d-flex align-items-center justify-content-start">
							<?php echo $temail ?>
						</div>
						<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 h6 d-flex align-items-center justify-content-start">
							<a href="trader_edit_profile.php">Edit</a>
						</div>
						<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 h6 d-flex align-items-center justify-content-start">
							<a href="trader_change_password.php">Change Password</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row mt-5 border p-5">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<?php

					include 'connection.php';

					$tn = $_SESSION['trader_username'];

					$sql = "SELECT * FROM trader where Username='$tn' ";
					$qry = oci_parse($connection, $sql);
					oci_execute($qry);

					while ($row = oci_fetch_assoc($qry)) {
						include 'connection.php';
						$tid = $row['TRADER_ID'];

						$sql5 = "SELECT * FROM review, product, shop WHERE shop.Shop_Id=product.Shop_Id AND review.Product_Id=product.Product_Id and shop.Trader_id='$tid'";

						$qry5 = oci_parse($connection, $sql5);
						oci_execute($qry5);

						$count = oci_fetch_all($qry5, $connection);
						oci_execute($qry5);
						echo $count;

						if ($count > 0) {
							include 'connection.php';

							$sql1 = "SELECT  Rating ,Description,DATES ,Product_Name,Product_Image  FROM review INNER JOIN product ON review.Product_Id=product.Product_Id  INNER JOIN shop  ON shop.Shop_Id=product.Shop_Id  where shop.Trader_id='$tid' and Rating = (select max(Rating) from review)";
							$qry1 = oci_parse($connection, $sql1);
							oci_execute($qry1);

							while ($row = oci_fetch_assoc($qry1)) {
								$pname = $row['PRODUCT_NAME'];
								$prating = $row['RATING'];
								$review = $row['DESCRIPTION'];
								$rdate = $row['DATES'];
								$pimage = $row['PRODUCT_IMAGE'];
							}

							echo "
												<div class='row'>
										<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
											<div class='row h6'>Top Positive Review</div>
											<div class='row border p-1'>
										<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start mt-2'>
										$prating/5
										</div>
										<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start mt-2'>
										$rdate
										</div>
										<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>
										<textarea class='w-100 mt-2 text-justify'>
											$review
										</textarea>
										</div>
										<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3'>
										<img src='../$pimage' class='img-fluid' width='60px' height='60px'>
										</div>
										<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3'>
										<div class='row'>
											$pname
										</div>
										<div class='row'>
											<button type='submit' name='reply' class='btn btn-success'>Reply</button>
										</div>
										</div>
										";
						} else {
							echo "<div class='row'>
								<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
									<div class='row h6'>No Any Positive Review Found</div>
									<div class='row border p-1'>
								<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start mt-2'>
								0/5
								</div>
								<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start mt-2'>
								seems like nobody has reviewed your product
								</div>
								<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>
								<textarea class='w-100 mt-2 text-justify'>
									no
								</textarea>
								</div>
								<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3'>
								<img src='p.png' class='img-fluid' width='60px' height='60px'>
								</div>
								<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3'>
								<div class='row'>

								</div>
								<div class='row'>
									<button type='submit' name='reply' class='btn btn-success'>Reply</button>
								</div>
								</div> ";
						}
					} //

					?>


					<?php include 'connection.php';

					$tn = $_SESSION['trader_username'];

					$sql = "SELECT * FROM trader where Username='$tn' ";
					$qry = oci_parse($connection, $sql);
					oci_execute($qry);

					while ($row = oci_fetch_assoc($qry)) {
						include 'connection.php';
						$tid = $row['TRADER_ID'];

						$sql5 = "SELECT*  FROM review, product, shop where shop.Shop_Id=product.Shop_Id AND review.Product_Id=product.Product_Id and shop.Trader_id='$tid'";
						$qry5 = oci_parse($connection, $sql5);
						oci_execute($qry5);

						$count = oci_fetch_all($qry5, $connection);
						oci_execute($qry5);

						if ($count > 0) {
							include 'connection.php';

							$sql1 = "SELECT Review_Id, Description,rating, DATES,Product_Name,Product_Image FROM review, product, shop where shop.Shop_Id=product.Shop_Id AND review.Product_Id=product.Product_Id and shop.Trader_id='$tid' AND Rating = (select min(Rating) from review)";
							$qry1 = oci_parse($connection, $sql1);
							oci_execute($qry1);

							while ($row = oci_fetch_assoc($qry1)) {
								$pname = $row['PRODUCT_NAME'];
								$prating = $row['RATING'];
								$review = $row['DESCRIPTION'];
								$rdate = $row['DATES'];
								$pimage = $row['PRODUCT_IMAGE'];
							}

							echo "

</div>
</div>
<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
	<div class='row h6'>Top Critical Review</div>
	<div class='row border p-1'>
		<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start mt-2'>
		$prating/5
		</div>
		<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start mt-2'>
		$rdate
		</div>
		<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>
		<textarea class='w-100 mt-2 text-justify'>
			$review
		</textarea>
		</div>
		<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3'>
		<img src='../$pimage' class='img-fluid' width='60px' height='60px'>
		</div>
		<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3'>
		<div class='row'>
			$pname
		</div>
		<div class='row'>
			<button type='submit' name='reply' class='btn btn-success'>Reply</button>
		</div>
		</div>
		";
						} else {
							echo "

</div>
</div>
<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6'>
	<div class='row h6'>No Any Critical Review Found</div>
	<div class='row border p-1'>
		<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start mt-2'>
		0/5
		</div>
		<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start mt-2'>
		seems like nobody has reviewed your product
		</div>
		<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12'>
		<textarea class='w-100 mt-2 text-justify'>
			Not Found
		</textarea>
		</div>
		<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3'>
		<img src='p.png' class='img-fluid' width='60px' height='60px'>
		</div>
		<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-3'>
		<div class='row'>

		</div>
		<div class='row'>
			<button type='submit' name='reply' class='btn btn-success'>Reply</button>
		</div>
		</div>
		";
						}
					} //

					?>

				</div>
			</div>




		</div>
	</div>
</div>
</div>
<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
	<div class="row p-5">
		<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h4 d-flex align-items-center justify-content-center'>Stock Level</div>
		<?php

		include 'connection.php';

		$tn = $_SESSION['trader_username'];

		$sql = "SELECT * FROM trader where Username='$tn' ";
		$qry = oci_parse($connection, $sql);
		oci_execute($qry);

		while ($row = oci_fetch_assoc($qry)) {
			$tid = $row['TRADER_ID'];
			$sql1 = "SELECT * FROM trader, product, shop WHERE shop.Shop_Id=product.Shop_Id AND trader.Trader_Id=shop.Trader_id AND shop.Trader_id='$tid' ORDER BY stock";
			$qry1 = oci_parse($connection, $sql1);
			oci_execute($qry1);

			while ($row = oci_fetch_assoc($qry1)) {

				$pname = $row['PRODUCT_NAME'];
				$stock = $row['STOCK'];
				echo "

						<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 display-5 text-center my-2 p-5' style='background-color:#cacaca;'>
							<span class='h5'>$pname</span><br>
							";
				if ($stock < 10) {
					echo "<span class='h6 mt-1'style='color:red;'>Stock : {$stock}</span>";
				} else {
					echo "<span class='h6 mt-1'>Stock : {$stock}</span>";
				}

				echo "
						</div>

						";
			}
		}
		?>


	</div>
</div>
</div>
</div>
<?php
unset($_SESSION['msg']);
include '../end.php'; ?>