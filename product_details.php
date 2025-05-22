<?php 
ob_start();
@include 'start.php';
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

<?php
include 'connection.php';
$product_id = $_GET['product_id'];
$query = "SELECT *
FROM (
    SELECT r.*, c.Full_Name as Customer_Name
    FROM review r, customer c
    WHERE r.Customer_Id = c.Customer_Id
      AND Product_Id = :pid
)
WHERE ROWNUM <= 3
";
$statement = oci_parse($connection, $query);
oci_bind_by_name($statement, ':pid', $product_id);
oci_execute($statement);
?>

<style>
	.product-image {
		width: 100%;
		max-width: 450px;
		border-radius: 10px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
		object-fit: cover;
	}

	.product-details {
		height: auto !important;
		min-height: 150px;
		resize: none;
		border: none;
		background-color: #f8f9fa;
		padding: 10px;
		border-radius: 8px;
	}

	.fa-star {
		color: orange;
		font-size: 1.4rem;
	}

	.card {
		border: none;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
		border-radius: 1rem;
	}

	.section-title {
		font-weight: 600;
		margin-bottom: 1rem;
	}

	.review-card {
		width: 100%;
		margin: 30px auto;
		border: 1px solid #ccc;
		border-radius: 8px;
		overflow: hidden;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
	}

	.review-header {
		background-color: #999;
		color: white;
		text-align: center;
		padding: 10px;
		font-weight: bold;
		font-size: 1.2rem;
	}

	.review-item {
		padding: 20px;
		border-bottom: 1px solid #eee;
	}

	.review-item:last-child {
		border-bottom: none;
	}

	.review-item i {
		color: #f0ad4e;
	}

	.user-icon {
		width: 30px;
		height: 30px;
		background-color: #ddd;
		border-radius: 50%;
		display: inline-block;
		vertical-align: middle;
		margin-right: 10px;
	}

	.review-text {
		margin-top: 10px;
	}

	.review-container {
		max-width: 650px;
		margin: 50px auto;
		background-color: #ffffff;
		border-radius: 10px;
		box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
		padding: 40px;
	}

	.star-rating .fa-star {
		font-size: 1.5rem;
		cursor: pointer;
		color: #ddd;
		transition: color 0.3s;
	}

	.star-rating .fa-star.checked {
		color: #f0ad4e;
	}

	.form-control:focus {
		box-shadow: none;
		border-color: #28a745;
	}
</style>

<diiv class="container">
	<?php include 'header.php'; ?>
	<?php if (isset($_POST['addtoCart'])) {
		$qty = $_POST['quantity'];
		if (!isset($_SESSION['username'])) {
			echo "
			<div class='row border p-4 mt-4'> 
        	<div class='col-12 d-flex align-items-center justify-content-center' style='color:red;'>";
			echo "Please<a href='sign_in_customer.php' style='color:red;' class='mx-1'>Sign-In</a>to place an Order!
			</div></div>";
		}
	} ?>
	<form action="manage_cart.php" method="POST" class="card my-5 p-4">
		<div class="row g-4">
			<div class="col-md-6 text-center">
				<img src="<?php echo $product_image; ?>" class="product-image img-fluid" alt="Product">
			</div>
			<div class="col-md-6">
				<h3 class="mb-3"><?php echo $product_name; ?></h3>

				<h5 class="section-title">Rating</h5>
				<div class="mb-3"><?php include 'condition_checker/rating_conditional.php'; ?></div>

				<div class="mb-3">
					<p class="mb-1"><strong>Sold by:</strong>
						<a href="search_product.php?search_Cat=<?php echo $shop_name; ?>">
							<?php echo $shop_name; ?>
						</a>
					</p>
					<p>
						<a href="search_product.php?search_Cat=<?php echo $shop_name; ?>" class="text-decoration-underline">
							View more from this seller
						</a>
					</p>
				</div>

				<h5 class="section-title">Product Details</h5>
				<div class="mb-3">
					<textarea class="form-control product-details" disabled><?php echo $product_details; ?></textarea>
				</div>

				<div class="row g-3 mb-3">
					<div class="col-md-6">
						<label class="form-label fw-semibold">Price</label>
						<input type="text" class="form-control-plaintext" disabled value="<?php echo $product_price; ?>">
					</div>
					<div class="col-md-6">
						<label class="form-label fw-semibold">Availability</label>
						<input type="text" class="form-control-plaintext" disabled value="<?php echo ($stock == 0 || $stock == "Out of Stock") ? "Out of Stock" : $stock; ?>">
					</div>
				</div>

				<div class="mb-3">
					<label class="form-label fw-semibold">Quantity</label>
					<input type="number" name="quantity" class="form-control w-50" value="1" min="1" max="<?php echo $stock; ?>" required>
				</div>

				<?php if ($stock > 0) { ?>
					<button type="submit" name="addtoCart" class="btn btn-primary px-4 py-2">Add to Cart</button>
				<?php } ?>

				<!-- Hidden Fields -->
				<?php foreach (['itemname' => $product_name, 'itemprice' => $product_price, 'itemimage' => $product_image, 'pid' => $product_id, 'stock' => $stock] as $name => $value): ?>
					<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>">
				<?php endforeach; ?>
			</div>
		</div>
	</form>

	<div class="row">
		<div class="col-12 col-md-8">
			<div class="review-card">
				<div class="review-header">Customer Review</div>

				<?php
				$hasReviews = false;
				while ($row = oci_fetch_assoc($statement)) {
					$hasReviews = true;
					$name = htmlspecialchars($row['CUSTOMER_NAME']);
					$rating = (int)$row['RATING'];
					$review = htmlspecialchars($row['DESCRIPTION']);

					echo '<div class="review-item">';
					echo '  <div><span class="user-icon"></span><strong>' . $name . '</strong></div>';
					echo '  <div class="mt-2">';
					for ($i = 1; $i <= 5; $i++) {
						if ($i <= $rating) {
							echo '<i class="fas fa-star"></i>';
						} else {
							echo '<i class="far fa-star"></i>';
						}
					}
					echo '  </div>';
					echo '  <input type="text" class="form-control review-text" value="' . $review . '" disabled>';
					echo '</div>';
				}

				if (!$hasReviews) {
					echo '<div class="p-4 text-center">No reviews available for this product.</div>';
				}
				?>
			</div>


		</div>

		<div class="col-12 col-md-4">
			<?php include 'review_product.php'; ?>
		</div>
	</div>
</diiv

<?php
include 'footer.php';
include 'end.php';
ob_end_flush();
?>