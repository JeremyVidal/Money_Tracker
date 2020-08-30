<?PHP
include("includes/header.php");
if(isset($_POST['loginsubmit'])){
    require('includes/db_conn.php');
	$username = $_POST['username'];
	$password = $_POST['password'];
	try{
		$results = $conn->query("SELECT * FROM `personal` WHERE `userName` = '$username';");
	}
	catch(Exception $e) {
		echo 'Message: ' . $e->getMessage();
	}
	$data = $results->fetch();
	if (password_verify($password, $data['userPassword'])){
		$_SESSION['userID'] = $data['userID'];
		?><script type="text/javascript">location.href='dashboard.php';</script><?
	}
	else{
		echo "Username or password is incorrect!";
	}
}
else if (isset($_GET['logout'])){
	session_destroy();
	display_form();
}
else{
	display_form();

}
function display_form(){
?>
	<!doctype html>
	<html lang="en">
	<head>
	<title>Sign In</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width" />
	<meta name="keywords" content="Keywords..." />
	<meta name="description" content="Description..." /> 
	<link rel="stylesheet" href="/css/screen.css" type="text/css" media="screen"/>
	<link rel="icon" href="/media/icon.png" type="image/x-icon" />
	<link rel="shortcut icon" href="/media/icon.png" type="image/x-icon" />
	</head>
	<style>
		/* Index */
		body {background-color: #4f81bc;}
		#header{display: none;}
		#login_display {width: 400px; margin: 150px auto; padding: 25px; background-color: white;}
		#login_form{width: 90%; margin: 0 auto; text-align: center;}
		#login_form input[type=text], input[type=password]{padding: 10px; margin: 10px; width: 90%; font-size: 1em;}
		#login_form input[type=submit] {font-size: 1em;}
		#logo_table td{padding: 0; text-align: left;}
		#signin {color: black;}
	</style>
	<body>
		<section id="content">
			<section id="login_display">
				<table id="logo_table"> 
					<tr><td rowspan="2"><img id="logo" src="/media/logo4.png" style="width: 150px;"></td>
					<td><h1>Money Tracker</h1></td></tr>
					<tr><td><h4>Powered by: ArcaneSight</h4></td></tr>
				</table>
				<form id="login_form" name="login_form" action="#" method="POST">
					<input type="text" name="username" required placeholder="User Name"><br>
					<input type="password" name="password" required placeholder="Password"><br>
					<input type="submit" name="loginsubmit" value="Sign In">
				</form>
				<a href="signup.php" id="signin">Sign Up</a>
			</section>
		</section>
		<?PHP
};
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>