<?php include 'start.php';
//unset($_SESSION['collectionslot']);


@$phone = "";

if (isset($_POST['check'])) {

	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$taskoption = $_POST['taskoption'];
	$timeoption = $_POST['timeoption'];

	if (isset($_SESSION['collectionslot'])) {

		$_SESSION['collectionslot'][0] = array('task_option' => $_POST['taskoption'], 'time_option' => $_POST['timeoption']);

		echo " <script>
            alert('Collection Slot added');
            window.location.href='checkout.php?ok&email=$email&phone=$phone&taskoption=$taskoption&timeoption=$timeoption';

          
            </script>";
	} else {
		$_SESSION['collectionslot'][0] = array('task_option' => $_POST['taskoption'], 'time_option' => $_POST['timeoption']); // if no session of cart then set item deatils in 0 index, using aasociative aaray 


		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$taskoption = $_POST['taskoption'];
		$timeoption = $_POST['timeoption'];
		echo " <script>
			alert('Collection Slot Added');
			window.location.href='checkout.php?ok&email=$email&phone=$phone&taskoption=$taskoption&timeoption=$timeoption';
			</script>";

		//print_r($_SESSION['collectionslot']);
		//echo "session xaina";
	}
} else {
	//echo "check xaina";
}



if (isset($_POST['clear_cart'])) {
	unset($_SESSION['cart']);
	echo " <script>
    alert('Cart Cleared');
    window.location.href='index.php';
    </script>";
}

if (!isset($_SESSION['cart'])) {
	//if no session of cart then redirecting to index.php if user try to access checkout page
	header('Location:index.php');
}

if (!isset($_SESSION['username'])) {
	header('Location:sign_in_customer.php');
}

if (isset($_POST['checkout'])) {
	foreach ($_SESSION['cart'] as $key => $value) {
		//from here we get index value of array  , only key then whole data aaray shows if value added then index
		//print_r($key) ;

		$item_name = $value['item_name'];
		$item_quantity = $value['quantity'];

		include "connection.php";
		$sql = " SELECT PRODUCT_ID FROM PRODUCT WHERE PRODUCT_NAME = '$item_name'";
		$result = oci_parse($connection, $sql);
		oci_execute($result);;

		if ($result) {
			while ($row = oci_fetch_assoc($result)) {
				$pid = $row['PRODUCT_ID'];
				//echo "Product ID ".$pid;
				$un = $_SESSION['username'];
				$sql3 = "SELECT Customer_ID FROM customer WHERE Username = '$un'";
				$result1 = oci_parse($connection, $sql3);
				oci_execute($result1);

				if ($result1) {
					while ($row = oci_fetch_assoc($result1)) {
						$cid = $row['CUSTOMER_ID'];
						//echo "Customer ID ".$cid;

						//echo "Quantity".$item_quantity;
						include('connection.php');
						$sql = "SELECT * FROM cart WHERE CUSTOMER_ID=$cid and product_id=$pid";



						$qry = oci_parse($connection, $sql);
						oci_execute($qry);

						$count = oci_fetch_all($qry, $connection);
						oci_execute($qry);

						if ($count == 0) {
							include "connection.php";
							$sql2 = "INSERT INTO cart(Total_Price,Customer_Id,Product_Id) VALUES ('$item_quantity','$cid','$pid')"; //ya total price chaii haina product quantity chaii insert hunxa

							$result3 = oci_parse($connection, $sql2);
							oci_execute($result3);



							if ($result3) {
								echo " <script>
				alert('Cart Inserted');
				window.location.href='checkout.php';
				</script>";
							} else {
								echo " <script>
				alert('Error');
				window.location.href='product_details.php?product_id=1001';
				</script>";
							}
						} else {

							include "connection.php";

							$sql50 = "update cart set TOTAL_PRICE = $item_quantity where customer_id=$cid and product_id=$pid";
							$result50 = oci_parse($connection, $sql50);
							oci_execute($result50);

							if ($result50) {
								echo " <script>
				alert('Cart Updated');
				window.location.href='checkout.php';
				</script>";
							} else {
								echo "no";
							}
						}
					}
				}
				//echo $un;
				//echo $q."Quantity";
			}
		} else {
			echo "Error Running Query";
		}

		//print_r($_SESSION['cart']);
		// echo "
		// <script>
		// alert('Item Removed');
		// window.location.href='cart.php';
		// </script>
		// ";
	}

	//echo "xa";
	//echo $_POST['pprice'];
	//echo $_POST['pname'];
	//$pn=$_POST['pname'];
	//$un=$_SESSION['uname'];
	//$q=$_POST['quan'];

	$un = $_SESSION['username'];
} elseif (isset($_POST['Mod_Quantity'])) {
	//while refreshing page , quantity value was reseting so to fix

	foreach ($_SESSION['cart'] as $key => $value) {
		//from here we get index value of array  , only key then whole data aaray shows if value added then index
		//print_r($key) ;
		if ($value['item_name'] == $_POST['item_name']) {
			$_SESSION['cart'][$key]['quantity'] = $_POST['Mod_Quantity']; //cart ko key index ko quantity laii post bata send gareko value ma chnage garne

			//echo " .$value[item_name]. $_POST[item_name] ";

			echo " <script>
			alert('Cart Updated');
			window.location.href='cart.php';
			</script>";

			// <script>
			// alert('Item Removed');
			// window.location.href='cart.php';
			// </script>
			// ";
		}
	}
} else {
	//echo "xaina";
}

$q1 = 0;
$t = 0;
foreach ($_SESSION['cart'] as $key => $value) {
	//from here we get index value of array  , only key then whole data aaray shows if value added then index
	//print_r($key) ;

	$q = $value['quantity'];
	$p = $value['price'];

	$q1 = $q * $p; //quantuty * price

	//echo " Sub Total".$q1." ";  //subtotal price of one product

	$t = $q1 + $t; //grand total
}

//echo " ALL Total ".$t;

$totall = 0; //cart ko price
include('connection.php');
$cid2 = $_SESSION['customer_id'];
$sql20 = " SELECT * FROM cart WHERE customer_Id = '$cid2'";
$result20 = oci_parse($connection, $sql20);
oci_execute($result20);

while ($row = oci_fetch_array($result20)) {
	$cpid = $row['PRODUCT_ID'];  //cart ko product id
	$cq = $row['TOTAL_PRICE']; //cart ko quantity

	include('connection.php');

	$sql21 = " SELECT * FROM product WHERE PRODUCT_ID = '$cpid'";
	$result21 = oci_parse($connection, $sql21);
	oci_execute($result21);

	while ($row = oci_fetch_array($result21)) {
		$pprice = $row['PRODUCT_PRICE'];
		$subtotal = $pprice * $cq;
	}
	$totall = $subtotal + $totall;
}

?>



<?php
//Set variables for paypal form
$paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr'; //always the same
//Test PayPal API URL
$paypal_email = 'sb-2fcha6626063@business.example.com'; //merchant account -> gets the money in this account
?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<link rel="stylesheet" type="text/css" href="css/mystyle.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<style>
	body {
		font-family: 'Poppins', sans-serif;
	}

	.checkout-container {
		background: white;
		border-radius: 10px;
		box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
		padding: 2rem;
		margin: 2rem 0;
	}

	.section-title {
		color: #2c3e50;
		font-weight: 600;
		margin-bottom: 1.5rem;
		padding-bottom: 0.5rem;
		border-bottom: 2px solid #e9ecef;
	}

	.form-control {
		border-radius: 5px;
		border: 1px solid #dee2e6;
		padding: 0.75rem;
	}

	.form-control:focus {
		border-color: #80bdff;
		box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
	}

	.date-time-select {
		background: #f8f9fa;
		padding: 1.5rem;
		border-radius: 8px;
		margin: 1rem 0;
	}

	.date-time-select select {
		width: 100%;
		padding: 0.75rem;
		border-radius: 5px;
		border: 1px solid #dee2e6;
		margin: 0.5rem 0;
		font-size: 1rem;
		color: #495057;
		background-color: #fff;
		cursor: pointer;
	}

	.date-time-select select option {
		padding: 10px;
		font-size: 1rem;
		color: #495057;
		background-color: #fff;
	}

	.date-time-select select:focus {
		border-color: #80bdff;
		box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
	}

	.date-time-select label {
		font-weight: 500;
		color: #2c3e50;
		margin-bottom: 0.5rem;
		display: block;
	}

	.btn-check {
		background: #007bff;
		color: white;
		padding: 0.75rem 2rem;
		border-radius: 5px;
		border: none;
		font-weight: 500;
		transition: all 0.3s ease;
	}

	.btn-check:hover {
		background: #0056b3;
		transform: translateY(-1px);
	}

	.order-summary {
		background: white;
		border-radius: 10px;
		padding: 1.5rem;
	}

	.table {
		margin-bottom: 0;
	}

	.table th {
		background: #f8f9fa;
		font-weight: 500;
	}

	.paypal-button {
		margin-top: 1.5rem;
	}

	.badge-danger {
		background: #dc3545;
		padding: 0.5rem 1rem;
		border-radius: 5px;
		font-weight: 400;
	}
</style>

<?php
include 'header.php';
if (isset($_GET['msg'])) {
	echo "<div class='alert alert-danger text-center' role='alert'>" . $_GET['msg'] . "</div>";
}
?>
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="checkout-container">
				<h4 class="section-title">Billing Details</h4>
				<form method="POST" action="checkout.php">
					<div class="form-group">
						<label for="inputEmail" class="font-weight-medium">Email Address</label>
						<input type="email" value="<?php echo $_SESSION['email']; ?>" class="form-control" id="inputEmail" name="email" placeholder="Enter your email" required>
					</div>

					<div class="form-group">
						<label for="inputphoneNumber" class="font-weight-medium">Phone Number</label>
						<input type="text" class="form-control" name="phone" id="inputphoneNumber" placeholder="Enter your phone number" value="<?php if (isset($_GET['phone'])) {
																																					echo $_GET['phone'];
																																				} ?>" required>
					</div>

					<div class="date-time-select">
						<h5 class="section-title bg-light">Choose Collection Date & Time</h5>
						<div class="form-group">
							<label class="font-weight-medium bg-light">Select Date</label>
							<select class="form-control bg-light" required id="inlineFormCustomSelect" name="taskoption">
								<?php
								date_default_timezone_set('Asia/Kathmandu');
								$date = date("Y-m-d");
								$day = date("D", strtotime($date));

								switch ($day) {
									case "Sun":
										$aa = strtotime($date . "+ 3 days");
										$ba = strtotime($date . "+ 4 days");
										$ca = strtotime($date . "+ 5 days");
										break;
									case "Mon":
										$aa = strtotime($date . "+ 2 days");
										$ba = strtotime($date . "+ 3 days");
										$ca = strtotime($date . "+ 4 days");
										break;
									case "Tue":
										$aa = strtotime($date . "+ 1 days");
										$ba = strtotime($date . "+ 2 days");
										$ca = strtotime($date . "+ 3 days");
										break;
									case "Wed":
										$aa = strtotime($date . "+ 1 days");
										$ba = strtotime($date . "+ 2 days");
										$ca = strtotime($date . "+ 7 days");
										break;
									case "Thu":
										$aa = strtotime($date . "+ 1 days");
										$ba = strtotime($date . "+ 6 days");
										$ca = strtotime($date . "+ 7 days");
										break;
									case "Fri":
										$aa = strtotime($date . "+ 5 days");
										$ba = strtotime($date . "+ 6 days");
										$ca = strtotime($date . "+ 7 days");
										break;
									case "Sat":
										$aa = strtotime($date . "+ 4 days");
										$ba = strtotime($date . "+ 5 days");
										$ca = strtotime($date . "+ 6 days");
										break;
								}

								$x1 = date("l-m-d-Y", $aa);
								$y2 = date("l-m-d-Y", $ba);
								$z3 = date("l-m-d-Y", $ca);

								// For display
								$x1_display = date("l, F j, Y", $aa);
								$y2_display = date("l, F j, Y", $ba);
								$z3_display = date("l, F j, Y", $ca);
								?>
								<option value="<?php echo $x1 ?>" <?php echo (isset($_GET['taskoption']) && $_GET['taskoption'] == "$x1") ? 'selected="selected"' : ''; ?>><?php echo $x1_display ?></option>
								<option value="<?php echo $y2 ?>" <?php echo (isset($_GET['taskoption']) && $_GET['taskoption'] == "$y2") ? 'selected="selected"' : ''; ?>><?php echo $y2_display ?></option>
								<option value="<?php echo $z3 ?>" <?php echo (isset($_GET['taskoption']) && $_GET['taskoption'] == "$z3") ? 'selected="selected"' : ''; ?>><?php echo $z3_display ?></option>
							</select>
						</div>

						<div class="form-group">
							<label class="font-weight-medium bg-light">Select Time Slot</label>
							<select class="form-control bg-light" required id="inlineFormCustomSelect" name="timeoption">
								<option value="10-13" <?php echo (isset($_GET['timeoption']) && $_GET['timeoption'] == "10-13") ? 'selected="selected"' : ''; ?>>10:00 AM - 1:00 PM</option>
								<option value="13-16" <?php echo (isset($_GET['timeoption']) && $_GET['timeoption'] == "13-16") ? 'selected="selected"' : ''; ?>>1:00 PM - 4:00 PM</option>
								<option value="16-19" <?php echo (isset($_GET['timeoption']) && $_GET['timeoption'] == "16-19") ? 'selected="selected"' : ''; ?>>4:00 PM - 7:00 PM</option>
							</select>
						</div>
					</div>

					<div class="text-center mt-4">
						<button type='submit' name='check' class='btn btn-check bg-success'>Confirm Selection</button>
					</div>
				</form>
			</div>
		</div>

		<div class="col-md-6">
			<div class="checkout-container">
				<h4 class="section-title">Order Summary</h4>
				<div class="d-flex justify-content-between align-items-center mb-4">
					<span class="font-weight-medium"><?php echo $c; ?> Items in Cart</span>
					<a href="cart.php" class="btn btn-outline-primary btn-sm">Edit Cart</a>
				</div>

				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th class="text-center">Image</th>
								<th class="text-center">Product Name</th>
								<th class="text-center">SubTotal</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$q2 = 0;
							$p2 = 0;
							$t2 = 0;
							foreach ($_SESSION['cart'] as $key => $values) {
								$item_name = $values['item_name'];
								$price = $values['price'];
								$quantity = $values['quantity'];
								$pimage = $values['image'];
								$q2 = $values['quantity'];
								$p2 = $values['price'];
								$t2 = $q2 * $p2;

								echo "<tr>
									<td class='align-middle text-center'>
										<img src='$pimage' class='img-fluid' style='max-height: 60px;'>
									</td>
									<td class='align-middle text-center'>
										$item_name
										<input type='hidden' class='iprice' name='pprice' value='$values[price]'>
									</td>
									<td class='align-middle text-center'>
										£$t2
										<input type='hidden' class='form-control text-center iquantity' onchange='subTotal()' id='inputQtry' min='1' max='20' name='quan' value='$values[quantity]'>
									</td>
								</tr>";
							}
							?>
						</tbody>
					</table>
				</div>

				<div class="border-top pt-3 mt-3">
					<div class="d-flex justify-content-between align-items-center">
						<h5 class="mb-0">Cart Subtotal</h5>
						<h5 class="mb-0" id="gtotal">£<?php echo $t; ?></h5>
					</div>
				</div>

				<div class="text-center mt-4">
					<form method="POST" action="<?php echo $paypal_url; ?>">
						<input type="hidden" name="business" value="<?php echo $paypal_email; ?>">
						<input type="hidden" name="cmd" value="_xclick">
						<?php
						$q2 = 0;
						$p2 = 0;
						$t2 = 0;
						$i = 0;
						foreach ($_SESSION['cart'] as $key => $values) {
							$item_name = $values['item_name'];
							$quantity = $values['quantity'];
							$price = $values['price'];
							$q2 = $values['quantity'];
							$p2 = $values['price'];
							$t2 = $q2 * $p2;
							$i = $i + 1;
							echo "<input type='hidden' name='item_name' value='$values[item_name]'>";
						}
						echo "<input type='hidden' name='amount' value='$totall'>
							  <input type='hidden' name='currency_code' value='GBP'>
							  <input type='hidden' name='item_number' value='$i'>
							  <input type='hidden' name='quantity' value='$q2'>
							  <input type='hidden' name='cancel_return' value='http://localhost:8000/cancel.php'>
							  <input type='hidden' name='return' value='http://localhost:8000/successful_checkout.php'>";
						?>

						<?php
						if (isset($_GET['ok'])) {
							echo "<input type='image' name='submit' border='0' class='paypal-button'
								  src='https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-large.png' 
								  alt='Buy now with PayPal'>";
						} else {
							echo "<input type='image' name='submit' border='0' disabled class='paypal-button'
								  src='disable.png' alt='Buy now with PayPal'>";
							echo "<div class='mt-3'><span class='badge badge-danger'>Please Choose Collection Slot Before Checking Out</span></div>";
						}
						?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var gt = 0;
	var iprice = document.getElementsByClassName('iprice');
	var iquantity = document.getElementsByClassName('iquantity');
	var itotal = document.getElementsByClassName('itotal');

	var gtotal = document.getElementById('gtotal');

	function subTotal() {
		gt = 0;
		for (i = 0; i < iprice.length; i++) {
			itotal[i].innerText = (iprice[i].value) * (iquantity[i].value);

			gt = gt + (iprice[i].value) * (iquantity[i].value);
		}
		gtotal.innerText = gt;
		$as = gt;
	}

	subTotal();
</script>
<?php
include 'end.php';
?>
<?php include 'footer.php'; ?>