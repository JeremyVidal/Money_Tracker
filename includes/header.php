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
<meta name="viewport" content="width=device-width" />
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
	#header {display: flex; position: fixed; top: 0; width: 100%; z-index: 1; overflow: hidden; padding-bottom: 3px; background-color: white;}
	/* #header a.logout {float: right; color: black; text-align: center; margin-top: 20px; padding: 0 10px 0 10px; text-decoration: none;} */
	/* #header a:hover {background-color: #87CEFA; color: black;} */
	#logo_image {width: 80px;}

	#name_link {color: black;}
	#content{width: 100%; min-height: 700px; margin-top: 116px; padding: 25px;}
	/* Navigation */
	#navigation {overflow: hidden; background-color: #4f81bc; margin: 0; padding: 5px; margin-top: 83px;}
	#navigation a {float: left; color: white; text-align: center; padding: 0 10px 0 10px; text-decoration: none;}
	#navigation a:hover {background-color: #87CEFA; color: black;}
	</style>
    <section id="header" class="justify-content-between">
		<section>
            <table>
                <?PHP
                $current_user = $_SESSION['userID'];
                $results = $conn->query("SELECT * FROM `personal` WHERE `userId`= '$current_user';");
                while($data = $results->fetch()){
                    ?>
                    <tr><td><img id="logo_image" src="/media/logo4.png"></td><td><a id="name_link" href="settings.php">Money Tracker</a></td></tr>
                <?PHP
                }?>
            </table>
		</section>
        <section >
            <a href="index.php" name="logout" class="logout">Logout</a>
            <a href="settings.php" class="logout">Settings</a>
        </section>
	</section>
	<nav id="navigation" class="navbar navbar-expand-lg navbar-dark fixed-top">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav" id="na v_content">
				<li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
				<li class="nav-item"><a class="nav-link" href="#ledger.php">Ledger</a></li>
				<li class="nav-item"><a class="nav-link" href="income.php">Income</a></li>
				<li class="nav-item"><a class="nav-link" href="payments.php">Payments</a></li>
				<li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
			</ul>
		</div>
	</nav>
    <section id="content">

    <script>
		var span = document.getElementById('timeclock');
		function time() {
		var d = new Date();
		var s = d.getSeconds();
		var m = d.getMinutes();
		var h = d.getHours();
		span.textContent = tConvert(h + ":" + m);  // uses the function "tConvert" below to convert the 24 hour time to 12 hour time
		};
		setInterval(time, 1000);
		function tConvert (time) {
			// Check correct time format and split into components
			time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
			if (time.length > 1) { // If time format correct
				time = time.slice (1);  // Remove full string match value
				time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
				time[0] = +time[0] % 12 || 12; // Adjust hours
			}
			return time.join (''); // return adjusted time or original string
		};
	</script>	