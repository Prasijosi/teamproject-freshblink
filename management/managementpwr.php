<?php
session_start();
include 'theader.php';

if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
	echo "<script>alert('" . $msg . "');</script>";
} else {
	echo "";
}

//SELECT * FROM `order` INNER JOIN `product` INNER JOIN `shop` INNER JOIN `trader` ON trader.Trader_Id=shop.Trader_id  ON shop.Shop_Id=product.Shop_Id AND order.Product_Id=product.Product_Id where shop.Trader_id='4001'

?>
<div class="container-fluid main-content">

	<h3>Trader Product Overview</h3>
	<h4>Manage Product</h4> <br>

	<div class="table-responsive">
		<table id="myTable" class="table table-bordered" width="100%">
			<div class="row">
				<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center justify-content-start">
					<?php
					include 'connection.php';
					$sql = " SELECT * FROM  product, shop, trader where trader.Trader_Id=shop.Trader_id and shop.Shop_Id=product.Shop_Id  and product.Product_Verification='1' ";
					$qry = oci_parse($connection, $sql);
					oci_execute($qry);
					$count2 = oci_fetch_all($qry, $connection);
					oci_execute($qry);

					echo "<h5>Active Products $count2</h5>";
					?>
				</div>
				<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center justify-content-start">
					<?php
					include 'connection.php';
					$sql = " SELECT * FROM  product , shop, trader where trader.Trader_Id=shop.Trader_id and shop.Shop_Id=product.Shop_Id and product.Product_Verification='0' ";
					$qry = oci_parse($connection, $sql);
					oci_execute($qry);
					$count3 = oci_fetch_all($qry, $connection);
					oci_execute($qry);

					echo "<h5>Disabled  $count3</h5>";
					?>

				</div>

				<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center justify-content-end">
					<form action="#" method="GET">

						<label>Sort By:</label>
						<select name="category" class="category">
							<option value="All" class="ml-1">Recent </option>

						</select>
					</form>
				</div>
			</div>

			<thead>
				<tr class="bg-dark text-white">
					<th>SN</th>
					<th>Trader Name</th>
					<th>Shop</th>
					<th>Product Image</th>
					<th>Product Name</th>

					<th>Product Type</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>


				<?php
				include 'connection.php';
				$sql = " SELECT * FROM  product, shop, trader where trader.Trader_Id=shop.Trader_id  and shop.Shop_Id=product.Shop_Id   ";
				$qry = oci_parse($connection, $sql);
				oci_execute($qry);
				$s = 0;
				while ($row = oci_fetch_assoc($qry)) {
					$pid = $row['PRODUCT_ID'];
					$tname = $row['NAME'];
					$sname = $row['SHOP_NAME'];
					$pimage = $row['PRODUCT_IMAGE'];
					$pname = $row['PRODUCT_NAME'];
					$ptype = $row['PRODUCT_TYPE'];
					$check = $row['PRODUCT_VERIFICATION'];
					$s = $s + 1;
					echo "
					<tr>
					<td class='text-center'>$s</td>
					<td class='text-center'>$tname</td>
					<td class='text-center'>$sname</td>
					<td class='text-center'><img src=' ../" . $pimage . "' class='img-fluid' style='width: 10vw; ' ></td>
					<td class='text-center'>$pname</td>

					<td class='text-center'>$ptype</td>

					 <form method='POST' action='manage_product_process.php'>
					 <input type='hidden'  name='pid' value='$pid'>

						";

					echo "<td class='actionbtn'>";
					if ($check == 1) {
						echo "
								<button type='submit' class='btn btn-success' name='submit' disabled >Enable</button>
					<br>
					<button type='submit' class='btn btn-danger' name='submit1' >Disable</button>
					";
					} else {
						echo "
								<button type='submit' class='btn btn-success' name='submit'  >Enable</button>
					<br>
					<button type='submit' class='btn btn-danger' name='submit1' disabled >Disable</button>
					";
					}

					echo

					"




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