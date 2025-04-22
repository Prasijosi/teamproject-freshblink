<?php include 'start.php';




$count = 0;

if (isset($_SESSION['cart'])) {
	$count = count($_SESSION['cart']);
}

if (!isset($_SESSION['username'])) {
	header('Location:sign_in_customer.php');
}
?>
<div class="container">
	<?php include 'header.php'; ?>
	<div class="row mt-5">
		<form method="POST" action="checkout.php" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-center mt-5 border">
			<div class="row">
				<div class="col-7 col-sm-7 col-md-7 col-lg-7 col-xl-7 p-5">
					<div class="h4 my-4 d-flex align-items-center justify-content-start">
						Shopping Cart ( <?php echo $count; ?> items )
					</div>
					<table class="table mt-2">
						<thead class="thead-dark">
							<tr>
								<th class="text-center" style='width:16.66666666666667%;'>
									Product Image
								</th>
								<th class="text-center" style='width:16.66666666666667%;'>
									Product Description
								</th>
								<th class="text-center" style='width:16.66666666666667%;'>
									Product Price
								</th>
								<th class="text-center" style='width:16.66666666666667%;'>
									Product Quantity
								</th>
								<th class="text-center" style='width:16.66666666666667%;'>
									Subtotal
								</th>
								<th class="text-center" style='width:16.66666666666667%;'>
								</th>
							</tr>
						</thead>
						<tbody class="border">

							<?php
							$total = 0;

							if (isset($_SESSION['cart'])) {
								foreach ($_SESSION['cart'] as $key => $value) {
									//$session ko index pass hunxa $key ma ani tyo index ma value laii $value ma pass gareko
									$pimage = $value['image'];
									$stock = $value['stock'];
									//$total=$total+$value['price'];  //if  item already exists then price will be added with existing  item price
									//print_r($value);  //for viewing items in array
									echo " 
									
									<tr>
								<td class='col d-flex align-items-center justify-content-center'>
									<a href='#'>
										<img src='$pimage' class='img-fluid'>
									</a>
								</td>
								<td class='col border' style='width:16.66666666666667%;'>
								$value[item_name]<input type='hidden' class='pname' name='pname' value='$value[item_name]'>
								</td>
								<td class='col border' style='width:16.66666666666667%;'>
								$value[price]<input type='hidden' class='iprice' name='pprice' value='$value[price]'>
								</td>
								<td class='col border' style='width:16.66666666666667%;'>
									
									<input type='number' class='form-control text-center iquantity' name='Mod_Quantity' onchange='this.form.submit()' id='inputQtry' min='1' max='$stock'  value='$value[quantity]'>
									<input type='hidden' name='item_name' value='$value[item_name]'>
									
								</td>
								
								<td class='col border itotal' style='width:16.66666666666667%;'>
								
								</td>
								<td class='col border' style='width:16.66666666666667%;'>
								
									<a href='manage_cart.php?value=$value[item_name] '><i name='remove' class='fas fa-times' style='font-size: 1.5vw; color: red;'></i></a>
									
								</td>
							</tr>";
								}
							}
							?>

						</tbody>
					</table>

					<div class="row my-5">
						<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
							<a href="index.php">
								<button type="button" class="btn btn-info" name="continue_shopping" id="continue_shopping" style="font-size: 0.9vw;">Continue Shopping</button>
							</a>
						</div>
						<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
						</div>
						<?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
							//if cart number is greater than 1 then only show clear cart button

							echo " <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-end'>
							<a href='manage_cart.php?d'>
							
							<button type='button'  class='btn btn-secondary' name='clear_cart' style='font-size: 0.9vw;'>Clear Cart</button>
							</a>
							</div>	
						</div>
					</div>
				<div class='col-5 col-sm-5 col-sm-5 col-md-5 col-md-5 col-lg-5 border p-5'>
                	<!-- Voucher for Discount (Optional)
                	<div class='row mt-5'>
                    	<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start'>
                        	<div class='h6'>Use Voucher</div>
                    </div>
                    <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-start'>
                        <input type='text' class='form-control' id='inputVoucher'>
                    </div>
                    <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-end'>
                        <button type='submit' class='btn btn-success mt-2' name='voucher'>Apply</button>
                    </div>
                    -->
                    <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 my-4 h3'>Summary</div>
                    <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 border-top'>
                        <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h6 mt-2'></div>
                    </div>
                    <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 h6'>
                        <div class='row'>
                            <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 h6'>Discount</div>
                            <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 h6'>Rs. ***</div>
                        </div>
                        <div class='row my-3'>
                            <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 h6'>Sub-Total</div>
                            <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 h6' >Rs. ***</div>
                        </div>
                        <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h6 mt-2'></div>
                        <div class='row mt-3'>
                            <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 h5 mt-3'>Order Total</div>
                            <div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 h5 mt-3 ' id='gtotal'>
                            
                            </div>

                            
                            
                        </div>
                        
                        <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h6 mt-2'></div>
                    </div>
                    <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 h6' ></div>
                    <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 w-100 mt-1 mb-5'>
                        <button type='submit' class='btn btn-success mt-2 w-100' name='checkout'>
                            PROCEED TO CHECKOUT
                        </button>
                    </div>
                </div>
            </div>
            </div>
			</form>


			";
						} ?>



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