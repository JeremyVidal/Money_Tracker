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
	#signup_display {width: 400px; margin: 150px auto; padding: 25px; background-color: white;}
	#signup_form{width: 90%; margin: 0 auto; text-align: center;}
	#signup_form input[type=text], input[type=email], input[type=date], input[type=password]{padding: 10px; margin: 10px; width: 90%; font-size: 1em;}
	#signup_form input[type=submit] {font-size: 1em;}
	#logo_table td{padding: 0; text-align: left;}
	#cancel {color: black;}
</style>
<body>
    <section id="content">
        <section id="signup_display">
            <table id="logo_table"> 
                <tr><td rowspan="2"><img id="logo" src="/media/logo4.png" style="width: 150px;"></td>
                <td><h1>Money Tracker</h1></td></tr>
                <tr><td><h4>Sign Up Form</h4></td></tr>
            </table>
            <form id="signup_form" name="signup_form" action="index.php" method="POST">
                <input type="text" name="firstname" placeholder="First Name"><br>
                <input type="text" name="lastname" placeholder="Last Name"><br>
                <input type="date" name="birthdate" placeholder="Birthday"><br>
                <input type="email" name="email" placeholder="Email"><br>
                <input type="text" name="username" placeholder="User Name"><br>
                <input type="password" name="password" placeholder="Password"><br>
                <input type="submit" value="Register">
            </form>
            <a href="index.php" id="cancel">Cancel</a>
        </section>
    </section>