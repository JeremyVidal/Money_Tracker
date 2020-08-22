<?PHP
session_start();
require('includes/db_conn.php');
$script = $_SERVER['PHP_SELF'];
$script = str_replace("/", "", "$script"); $script = str_replace(".php", "", "$script");
$CURRENT_DATE = date("Y-m-d");
$CURRENT_MONTH = date("n");
$CURRENT_YEAR = date("Y");
$_SESSION['userID'] = 1;

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
<link rel="icon" href="/media/icon.png" type="image/x-icon" />
<link rel="shortcut icon" href="/media/icon.png" type="image/x-icon" />
<script type="text/javascript" src="javascript/canvasjs/canvasjs.min.js"></script>

</head>
<body>
    <section id="header">
        <section id="header_left">
            <img id="logo_image" src="/media/logo4.png">
        </section>
        <section id="header_middle">
            <table>
                <tr><td>Money Tracker</td></tr>
                <?PHP
                $current_user = $_SESSION['userID'];
                $results = $conn->query("SELECT * FROM `personal` WHERE `userId`= '$current_user';");
                while($data = $results->fetch()){
                    ?>
                    <tr><td><a id="name_link" href="settings.php"><?PHP echo $data['firstName'] . " " . $data['lastName']?></a> </td></tr>
                <?PHP
                }?>
                <!-- <tr><td><span id="timeclock"></span></td></tr> -->
            </table>
        </section>
        <section id="header_right">
            <a href="index.php" class="logout">Logout</a>
            <a href="settings.php" class="logout">Settings</a>
            <br>
            <br>
            <hr>
            <section id="month_select">
                <label for="month">Month</label>
                <select id="month">
                    <option value="1" <?PHP if ($CURRENT_MONTH == "1") echo 'selected = "selected"';?>>January</option>
                    <option value="2" <?PHP if ($CURRENT_MONTH == "2") echo 'selected = "selected"';?>>February</option>
                    <option value="3" <?PHP if ($CURRENT_MONTH == "3") echo 'selected = "selected"';?>>March</option>
                    <option value="4" <?PHP if ($CURRENT_MONTH == "4") echo 'selected = "selected"';?>>April</option>
                    <option value="5" <?PHP if ($CURRENT_MONTH == "5") echo 'selected = "selected"';?>>May</option>
                    <option value="6" <?PHP if ($CURRENT_MONTH == "6") echo 'selected = "selected"';?>>June</option>
                    <option value="7" <?PHP if ($CURRENT_MONTH == "7") echo 'selected = "selected"';?>>July</option>
                    <option value="8" <?PHP if ($CURRENT_MONTH == "8") echo 'selected = "selected"';?>>August</option>
                    <option value="9" <?PHP if ($CURRENT_MONTH == "9") echo 'selected = "selected"';?>>September</option>
                    <option value="10" <?PHP if ($CURRENT_MONTH == "10") echo 'selected = "selected"';?>>October</option>
                    <option value="11" <?PHP if ($CURRENT_MONTH == "11") echo 'selected = "selected"';?>>November</option>
                    <option value="12" <?PHP if ($CURRENT_MONTH == "12") echo 'selected = "selected"';?>>December</option>
                </select>
            <!-- </section>       
            <section id="year_select"> -->
                <label for="year">Year</label>
                <select id="year">
                    <option value="2020" <?PHP if ($CURRENT_YEAR == "2020") echo 'selected = "selected"';?>>2020</option>
                    <option value="2019" <?PHP if ($CURRENT_YEAR == "2019") echo 'selected = "selected"';?>>2019</option>
                </select>
            </section>       
        </section>
        <section class="navigation">
            <a href="dashboard.php">Dashboard</a>
            <a href="ledger.php">Ledger</a>
            <a href="income.php">Income</a>
            <a href="payments.php">Payments</a>
            <a href="contact.php">Contact</a>  
        </section>
    </section>
        <section id="content">

    <script>
    var span = document.getElementById('timeclock');

    function time() {
    var d = new Date();
    var s = d.getSeconds();
    var m = d.getMinutes();
    var h = d.getHours();
    span.textContent = tConvert(h + ":" + m);  // uses the function "tConvert" below to convert the 24 hour time to 12 hour time
    }
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
    }

</script>