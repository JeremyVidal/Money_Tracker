<?PHP
include("includes/header.php");
?>
<!doctype html>
<html lang="en">
<head>
<title>Sign Up</title>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width" />
<meta name="keywords" content="Keywords..." />
<meta name="description" content="Description..." /> 
<link rel="stylesheet" href="/css/screen.css" type="text/css" media="screen"/>
<link rel="icon" href="/media/icon.png" type="image/x-icon" />
<link rel="shortcut icon" href="/media/icon.png" type="image/x-icon" />
</head>
<style>
	/* Sign Up */
	body {background-color: #4f81bc;}
	#header{display: none;}
	#signup_display {width: 400px; margin: 150px auto; padding: 25px; background-color: white;}
	#signup_form{width: 90%; margin: 0 auto; text-align: center;}
	#signup_form input[type=text], input[type=email], input[type=date], input[type=password]{padding: 10px; margin: 10px; width: 90%; font-size: 1em;}
	#signup_form input[type=submit] {font-size: 1em;}
	#logo_table td{padding: 0; text-align: left;}
	#cancel {color: black;}
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
    <section id="content">
        <section id="signup_display">
            <table id="logo_table"> 
                <tr><td rowspan="2"><img id="logo" src="/media/logo4.png" style="width: 150px;"></td>
                <td><h1>Money Tracker</h1></td></tr>
                <tr><td><h4>Sign Up Form</h4></td></tr>
            </table>
            <form id="signup_form" name="signup_form" action="#" method="POST">
                <input type="text" name="firstname" placeholder="First Name"><br>
                <input type="text" name="lastname" placeholder="Last Name"><br>
                <input type="date" name="birthdate" placeholder="Birthday"><br>
                <input type="email" name="email" placeholder="Email"><br>
                <input type="text" name="username" placeholder="User Name"><br>
                <input type="password" name="password" placeholder="Password"><br>
                <input type="submit" name="signupsubmit" value="Register">
            </form>
            <a href="index.php" id="cancel">Cancel</a>
        </section>
    </section>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>

</body>
</html>
