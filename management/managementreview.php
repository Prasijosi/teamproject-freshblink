<?php
session_start();
include 'theader.php';

if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
	echo "<script>alert('" . $msg . "');</script>";
} else {
	echo "";
}

if (isset($_POST['submit']) && isset($_POST['pid'])) {
	$pid = $_POST['pid'];
	include('connection.php');
	$sql = " UPDATE review SET Review_Status= '1' where Product_Id='$pid' ";
	$qry = oci_parse($connection, $sql);
	oci_execute($qry);
	if ($qry) {
		header('Location:managementreview.php?msg=Review Approved');
		exit();
	} else {
		header('Location:managementreview.php?msg=Query Not Running');
		exit();
	}
} elseif (isset($_POST['submit2']) && isset($_POST['pid'])) {

	$pid = $_POST['pid'];
	include('connection.php');
	$sql = " DELETE FROM review WHERE  Product_Id='$pid' ";
	$qry = oci_parse($connection, $sql);
	oci_execute($qry);
	if ($qry) {
		header('Location:managementreview.php?msg=Review Deleted');
		exit();
	} else {
		header('Location:managementreview.php?msg=Query Not Running');
		exit();
	}
}


?>
<div class="container-fluid main-content">

	<h3>Product Reviews</h3>
	<div class="table-responsive">

		<table id="myTable" class="table table-bordered" width="100%">

			<table id="myTable" class="table table-bordered" width="100%">
				<div class="row">
					<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center justify-content-start">
						<?php
						include('connection.php');
						$sql = " SELECT * FROM  review, product,customer where review.Product_Id=product.Product_Id and review.Customer_Id=customer.Customer_ID and Review_Status='0' ";
						$qry = oci_parse($connection, $sql);
						oci_execute($qry);

						$count3 = oci_fetch_all($qry, $connection);
						oci_execute($qry);

						echo "<h5>$count3 New Review Request</h5>";
						?>
					</div>

					<div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 d-flex align-items-center justify-content-end">


						<label>Sort By:</label>
						<select name="category" class="category">
							<option value="All" class="ml-1">Recent </option>

						</select>

					</div>
				</div>
				<thead>
					<tr class="bg-dark text-white">
						<th>SN</th>
						<th>Product Name</th>
						<th>Product Image</th>
						<th>Rating</th>
						<th>Review</th>
						<th>Reviewer</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>

					<?php
					include('connection.php');
					$sql = "SELECT * FROM  review, product, customer where review.Product_Id=product.Product_Id and review.Customer_Id=customer.Customer_ID and Review_Status='0'  ";
					$qry = oci_parse($connection, $sql);
					oci_execute($qry);
					$s = 0;
					while ($row = oci_fetch_assoc($qry)) {
						$pid = $row['PRODUCT_ID'];
						$pname = $row['PRODUCT_NAME'];
						$pimage = $row['PRODUCT_IMAGE'];
						$rating = $row['RATING'];
						$review = $row['DESCRIPTION'];
						$customer = $row['FULL_NAME'];
						$s = $s + 1;

						echo " 
						<tr>  
						<td class='text-center'>$s</td>  
						<td class='text-center'>$pname</td> 
						<td class='text-center'><img src=' ../" . $pimage . "' class='img-fluid' style='width: 10vw; '></td>   
						<td class='text-center'>$rating</td>  
						<td class='text-center'>$review</td>
						<td class='text-center'>$customer</td>
					
						 <form method='POST' action='managementreview.php'>
						 <input type='hidden'  name='pid' value='$pid'>
						<td class='actionbtn'>
						<button type='submit' class='btn btn-success' name='submit'  >Approve</button> <br> 
						<button type='submit' class='btn btn-danger' name='submit2'  >Decline</button>
						</td>  
						</form>  
					  </tr>  
	
						  ";
					}



					?>

				</tbody>

			</table>
	</div>
</div>

</div>
<?php include 'tfooter.php'; ?>