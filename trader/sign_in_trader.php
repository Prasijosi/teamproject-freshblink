<?php include '../start.php'; ?>
<div class="container w-100 d-flex align-items-center justify-content-center">
	<div class="row mt-5">
		<?php
		if (isset($_GET['msg'])) {
			$user_created_msg = $_GET['msg'];
			echo "<div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 mt-2 d-flex align-items-center justify-content-center' style='color:red;'>" . $user_created_msg . "
		            </div>";
		}
		?>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center mt-5">
			<a href="../index.php">
				<img src="../images/logo.png" class="img-fluid" style="width: 70px; height: 70px;">
			</a>
		</div>
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center mt-3">
			<form method="POST" action="trader_sign_in.php">
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
						<div class="h4">Trader/Admin : Sign-In</div>
					</div>
				</div>
				<div class="form-group row">
					<label for="inputEmail" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Email</label>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<input type="email" class="form-control" id="inputEmail" placeholder="Email" required name="email" value="<?php if (isset($_COOKIE["email"])) {
																																echo $_COOKIE["email"];
																															}  ?>">
					</div>
				</div>
				<div class="form-group row">
					<label for="inputPassword" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Password</label>
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
						<input type="password" class="form-control" id="inputPassword" placeholder="Password" required name="password" value="<?php if (isset($_COOKIE["password"])) {
																																			echo $_COOKIE["password"];
																																		}  ?>">
					</div>
				</div>

				<div class="form-group row">
					<select id="sort" class="selectpicker form-control  " name="c">
						<option value="t" <?php echo (isset($_POST['c']) && $_POST['c'] == "t") ? 'selected="selected"' : ''; ?>>Traders</option>
						<option value="a" <?php echo (isset($_POST['c']) && $_POST['c'] == "a") ? 'selected="selected"' : ''; ?>>Admin</option>
					</select>
				</div>


				<div class="form-group row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
						<div class="form-check">
							<input class="form-check-input" type="checkbox" id="checkBox" value="<?php if (isset($_COOKIE["email"])) { ?> checked <?php }  ?>">
							<label class="form-check-label" for="checkBox">
								Remember Me
							</label>
						</div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center ml-2">
						<button type="submit" class="btn btn-success" name="submit">Sign In</button>
					</div>
				</div>
				<div class="row">
					<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
						<a href="sign_up_trader.php" style="font-size: 16px">Wanna be one of Us? Sign Up Here</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<?php include '../end.php' ?>