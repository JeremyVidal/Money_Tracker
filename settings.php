<?PHP
session_start();
require('includes/db_conn.php');
$current_user =  $_SESSION['userID'];
// this sets the session variable from the side nav bar
if (isset($_POST['personalsidesubmit'])){
    $_SESSION['settings_display_id'] = "Personal";
    ?><script type="text/javascript">location.href='settings.php';</script><?
}
else if (isset($_POST['jobsidesubmit'])){
    $_SESSION['settings_display_id'] = "Job";
    ?><script type="text/javascript">location.href='settings.php';</script><?
}
else if (isset($_POST['accountsidesubmit'])){
    $_SESSION['settings_display_id'] = "Account";
    ?><script type="text/javascript">location.href='settings.php';</script><?

}
// this adds an account to be used in payments.php
if (isset($_POST['account_add_submit'])){
    // print_r($_POST);
    $accountCategory = $_POST['account_category_add'];
    $accountType = $_POST['account_type_add'];
    $accountName = $_POST['account_name_add'];
    $accountNumber = $_POST['account_number_add'];
    $accountStreet = $_POST['account_street_add'];
    $accountStreet2 = $_POST['account_street2_add'];
    $accountCity = $_POST['account_city_add'];
    $accountState = $_POST['account_state_add'];
    $accountZip = $_POST['account_zip_add'];
    $accountPhone = $_POST['account_phone_add'];
    if ($_POST['account_beginamount_add'] == ""){
        $accountBeginAmount = 0;
    }
    else{
        $accountBeginAmount = $_POST['account_beginamount_add'];
    }
    $accountPayment = $_POST['account_payment_add'];
    $accountDueDate = $_POST['account_duedate_add'];
    $accountDueTime = $_POST['account_duetime_add'];
    
    $addAccount = "INSERT INTO `account` (`accountID`, `accountCategory`, `accountType`, `accountName`,  `accountNumber`,  `accountStreet`,  `accountStreet2`, `accountCity`, `accountState`, `accountZip`, `accountPhone`,`accountBeginAmount`,`accountPayment`,`accountDueDate`,`accountDueTime`,`userID`)
        VALUES (NULL, '$accountCategory','$accountType','$accountName','$accountNumber','$accountStreet','$accountStreet2','$accountCity','$accountState','$accountZip','$accountPhone','$accountBeginAmount','$accountPayment','$accountDueDate','$accountDueTime','$current_user')"; 
    $conn->query($addAccount);
    ?><script type="text/javascript">location.href='settings.php';</script><?

}
else if (isset($_POST['accountdeleteID'])){
    $deleteID = $_POST['accountdeleteID'];
    $deleteAccount = "DELETE FROM `account` WHERE accountID = '$deleteID'";
    $conn->query($deleteAccount);
    ?><script type="text/javascript">location.href='settings.php';</script><?

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel='stylesheet' href="javascript/bootstrap-4.0.0/css/bootstrap.min.css">

	<title>Settings</title>
</head>
<body>
	<style> 
	.settings_img {width: 20px}
	.settings_button {border: none; background-color: white;}

	/* #header {display: none;}
	#navigation {display: none;} */
	#wrapper {overflow-x: hidden;}
	#sidebar-wrapper {
		min-height: 100vh;
		margin-left: -15rem;
		-webkit-transition: margin .25s ease-out;
		-moz-transition: margin .25s ease-out;
		-o-transition: margin .25s ease-out;
		transition: margin .25s ease-out;}
	#sidebar-wrapper .sidebar-heading {padding: 0.875rem 1.25rem; font-size: 1.2rem;}
	#sidebar-wrapper .list-group {width: 15rem;}
	#page-content-wrapper {min-width: 100vw;}
	#wrapper.toggled #sidebar-wrapper {margin-left: 0;}

	@media (min-width: 768px) {
	#sidebar-wrapper { margin-left: 0;}
	#page-content-wrapper {min-width: 0; width: 100%;}
	#wrapper.toggled #sidebar-wrapper {margin-left: -15rem;}
	#menu_toggle {background-color: #4f81bc; color: white;}
	.main-section{border:1px solid #138496; background-color: #fff; }
	.profile-header{background-color: #4f81bc; height:125px;}
	.user-detail{margin:-50px 0px 30px 0px;}
	.user-detail img{width:150px;}
	.user-detail h5{margin:15px 0px 5px 0px;}
	.user-footer-detail{padding:15px 0px; background-color: #4f81bc;}
	#account_add_submit {background-color: #4f81bc; color: white; margin-left: 15px;}
	}
	</style>
	<div class="d-flex" id="wrapper">
		<!-- Sidebar -->
		<div class="bg-light border-right" id="sidebar-wrapper">
			<div class="sidebar-heading">Settings </div>
			<div class="list-group list-group-flush">
				<form name="acct" action="settings.php" method="POST">
					<input type="submit" class="list-group-item list-group-item-action bg-light" name="personalsidesubmit" value="Personal Info">
				</form>
				<form name="acct" action="settings.php" method="POST">
					<input type="submit" class="list-group-item list-group-item-action bg-light" name="jobsidesubmit" value="Job Info">
				</form>
				<form name="acct" action="settings.php" method="POST">
					<input type="submit" class="list-group-item list-group-item-action bg-light"name="accountsidesubmit" value="Accounts">
				</form>
				

				<form name="acct" action="dashboard.php" id="exit_button" method="POST">
					<input type="submit" class="list-group-item list-group-item-action bg-light" value="Exit">
				</form>
			</div>
		</div>
		<div id="page-content-wrapper">
			<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
					<button class="btn" id="menu_toggle">Menu</button>
					<!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span> -->
					</button>
			</nav>

			<div class="container-fluid">
				<!-- Main section data goes here! -->
				<?PHP
				if(isset($_SESSION['settings_display_id'])){
					if($_SESSION['settings_display_id'] == "Personal"){
						personal_display();
					}
					else if($_SESSION['settings_display_id'] == "Job"){
						job_display();
					}
					else if($_SESSION['settings_display_id'] == "Account"){
						account_add_form();
					}
				}
				function personal_display(){
					require('includes/db_conn.php');
					$current_user =  $_SESSION['userID'];
					?>
					<!-- <div class="container">
						<div class="row">
							<div class="col-lg-12"> -->
								<?PHP
								$results = $conn->query("SELECT * FROM `personal` WHERE `userID` = '$current_user';");
								while($data = $results->fetch()){
									$firstName = $data['firstName'];
									$lastName = $data['lastName'];
									$birthDate = $data['birthDate'];
									$userName = $data['userName'];
									$userEmail = $data['userEmail'];
									$createdAt = $data['createdAt'];
									?>
									<div class="row justify-content-center" style="margin: 25px;">
										<div class="col-lg-5 main-section">
											<div class="row">
												<div class="col-sm-12 profile-header text-center" style="padding-top: 20px; color: white;"><h3>User Information</h3></div>
											</div>
											<div class="row user-detail text-center">
												<div class="col-lg-12">
													<img src="media/profile_pic.png" class="rounded-circle ">
													<h5><?PHP echo $firstName . ' ' . $lastName; ?></h5>
												</div>
											</div>
											<div class="row">
												<div class="col-lg-12">
													<form  class="form" name="ledger_add" action="ledger.php" method="POST">
														<div class="row">
															<div class="col-lg-6">
																<div class="form-group">
																	<label>First Name</label>
																	<input type="text" class="form-control mb-4" name="ledgerdate" value="<?PHP echo $firstName; ?>" >
																</div>
															</div>
															<div class="col-lg-6">
																<div class="form-group">
																	<label>Last Name</label>
																	<input type="text" class="form-control mb-4" name="ledgerdate" value="<?PHP echo $lastName; ?>" >
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-6">
																<div class="form-group">
																	<label>Birthdate </label>
																	<input type="date" class="form-control mb-4" name="ledgerdate" value="<?PHP echo $birthDate; ?>" >
																</div>	
															</div>	
															<div class="col-lg-6">
																<div class="form-group">
																	<label>User Name </label>
																	<input type="text" class="form-control mb-4" name="ledgerdate" value="<?PHP echo $userName; ?>" >
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-lg-12">
																<div class="form-group">
																	<label>Email </label>
																	<input type="email" class="form-control mb-4" name="ledgerdate" value="<?PHP echo $userEmail; ?>" >
																</div>
															</div>
														</div>	
													</form>
												</div>
											</div>
											<div class="row user-footer-detail">
												<div class="col-lg-12 col-sm-12 col-12">
													<div class="d-flex justify-content-between">
														<a href="#" class="btn btn-success btn-sm">Update Info</a>
														<a href="#" class="btn btn-danger btn-sm">Delete Account</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?PHP
								};?>
							<!-- </div>
						</div>
					</div> -->
				<?PHP
				}
				function job_display(){
					require('includes/db_conn.php');
					$current_user =  $_SESSION['userID'];
					?>
					<div class="row" style="margin-top: 25px;">
						<div class="col-lg-12">
							<table class="table table-striped table-sm">
							<tr><th>Name</th><th>Street</th><th>City</th><th>State</th><th>Zip</th><th>Phone</th><th>Start Date</th></tr>
							<?PHP
							$results = $conn->query("SELECT * FROM `employment` WHERE `userID` = '$current_user';");
							while($data = $results->fetch()){
								$companyName = $data['companyName'];
								$companyStreet = $data['companyStreet'];
								$companyCity = $data['companyCity'];
								$companyState = $data['companyState'];
								$companyZip = $data['companyZip'];
								$companyPhone = $data['companyPhone'];
								$companyStartDate = $data['companyStartDate'];
								echo "<tr><td>$companyName</td><td>$companyStreet</td><td>$companyCity</td><td>$companyState</td><td>$companyZip</td><td>$companyPhone</td><td>$companyStartDate</td></tr>";
							};?>
							</table>
						</div>
					</div>
				<?PHP
				}
				function account_add_form(){
					require('includes/db_conn.php');
					$current_user =  $_SESSION['userID'];
					?>
					<div class="container" style="margin-top: 25px;">
						<div class="row">
							<div class="col-lg-12">
									<!-- <section id="account_info"> -->
								<div class="d-flex justify-content-between">
									<div>
										<h3>Add Account <span style="color: red; font-size: 12px;">*</span> <span style="font-size: 12px;">required</span></h3>
									</div>
								</div>
							</div>
						</div>
						<form id="account_add_form" name="account_add_form" action="settings.php" method="POST">
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="account_category_add">Category <span style="color: red;">*</span></label>
										<input list="account_categories" class="form-control" name="account_category_add" id="account_category_add" required>
											<datalist id="account_categories">
												<option value="Bill">
												<option value="Collection">
											</datalist>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
									<label for="account_type_add">Type <span style="color: red;">*</span></label>
									<input list="account_types" class="form-control" name="account_type_add" id="account_type_add" required>
										<datalist id="account_types">
											<option value="Rent">
											<option value="Electric">
											<option value="Gas(house)">
											<option value="Water">
											<option value="Loan">
											<option value="Previous">
											<option value="Car Insurance">
											<option value="Storage">
											<option value="Phone">
											<option value="Judgement">
										</datalist>
									</div>
								</div>
							</div>									
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="account_name_add">Name <span style="color: red;">*</span></label>
										<input type='text' id="account_name_add" class="form-control" name="account_name_add" required>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="account_phone_add">Phone <span style="font-size: 10px;">(no characters)</span></label>
										<input type='phone' id="account_phone_add" class="form-control" name="account_phone_add" maxlength="10">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="account_number_add">Acct #</label>
										<input type='text' id="account_number_add" class="form-control" name="account_number_add">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="account_name_add">Street </label>
										<input type='text' id="account_street_add" class="form-control" name="account_street_add">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="account_street2_add">Street2 </label>
										<input type='text' id="account_street2_add" class="form-control" name="account_street2_add">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4">
									<div class="form-group">
										<label for="account_city_add">City</label>
										<input type='text' id="account_city_add" class="form-control" name="account_city_add">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="account_state_add">State <span style="font-size: 10px;">(abbrev)</span></label>
										<input type='text' id="account_state_add" class="form-control" name="account_state_add" maxlength="2">
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label for="account_zip_add">Zip </label>
										<input type='text' id="account_zip_add" class="form-control" name="account_zip_add" maxlength="5">
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-3">
									<div class="form-group">
										<label for="account_beginamount_add">Begin Amount </label>
										<input type='number' id="account_beginamount_add" class="form-control" name="account_beginamount_add" min="0.00" step="0.01">
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label for="account_payment_add">Payment <span style="color: red;">*</span></label>
										<input type='number' id="account_payment_add" class="form-control" name="account_payment_add" min="0.00" step="0.01" required>
									</div>
								</div>
							<!-- </div>
							<div class="row"> -->
								<div class="col-lg-3">
									<div class="form-group">
									<label for="account_duedate_add">Day Due <span style="color: red;">*</span></label>
										<select id="account_duedate_add" class="form-control" name="account_duedate_add" required>
											<option value="01">1st</option>
											<option value="02">2nd</option>
											<option value="03">3rd</option>
											<option value="04">4th</option>
											<option value="05">5th</option>
											<option value="06">6th</option>
											<option value="07">7th</option>
											<option value="08">8th</option>
											<option value="09">9th</option>
											<option value="10">10th</option>
											<option value="11">11th</option>
											<option value="12">12th</option>
											<option value="13">13th</option>
											<option value="14">14th</option>
											<option value="15">15th</option>
											<option value="16">16th</option>
											<option value="17">17th</option>
											<option value="18">18th</option>
											<option value="19">19th</option>
											<option value="20">20th</option>
											<option value="21">21st</option>
											<option value="22">22nd</option>
											<option value="23">23rd</option>
											<option value="24">24th</option>
											<option value="25">25th</option>
											<option value="26">26th</option>
											<option value="27">27th</option>
											<option value="28">28th</option>
											<option value="29">29th</option>
											<option value="30">30th</option>
											<option value="31">31st</option>
										</select>
									</div>
								</div>
								<div class="col-lg-3">
									<div class="form-group">
										<label for="account_payment_add">Time Due <span style="color: red;">*</span></label>
										<input type='time' id="account_duetime_add" class="form-control" name="account_duetime_add" required>
									</div>
								</div>
							</div>
							<button class="btn" type="submit" id="account_add_submit" name="account_add_submit">Add Account</button>
						</form>
						<br/>
						<hr/>
						<div class="row">
							<div class="col-lg-12">
								<h3>Current Accounts</h3>
								<table class="table table-sm">
									<tr><th>Category</th><th></th><th>Type</th><th></th><th>Name</th><th>Acct Number</th><th>Payment</th><th>Day Due</th><th></th></tr>
									<?PHP
									$results = $conn->query("SELECT * FROM `account` WHERE `userID` = '$current_user' ORDER BY `accountDueDate`;");
									while($data = $results->fetch()){
										$accountID = $data['accountID'];
										$accountCategory = $data['accountCategory'];
										$accountType = $data['accountType'];
										$accountName = $data['accountName'];
										$accountNumber = $data['accountNumber'];
										$accountPayment = $data['accountPayment'];
										$accountDueDate = $data['accountDueDate'];
										if ($accountPayment == NULL){
											$accountSymbol = '';
										}
										else{
											$accountSymbol = "$";
										}
										echo "<tr>
												<td>$accountCategory</td><td><img class=\"settings_img\" src=\"media/$accountType.png\"></td><td>$accountType</td><td><img class=\"settings_img\" src=\"media/companies/$accountName.png\"></td><td>$accountName</td><td>$accountNumber</td><td>$accountSymbol $accountPayment</td><td style=\"text-align: center;\">$accountDueDate</td>
												<td>
													<form id=\"account_delete\" name=\"account_delete\" action=\"\" method=\"POST\">
														<input type=\"hidden\" name=\"accountdeleteID\" value=\"$accountID\">
														<button class=\"settings_button\"><img class=\"settings_img\" src=\"media/delete.ico\"></button>
													</form>
												</td>
											</tr>";
									};?>
								</table>
							</div>
						</div>
					</div>
				<?PHP
				}
				?>
			</div>
		</div>
	</div>
	 <!-- Bootstrap core JavaScript -->
	<script src="javascript/jquery/jquery.min.js"></script>
  	<script src="javascript/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	
  	<!-- Menu Toggle Script -->
  	<script>
    	$("#menu_toggle").click(function(e) {
      	e.preventDefault();
      	$("#wrapper").toggleClass("toggled");
    	});
  	</script>

</body>
</html>