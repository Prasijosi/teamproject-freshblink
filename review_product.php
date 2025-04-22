<?php
include 'start.php';
if (!isset($_SESSION['username'])) {
	header('Location:sign_in_customer.php');
}

if (isset($_GET['product_id'])) {

	$customer_id = $_SESSION['customer_id'];
	$product_id = $_GET['product_id'];

	include 'connection.php';

	$sql = "SELECT * from product where '$product_id' = Product_Id";

	$result = oci_parse($connection, $sql);
	oci_execute($result);

	$count = oci_fetch_all($result, $connection);
	oci_execute($result);

	if ($count >= 1) {
		while ($row = oci_fetch_assoc($result)) {
			$product_name = $row['PRODUCT_NAME'];
			$product_image = $row['PRODUCT_IMAGE'];
		}
	}
}

$customer_id = $_SESSION['customer_id'];

if (isset($_POST['review'])) {

	include 'connection.php';

	$rating = $_POST['rating'];
	$description = $_POST['description'];

	$customer_id = $_SESSION['customer_id'];

	$sql1 = "INSERT into review(Rating, Description, Customer_Id, Product_Id, Dates, Review_Status) values('$rating','$description','$customer_id','$product_id',SYSDATE,'0')";

	$result1 = oci_parse($connection, $sql1);
	oci_execute($result1);

	if ($result1) {
		header("Location:reviews.php?msg=Product Successfully Reviewed");
		exit();
	} else {
		header("Location:reviews.php?msg=Error Reviewing the Product");
		exit();
	}
} else {
	echo "";
}

?>
<div class="container">
	<?php
	include 'header.php';
	?>
	<form action="review_product.php?product_id=<?php echo $product_id ?>" method="POST">
		<div class="row my-5">
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-5 h3">
				Review Product : <?php echo $product_name ?>
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-5">
				<img src="<?php echo $product_image ?>">
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-5">
				<label for="rating">Rating</label>
				<br>
				1 <input type="radio" name="rating" id="rating" value="1" checked>
				2 <input type="radio" name="rating" id="rating" value="2">
				3 <input type="radio" name="rating" id="rating" value="3">
				4 <input type="radio" name="rating" id="rating" value="4">
				5 <input type="radio" name="rating" id="rating" value="5">
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
				<textarea class="w-50 mt-5" placeholder="Write your review here......" name="description" style="height: 10vw;" required></textarea>
			</div>
			<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-5">
				<button type="submit" class="btn btn-success mb-5" name="review">Review</button>
			</div>
		</div>
	</form>
</div>
<?php
include 'footer.php';
include 'end.php';
?>