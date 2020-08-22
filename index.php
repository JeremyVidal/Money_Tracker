<!-- Created by: Jeremy Vidal -->
<!-- Started: 04-22-2020 -->
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
            <form id="login_form" name="login_form" action="dashboard.php" method="POST">

                
                <input type="text" name="username" placeholder="User Name"><br>
                <input type="password" name="password" placeholder="Password"><br>
                <input type="submit" value="Sign In">
            </form>
            <a href="signup.php" id="signin">Sign Up</a>
        </section>
    </section>