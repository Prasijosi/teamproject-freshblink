<?php
session_start();
include 'theader.php';
if (isset($_GET['msg'])) {
	$msg = $_GET['msg'];
	echo "<script>alert('" . $msg . "');</script>";
} else {
	echo "";
}


?>
<div class="container-fluid main-content">

	<h3>Traders Overview</h3>
	<h4>Manage New Trader or Shop</h4> <br>
	<div class="table-responsive">
		<table id="myTable" class="table table-bordered" width="100%">
			<table id="myTable" class="table table-bordered" width="100%">
				<div class="row">
					<div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center justify-content-start">
					<?php
					include 'connection.php';

					$sql = " SELECT * FROM   shop, trader where trader.Trader_Id=shop.Trader_id   and shop.Shop_Verification='0'";
					$qry = oci_parse($connection, $sql);
					oci_execute($qry);

					$count3 = oci_fetch_all($qry, $connection);
					oci_execute($qry);

					echo "<h5>$count3 New Trader or Shop Request</h5>";
					?>
					</div>

					<div class="col-8 col-sm-8 col-md-8 col-lg-8 col-xl-8 d-flex align-items-center justify-content-end">
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
						<th>Shop Name</th>
						<th>Shop Details</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
					include('connection.php');
					$sql = "SELECT * FROM shop, trader WHERE shop.Trader_id=trader.Trader_Id AND Shop_Verification='0'";
					$qry = oci_parse($connection, $sql);
					oci_execute($qry);
					$s = 0;
					while ($row = oci_fetch_assoc($qry)) {
						$tid=$row['TRADER_ID'];
						$sid = $row['SHOP_ID'];
						$tname = $row['NAME'];
						$sname = $row['SHOP_NAME'];
						$sdetails = $row['SHOP_DESCRIPTION'];

						$s = $s + 1;

						echo " 
						<tr>  
						<td class='text-center'>$s</td>  
						<td class='text-center'>$tname</td> 
						
						<td class='text-center'>$sname</td>  
						<td class='text-center'>$sdetails</td>
						
					
						 <form method='POST' action='manage_shop_admin.php'>
						 <input type='hidden'  name='sid' value='$sid'>
						 <input type='hidden'  name='tid' value='$tid'>
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