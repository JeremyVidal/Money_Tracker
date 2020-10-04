<?PHP
session_start();
require('includes/db_conn.php');

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
		$_SESSION['loggedIN'] = true;
		?><script type="text/javascript">location.href='dashboard.php';</script><?
	}
	else{
		echo "No user with those credentials!";
		display_form();
	}
}
else if (isset($_GET['logout'])){
	session_destroy();
	$_SESSION = [];
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
	<!-- Bootstrap -->
	<link rel='stylesheet' href="javascript/bootstrap-4.0.0/css/bootstrap.min.css">
	<link rel="icon" href="/media/icon.png" type="image/x-icon" />
	<link rel="shortcut icon" href="/media/icon.png" type="image/x-icon" />
	</head>
	<style>
		/* Index */
		body {background-color: #4f81bc;}
		#header {display: none;}
		#navigation {display: none;}
	</style>
	<body>
	<section class="container" style="margin-top: 100px">
		<section class="row justify-content-center">
			<div class="card" style="width: 25rem;">
				<div class="d-fex justify-content-between">
					<div class="row align-items-center">
						<div class="col-auto">
							<img id="logo" src="/media/logo4.png" style="width: 120px;">
						</div>
						<div class="col-auto ">
							<div>
								<h3>Money Tracker</h3>
								<h5>Login</h5>

							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form class="form" name="login_form" action="#" method="POST">
						<div class="form-group">
							<label for="username">Username</label>
							<!-- <input type="text" name="username" required placeholder="User Name"><br> -->
							<input type="text" id="username" class="form-control" name="username" required placeholder="User Name">
						</div>
						<div class="form-group">
							<label for="password">Password</label>
							<!-- <input type="password" name="password" required placeholder="Password"><br> -->
							<input type="password" id="password" class="form-control" name="password" required placeholder="Password">
						</div>
						<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
						<div class="row justify-content-around">
							<form class="form" name="login_form" action="#" method="POST">
								<input type="submit" name="loginsubmit" value="Sign In">
							</form>
							<a href="signup.php">Sign Up</a>
						</div>
					</form>
				</div>
			</div>

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