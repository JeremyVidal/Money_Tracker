<?PHP
session_start();
require('includes/db_conn.php');

?>
<!doctype html>
<html lang="en">
<head>
<title>Sign Up</title>
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
	/* Sign Up */
	body {background-color: #4f81bc;}
	#navigation {display: none;}
	#header {display: none;}
</style>
<?PHP
if (isset($_POST['signupsubmit'])){
    require('includes/db_conn.php');
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$birthdate = $_POST['birthdate'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	try{
		$results = $conn->query("SELECT * FROM `personal` WHERE `userName` = '$username';");
	}
	catch(Exception $e) {
		echo 'Message: ' . $e->getMessage();
	}
	$data = $results->fetch();
    if ($data['userName'] === $username){
		echo"Username or Email has already been taken!";
	}
	else{
		$addUser = "INSERT INTO `personal` (`firstName`, `lastName` , `birthDate` , `userEmail`, `userName`, `userPassword`)
    	VALUES ('$firstname', '$lastname', '$birthdate', '$email', '$username', '$password')"; 
		if($conn->query($addUser)){
			?><script type="text/javascript">location.href='index.php';</script><?
		}
		else{
			echo"Something went wrong saving the record!";
		}
	}
}
?>
<body>
	<section class="container" style="margin-top: 100px">
		<section class="row justify-content-center">
			<div class="card" style="width: 35rem;">
				<div class="d-fex justify-content-around">
					<div class="row align-items-center">
						<div class="col-lg-4">
							<img id="logo" src="/media/logo4.png" style="width: 120px;">
						</div>
						<div class="col-lg-8 ">
							<div>
								<h3>Money Tracker</h3>
								<h5>Sign Up</h5>
							</div>
						</div>
					</div>
				</div>
				<div class="card-body">
				<form class="form" name="signup_form" action="#" method="POST">
					<div class="row justify-content-between">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="first_name">First Name</label>
								<input type="text" id="first_name" class="form-control input-sm" name="firstname" required placeholder="First Name">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="last_name">Last Name</label>
								<input type="text" id="last_name" class="form-control input-sm" name="lastname" required placeholder="Last Name">
							</div>	
						</div>
					</div>

					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="form-group">
								<label for="birthday">Birthday</label>
								<input type="date" id="birthday" class="form-control input-sm" name="birthdate" required placeholder="Birthday">
							</div>
						</div>
						<div class="col-lg-7">
							<div class="form-group">
								<label for="user_name">User Name</label>
								<input type="text" id="user_name" class="form-control input-sm" name="username" required placeholder="User Name">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" id="email" class="form-control input-sm" name="email" required placeholder="Email">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" id="password" class="form-control input-sm" name="password" required placeholder="Password">
					</div>
					<div class="row justify-content-around">
						<input type="submit" name="signupsubmit" value="Sign Up">
						<a href="index.php" id="cancel">Cancel</a>
					</div>
            	</form>
				</div>
			</div>

		</section>
	</section>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>
</html>
