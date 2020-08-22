<?
include("includes/header.php");
$current_user =  $_SESSION['userID'];
?>
<section id="settings_side_nav">
<h2>Account Settings</h2>
<ul id="settingsID" name="settingsID">
    <li>
    <form name="acct" id="settings_side_links" action="settings.php" method="POST">
        <input type="submit" name = "personalsidesubmit" value="Personal Info">
    </form>
    </li>
    <li>
    <form name="acct" id="settings_side_links" action="settings.php" method="POST">
        <input type="submit" name = "jobsidesubmit" value="Job Info">
    </form>
    </li>
    <li>
    <form name="acct" id="settings_side_links" action="settings.php" method="POST">
        <input type="submit" name = "accountsidesubmit" value="Accounts">
    </form>
    </li>
</ul>
</section>
<?
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
// this display a different form based on what side nav option was chosen
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
<?
function personal_display(){
    require('includes/db_conn.php');
    $current_user =  $_SESSION['userID'];
    ?>
    <section id="settings_main">
        <table id="personal_info_table">
        <tr><th>First Name</th><th>Last Name</th><th>Birth Date</th><th>Email</th><th>Password</th></tr>
        <?
        $results = $conn->query("SELECT * FROM `personal` WHERE `userID` = '$current_user';");
        while($data = $results->fetch()){
            $firstName = $data['firstName'];
            $lastName = $data['lastName'];
            $birthDate = $data['birthDate'];
            $userEmail = $data['userEmail'];
            $userPassword = $data['userPassword'];
            echo "<tr><td>$firstName</td><td>$lastName</td><td>$birthDate</td><td>$userEmail</td><td>$userPassword</td></tr>";
        };?>
        </table>
    </section>
<?
}
function job_display(){
    require('includes/db_conn.php');
    $current_user =  $_SESSION['userID'];
    ?>
    <section id="settings_main">
        <table id="job_info_table">
        <tr><th>Name</th><th>Street</th><th>City</th><th>State</th><th>Zip</th><th>Phone</th><th>Start Date</th></tr>
        <?
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
    </section>
<?
}
function account_add_form(){
    require('includes/db_conn.php');
    $current_user =  $_SESSION['userID'];
    ?>
    <section id="settings_main">
        <section id="account_info">
            <h3>Add Account (<span style="color: red; font-size: 12px;">*</span> <span style="font-size: 12px;">required</span>)</h3>
            <form id="account_add_form" name="account_add_form" action="settings.php" method="POST">
            <table>
                <tr><td>Category <span style="color: red;">*</span></td>
                <td><input list="account_categories" name="account_category_add" id="account_category_add" required>
                <datalist id="account_categories">
                    <option value="Bill">
                    <option value="Collection">
                </datalist></td>
                <td>Type <span style="color: red;">*</span></td>
                <td><input list="account_types" name="account_type_add" id="account_type_add" required>
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
                </datalist></td></tr>
                <tr><td>Name <span style="color: red;">*</span></td><td><input type='text' id="account_name_add" name="account_name_add" required></td>
                <td>Phone <span style="font-size: 10px;">(no characters)</span></td><td><input type='phone' id="account_phone_add" name="account_phone_add" maxlength="10"></td>
                <td>Acct #</td><td><input type='text' id="account_number_add" name="account_number_add"></td></tr>
                <tr><td>Street</td><td><input type='text' id="account_street_add" name="account_street_add"></td>
                <td>Street2</td><td><input type='text' id="account_street2_add" name="account_street2_add"></td></tr>
                <tr><td>City</td><td><input type='text' id="account_city_add" name="account_city_add"></td>
                <td>State <span style="font-size: 10px;">(abbrev)</span></td><td><input type='text' id="account_state_add" name="account_state_add" maxlength="2"></td>
                <td>Zip</td><td><input type='text' id="account_zip_add" name="account_zip_add" maxlength="5"></td></tr>
                <tr><td>Begin Amount</td><td><input type='number' id="account_beginamount_add" name="account_beginamount_add" min="0.00" step="0.01"></td>
                <td>Payment <span style="color: red;">*</span></td><td><input type='number' id="account_payment_add" name="account_payment_add" min="0.00" step="0.01" required></td></tr>
                <tr><td>Day Due <span style="color: red;">*</span></td>
                
                <td>
                <select id="account_duedate_add" name="account_duedate_add" required>
                    <option value="1">1st</option>
                    <option value="2">2nd</option>
                    <option value="3">3rd</option>
                    <option value="4">4th</option>
                    <option value="5">5th</option>
                    <option value="6">6th</option>
                    <option value="7">7th</option>
                    <option value="8">8th</option>
                    <option value="9">9th</option>
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
                </td>
                <td>Time Due <span style="color: red;">*</span></td><td><input type='time' id="account_duetime_add" name="account_duetime_add" required></td></tr>
                <tr><td><input type="submit" name="account_add_submit" value="Add Account"></td></tr>
            </table>
            </form>
        </section>
        <section id="accounts">
            <h3>Current Accounts</h3>
                <table id="accounts_table">
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
                                    <td>$accountCategory</td><td><img src=\"media/$accountType.png\"></td><td>$accountType</td><td><img src=\"media/companies/$accountName.png\"></td><td>$accountName</td><td>$accountNumber</td><td>$accountSymbol $accountPayment</td><td style=\"text-align: center;\">$accountDueDate</td>
                                    <td>
                                        <form id=\"account_delete\" name=\"account_delete\" action=\"\" method=\"POST\">
                                            <input type=\"hidden\" name=\"accountdeleteID\" value=\"$accountID\">
                                            <button><img src=\"media/delete.ico\"></button>
                                        </form>
                                    </td>
                                    <td>
                                </tr>";
                        };?>
                </table>
        </section>
    </section>
<?
}
?>