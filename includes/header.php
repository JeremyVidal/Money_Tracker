<?PHP
session_start();
require('includes/db_conn.php');
$script = $_SERVER['PHP_SELF'];
$script = str_replace("/", "", "$script"); $script = str_replace(".php", "", "$script");
$CURRENT_DATE = date("Y-m-d");
$CURRENT_MONTH = date("n");
$CURRENT_YEAR = date("Y");
// $_SESSION['userID'] = 1;

if($script == 'index'){
    $script = 'Login Form';
}
if($script == 'signup'){
    $script = 'Sign Up Form';
}
if($script == 'dashboard'){
    $script = 'Dashboard';
}
if($script == 'ledger'){
    $script = 'Ledger';
}
if($script == 'income'){
    $script = 'Income';
}
if($script == 'payments'){
    $script = 'Payments';
}
if($script == 'contact'){
    $script = 'Contact';
}
if($script == 'settings'){
    $script = 'Settings';
}
if($script == 'editpayment'){
    $script = 'Edit Payment';
}
if($script == 'editcontact'){
    $script = 'Edit Contact';
}
if($script == 'editincome'){
    $script = 'Edit Income';
}
if($script == 'deletecontactconfirm'){
    $script = 'Delete Contact';
}
if($script == 'deleteincomeconfirm'){
    $script = 'Delete Income';
}
if($script == 'deletepayconfirm'){
    $script = 'Delete Payment';
}
if($script == 'paymentdoc'){
    $script = 'Print Payment';
}
if($script == 'paymentenv'){
    $script = 'Print Envelope';
}
?>
<!doctype html>
<html lang="en">
<head>
<title><?PHP echo $script?></title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- <meta name="viewport" content="width=device-width" /> -->
<meta name="keywords" content="Keywords..." />
<meta name="description" content="Description..." /> 
<meta name=”robots” content=”noindex”>
<link rel="stylesheet" href="/css/screen.css" type="text/css" media="screen"/>
<script type="text/javascript" src="javascript/canvasjs/canvasjs.min.js"></script>
<!-- Bootstrap -->
<link rel='stylesheet' href="javascript/bootstrap-4.0.0/css/bootstrap.min.css">
<link rel="icon" href="/media/icon.png" type="image/x-icon" />
<link rel="shortcut icon" href="/media/icon.png" type="image/x-icon" />
</head>
<body>
	<style>
	/* Header */
	#content{width: 100%; margin-top: 130px;}

	/* Navigation */

	#navigation {overflow: hidden; background-color: #4f81bc; margin: 0; padding: 5px; margin-top: 83px;}
	#navigation a {float: left; color: white; text-align: center; padding: 8px; text-decoration: none;}
	#navigation a:hover {background-color: #87CEFA; color: black;}
	


	.header_buttons {background-color: #4f81bc; color: white; margin-top: 20px; margin-right: 20px; padding: 8px; text-decoration: none; border-radius: 5px;}
	.header_buttons:hover {background-color: #87CEFA; color: black; text-decoration: none; border-radius: 5px;} 
	#header {position: fixed; top: 0; width: 100%; z-index: 1; overflow: hidden; padding-bottom: 3px; background-color: white;}
	#logo_image {width: 80px;}
	/* #name_link {color: black;} */
	</style>
		<div id="header" class="d-flex justify-content-between align-items-center">
			<div>
				<?PHP
				$current_user = $_SESSION['userID'];
				$results = $conn->query("SELECT * FROM `personal` WHERE `userId`= '$current_user';");
				while($data = $results->fetch()){
					?>
					<div class="d-flex justify-content-center align-items-center">
						<img id="logo_image" src="/media/logo4.png" />
						<div>
							<a id="name_link" href="settings.php">Money Tracker</a><br />
							<code><?PHP echo $data['firstName'] . " " . $data['lastName']?></code>
						</div>
					</div>
					<?PHP
				}?>
			</div>
			<div>
				<a href="settings.php" class="header_buttons">Settings</a>
				<a href="index.php" name="logout" class="header_buttons">Logout</a>
			</div>
		</div>
		<nav id="navigation" class="navbar navbar-expand-lg navbar-dark fixed-top">
			<a class="navbar-toggler" style="float: right;" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</a>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav" id="na v_content">
					<li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
					<li class="nav-item"><a class="nav-link" href="ledger.php">Ledger</a></li>
					<li class="nav-item"><a class="nav-link" href="income.php">Income</a></li>
					<li class="nav-item"><a class="nav-link" href="payments.php">Payments</a></li>
					<li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
				</ul>
			</div>
		</nav>


	<section id="content">

