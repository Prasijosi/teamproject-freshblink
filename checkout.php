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

						}

						else{

							include "connection.php";

							$sql50="update cart set TOTAL_PRICE = $item_quantity where customer_id=$cid and product_id=$pid";
							$result50 = oci_parse($connection, $sql50);
							oci_execute($result50);

							if ($result50) {
								echo " <script>
				alert('Cart Updated');
				window.location.href='checkout.php';
				</script>";
							}
							else{
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

 $totall=0;//cart ko price
include('connection.php');
$cid2=$_SESSION['customer_id'] ;
$sql20 = " SELECT * FROM cart WHERE customer_Id = '$cid2'";
		$result20 = oci_parse($connection, $sql20);
		oci_execute($result20);

		while ($row = oci_fetch_array($result20)) {
			$cpid=$row['PRODUCT_ID'];  //cart ko product id
			$cq=$row['TOTAL_PRICE']; //cart ko quantity

			include('connection.php');

$sql21 = " SELECT * FROM product WHERE PRODUCT_ID = '$cpid'";
		$result21 = oci_parse($connection, $sql21);
		oci_execute($result21);

		while ($row = oci_fetch_array($result21)) {
				$pprice=$row['PRODUCT_PRICE'];
				$subtotal=$pprice*$cq;

		}
		$totall=$subtotal+$totall;





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


<div class="container">
	<?php
	include 'header.php';
	if (isset($_GET['msg'])) {
		echo "<h4 style='text-align: center; color:red;'>" . $_GET['msg'] . "</h4>";
	}
	?>







	<div class="row mt-3 p-5">
		<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-5 border">
			<form method="POST" action="checkout.php">
				<div class="row">

					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h4 mt-5 d-flex align-items-center justify-content-start">
						Billing Details
					</div>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-4">
						<div class="row my-4">
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
								<label for="inputEmail" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label d-flex align-items-center justify-content-center h6">Email : </label>
							</div>
							<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
								<div class="form-group">
									<input type="email" value="<?php echo $_SESSION['email'];  ?>" class="form-control d-flex align-items-center justify-content-center" id="inputEmail" name="email" placeholder="Email Address" required>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="row">
						<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<label for="inputphoneNumber" class="d-flex align-items-center justify-content-center h6 ">Phone Number : </label>
						</div>
						<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
							<div class="form-group">
								<input type="text" class="form-control d-flex align-items-center justify-content-center " name="phone" id="inputphoneNumber" placeholder="Phone Number" value="<?php if (isset($_GET['phone'])) {
																																																	echo $_GET['phone'];
																																																}  ?>" required>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12  mt-5 d-flex align-items-center justify-content-start">
					<span class="h4 mt-5">
						Choose your Date & Collection Time
					</span>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h4 d-flex align-items-center justify-content-center mt-3">
					<?php
					date_default_timezone_set('Asia/Kathmandu');
					$date = date("Y-m-d");
					//$date = date("2021-07-01");
					//echo $date;
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




					echo "<br>";
					?>

					<select class="mx-auto" required id="inlineFormCustomSelect" name="taskoption">
						<option value="<?php echo $x1 ?>" <?php echo (isset($_GET['taskoption']) && $_GET['taskoption'] == "$x1") ? 'selected="selected"' : ''; ?>><?php echo $x1 ?></option>
						<option value="<?php echo $y2 ?>" <?php echo (isset($_GET['taskoption']) && $_GET['taskoption'] == "$y2") ? 'selected="selected"' : ''; ?>><?php echo $y2 ?></option>
						<option value="<?php echo $z3 ?>" <?php echo (isset($_GET['taskoption']) && $_GET['taskoption'] == "$z3") ? 'selected="selected"' : ''; ?>><?php echo $z3 ?></option>
					</select>
					<select class="mx-auto" required id="inlineFormCustomSelect" name="timeoption">
						<option value="10-13" <?php echo (isset($_GET['timeoption']) && $_GET['timeoption'] == "10-13") ? 'selected="selected"' : ''; ?>><?php echo "10-13" ?></option>
						<option value="13-16" <?php echo (isset($_GET['timeoption']) && $_GET['timeoption'] == "13-16") ? 'selected="selected"' : ''; ?>><?php echo "13-16" ?></option>
						<option value="16-19" <?php echo (isset($_GET['timeoption']) && $_GET['timeoption'] == "16-19") ? 'selected="selected"' : ''; ?>><?php echo "16-19" ?></option>
					</select>



				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-4">
					<button type='submit' name='check' class='btn btn-info'>Check</button>
				</div>







			</form>
		</div>





		<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 p-5">
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h4 mt-5">
					Order Summary
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 border-bottom">
				</div>
				<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start h6 mt-5">
					<?php echo $c; ?> Items in Cart
				</div>
				<div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-end h6 mt-5">
					<a href="cart.php">
						Edit
					</a>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start mt-3">
					<table class="table mt-2">
						<thead class="thead-dark">
							<tr>
								<th class="text-center h6" style="width: 33.33333333333333%;">
									Image
								</th>
								<th class="text-center h6" style="width: 33.33333333333333%;">
									Product Name
								</th>
								<th class="text-center h6" style="width: 33.33333333333333%;">
									SubTotal
								</th>
							</tr>
						</thead>
						<tbody class="border">
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
										<td class='col d-flex align-items-center justify-content-center'>
												<a href='#'>
													<img src='$pimage' class='img-fluid'>
												</a>
											</td>
											<td class='col-12 col-sm-12 border text-center' style='width: 33.33333333333333%;'>
											$item_name
											<input type='hidden' class='iprice' name='pprice' value='$values[price]'>
											</td>
											<td class='col border text-center' style='width: 33.33333333333333%;'>
											$t2
											<input type='hidden' class='form-control text-center iquantity' onchange='subTotal()' id='inputQtry' min='1' max='20' name='quan' value='$values[quantity]'>
											</td>

											
										</tr>";
							}
							?>
						</tbody>
					</table>
				</div>
				<!-- <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start h6 my-3'>
						Cart Subtotal
						</div>
						<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-end h6 my-3'>
							Rs ***
						</div> -->
				<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 border mt-5'></div>
				<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start h5 my-4'>
					Cart Subtotal
				</div>
				<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-end h5 my-4' id="gtotal">
					<?php echo $t; ?>
				</div>
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">









				</div>





				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center">
					<form method="POST" action="<?php echo $paypal_url; ?>">

						<!-- Paypal business test account email id so that you can collect the payments. -->
						<input type="hidden" name="business" value="<?php echo $paypal_email; ?>">
						<!-- Buy Now button. -->
						<input type="hidden" name="cmd" value="_xclick">
						<!--   <input type="hidden" name="cmd" value="_cart"> default/don't change-->

						<!--	<input type="hidden" name="upload" value="1"> -->

						<!-- Details about the item that buyers will purchase. -->
						<!-- Details about the item that buyers will purchase. -->

						<!--
	 $q2 = 0;
	$p2 = 0;
	$t2 = 0;
	
		$i=0;
	foreach ($_SESSION['cart'] as $key => $values)  {
		$item_name = $values['item_name'];
		$quantity = $values['quantity'];
		$price = $values['price'];
		
	
		$q2 = $values['quantity'];
		$p2 = $values['price'];

		$t2 = $q2 * $p2;

		$i=$i+1;
			echo " 

			<input type='hidden' name='item_name_$i' value='$q2 X $values[item_name]'>
	<input type='hidden' name='item_number_$i' value='$i'>
	
	<input type='hidden' name='amount_$i' value='$p2'>
	<input type='hidden' name='quantity_$i' value='$q2'>


	

	<input type='hidden' name='currency_code' value='GBP'>	
 ";	
 
	}

	-->

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
							echo " 

			<input type='hidden' name='item_name' value='$values[item_name]'>



	

		
 ";
						}

						echo " 
						<input type='hidden' name='amount' value='$totall'>
						<input type='hidden' name='currency_code' value='GBP'>
						<input type='hidden' name='item_number' value='$i'>

						";

						?>

							
	
	
	<input type='hidden' name='quantity' value='$q2'>
						<!-- URLs -->
						<input type='hidden' name='cancel_return' value='http://localhost/testing/goCart/cancel.php'>
						<!--Change according to requirement-->

						<input type='hidden' name='return' value='http://localhost/testing/goCart/successful_checkout.php'>




						<?php

						if (isset($_GET['ok'])) {


							echo " 
			<input type='image' name='submit' border='0'
			src='https://www.paypalobjects.com/webstatic/en_US/i/buttons/buy-logo-large.png' alt='Buy now with PayPal' alt='PayPal - The safer, easier way to pay online'>
			<img alt='' border='0' width='1' height='1' src='https://www.paypalobjects.com/en_US/i/scr/pixel.gif' > 
			";
						} else {

							echo " 
			<input type='image' name='submit' border='0' disabled
			src='disable.png' alt='Buy now with PayPal' alt='PayPal - The safer, easier way to pay online'>
			<img alt='' border='0' width='1' height='1' src='https://www.paypalobjects.com/en_US/i/scr/pixel.gif' > 
			";

							echo "<br><span class='badge badge-pill badge-danger'>Please Choose Any Collection Slots Before Checking Out</span>";
						}
						?>


					</form>
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
	include 'footer.php';
	include 'end.php';
	?>