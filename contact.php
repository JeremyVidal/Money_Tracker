<?php
include("includes/header.php");
$current_user =  $_SESSION['userID'];
// this creates a future contact
if (isset($_POST['futuresubmit'])){
    $futurecategory = $_POST['futurecategory'];
    $futurename = $_POST['futureaccountname'];
    $futureaccounttype = $_POST['futureaccounttype'];
    $futuredate = $_POST['futuredate'];
    $futuretime = $_POST['futuretime'];
    $futureresult = $_POST['futureresult'];
    $futurenotes = $_POST['futurenotes'];
    $futuretype = $_POST['futuretype'];
    $addContact = "INSERT INTO `contact` (`contactID`, `contactCategory`, `contactName`, `contactAccountType`, `contactType`, `contactDate`, `contactTime`, `contactResults`, `contactNotes`, `userID`)
    VALUES (NULL, '$futurecategory', '$futurename', '$futureaccounttype', '$futuretype', '$futuredate', '$futuretime', 'Future', '$futurenotes', '$current_user')";
    $conn->query($addContact);
    ?><script type="text/javascript">location.href='contact.php';</script><?PHP
}
// this records a contact for an account
else if (isset($_POST['contactsubmit'])){
    $accountcategory = $_POST['accountcategory'];
    $accountname = $_POST['accountname'];
    $contacttype = $_POST['contacttype'];
    $contactdate = $_POST['contactdate'];
    $contacttime = $_POST['contacttime'];
    $contactresult = $_POST['contactresult'];
    $contactnotes = $_POST['contactnotes'];
    $addContact = "INSERT INTO `contact` (`contactID`, `contactCategory`, `contactName`, `contactAccountType`, `contactType`, `contactDate`, `contactTime`, `contactResults`, `contactNotes`, `userID`)
    VALUES (NULL, '$accountcategory', '$accountname', NULL, '$contacttype', '$contactdate', '$contacttime', '$contactresult', '$contactnotes', '$current_user')";
    $conn->query($addContact);
    ?><script type="text/javascript">location.href='contact.php';</script><?PHP
}
else if(isset($_POST['contactdeleteID'])){
    $_SESSION['contactdeleteID'] = $_POST['contactdeleteID'];
    ?><script type="text/javascript">location.href='deletecontactconfirm.php';</script><?PHP
}
else if(isset($_POST['contacteditID'])){
    $_SESSION['contacteditID'] = $_POST['contacteditID'];
    ?><script type="text/javascript">location.href='editcontact.php';</script><?PHP
}
else if (isset($_POST['sidecontactsubmit'])){
    $_SESSION['current_contact_id'] = $_POST['sidecontactID'];
    // echo $_GET['acctID'];
    display_form();
}
else{
    display_form();
};

function display_form(){
    require('includes/db_conn.php');
    $current_user =  $_SESSION['userID'];

    if (isset($_SESSION['current_contact_id'])){
        $current_side_id = $_SESSION['current_contact_id'];
    }
    else{
        $current_side_id = 1;
    }

    global $CURRENT_DATE;
    ?>  
    <section id="contact_sidenav">
        <h2>Account Contact</h2>
        <?PHP 
            $result = $conn->query("SELECT DISTINCT `accountCategory` FROM `account`;");
            while($record = $result->fetch()){
                $accountCategory = $record['accountCategory'];
                echo "<h3>$accountCategory</h3>";
                echo "<ul>";
                $results = $conn->query("SELECT `accountName`, `accountID` FROM `account` WHERE `accountCategory` = '$accountCategory';");
                while($data = $results->fetch()){
                    $accountName = $data['accountName'];
                    $accountID = $data['accountID'];
                    echo "<li>
                    <form name=\"acct\" id=\"contact_side_links\" action=\"contact.php\" method=\"POST\">
                        <input type=\"hidden\" name=\"sidecontactID\" value=\"$accountID\">
                        <input type=\"submit\" name = \"sidecontactsubmit\" value=\"$accountName\" style=\"text-align: left;\">
                    </form>
                    </li>";
                };
                echo "</ul>";
            };
        ?>
    </section>
    <section id="contact_main">
    <?PHP
    $results = $conn->query("SELECT * FROM `account` WHERE `accountID` = '$current_side_id' AND `userID` = '$current_user';");
    while($data = $results->fetch()){
    ?>
        <section id="contact_account"> 
            <div id="contact_account_image"><img src="media/companies/<? echo $data['accountName']?>.png"></div>
            <div id="contact_account_type"><? echo $data['accountName']?></div><br>
            <table id="contact_account_table">
                <h3>Add Contact (<span style="color: red; font-size: 12px;">*</span> <span style="font-size: 12px;">required</span>)</h3>
                <tr><th>Name</th><th>Phone</th></tr>
                <tr><td style="width: 100px; max-width: 100px; "><? echo $data['accountName']?></td><td style="width: 50px; max-width: 50px; "><? echo $data['accountPhone']?></td></tr>
                <tr><th>Payment</th><th>Due Date</th></tr>
                <tr><td>$<? echo $data['accountPayment']?></td><td><? echo $data['accountDueDate']?></td></tr>
            </table> 
        </section>    
        <section id="contact_add">  
            <form id="contact_add_form" name="contact_add_form" action="" method="POST">
                <input type="hidden" name="accountcategory" value="<? echo $data['accountCategory']?>">
                <input type="hidden" name="accountname" value="<? echo $data['accountName']?>">
                <table>
                    <tr>
                    <td>Type <span style="color: red;">*</span></td>
                    <td><select id="contact_type" name="contacttype" required>
                            <option value=""></option>
                            <option value="Phone">Phone</option>
                            <option value="Text">Text</option>
                            <option value="Email">Email</option>
                            <option value="In Person">In Person</option>
                        </select></td>
                    <td>Result <span style="color: red;">*</span></td>
                    <td><select id="contact_result" name="contactresult" required>
                            <option value=""></option>
                            <option value="Contacted" >Contacted</option>
                            <option value="Voicemail">Voicemail</option>
                            <option value="Incoming">Incoming</option>
                        </select></td>
                    </tr>
                    <tr>
                        <td>Date <span style="color: red;">*</span></td><td><input type="date" name="contactdate" value="<?php echo $CURRENT_DATE;?>" required></td>
                        <td>Time <span style="color: red;">*</span></td><td><input type="time" name="contacttime" required></td>
                    </tr>
                    <tr>
                    <td>Notes</td>
                    <td colspan="3"><textarea id="contactnotes" name="contactnotes" rows="2" cols="50" max-length="200" value=""></textarea></td>
                    </tr>
                    <tr><td colspan="4"><input type="submit" name="contactsubmit" value="Add Contact"></td></tr>
                </table>
            </form>
        </section>
        <section id="future_contact">
            <h3>Future Contact (<span style="color: red; font-size: 12px;">*</span> <span style="font-size: 12px;">required</span>)</h3>
            <form id="future_contact_form" name="future_contact__form" action="" method="POST">
                <input type="hidden" name="futurecategory" value="<? echo $data['accountCategory']?>">
                <input type="hidden" name="futureaccounttype" value="<? echo $data['accountType']?>">
                <input type="hidden" name="futureaccountname" value="<? echo $data['accountName']?>"><br>
                <table>
                    <tr>
                        <td>Contact Type <span style="color: red;">*</span></td>
                        <td colspan="3"><select id="futuretype" name="futuretype" required>
                            <option value=""></option>
                            <option value="Phone">Phone</option>
                            <option value="Text">Text</option>
                            <option value="Email">Email</option>
                            <option value="In Person">In Person</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Date <span style="color: red;">*</span></td><td><input type="date" name="futuredate" value="<?php echo $CURRENT_DATE;?>" required></td>
                        <td>Time <span style="color: red;">*</span></td><td><input type="time" name="futuretime" required></td>
                    </tr>
                    <tr>
                        <td>Notes</td>
                        <td colspan="3"><textarea id="futurenotes" name="futurenotes" rows="2" cols="50" max-length="200" value="" required></textarea></td>
                    </tr>
                        <tr><td colspan="4"><input type="submit" name="futuresubmit" value="Add Future Contact"></td></tr>
                </table>
            </form>
        </section>
    <?PHP
    };
?>
    <section id="contact_activities">
        <h3>Contact Activities</h3>
        <table id="contact_table">
            <tr><th></th><th>Date</th><th>Time</th><th>Type</th><th>Results</th><th></th><th>Name</th><th>Notes</th><th></th><th></th></tr>
            <?PHP
                $results = $conn->query("SELECT * FROM `contact` WHERE MONTH(contactDate) = MONTH(CURRENT_DATE()) AND `userID` = '$current_user' ORDER BY contactDate DESC, contactTime DESC;");
                while($data = $results->fetch()){
                    $contactID = $data['contactID'];
                    $contactDate = $data['contactDate'];
                    $contactTime = date("h:i A", strtotime($data['contactTime']));
                    $contactType = $data['contactType'];
					$contactResults = $data['contactResults'];
					// this section changes the result for the contact image
                    if($contactResults == 'Incoming'){
                        $phone_results = 'Incoming';
                    }
                    else if($contactResults == 'Contacted'){
                        $phone_results = 'Outgoing';
                    }
                    else if($contactResults == 'Voicemail'){
                        $phone_results = 'NoContact';
                    }
                    else if($contactResults == 'Future'){
                        $phone_results = 'Future';
                    }
                    $contactName = $data['contactName'];
                    $contactNotes = $data['contactNotes'];
                    echo "<tr><td><img src=\"media/$phone_results.png\"></td><td>$contactDate</td><td>$contactTime</td><td><img src=\"media/$contactType.png\"></td><td>$contactResults</td><td><img src=\"media/companies/$contactName.png\"></td><td>$contactName</td><td>$contactNotes</td>
                    <td>
                        <form id=\"contact_edit\" name=\"contact_edit\" method=\"POST\">
                            <input type=\"hidden\" name=\"contacteditID\" value=\"$contactID\">
                            <button><img src=\"media/edit.ico\"></button>
                        </form>
                    </td>
                    <td>
                        <form id=\"contact_delete\" name=\"contact_delete\" method=\"POST\">
                            <input type=\"hidden\" name=\"contactdeleteID\" value=\"$contactID\">
                            <button><img src=\"media/delete.ico\"></button>
                        </form>
                    </td>
                    </tr>";
                };?>
        </table>
    </section>
</section>
<?PHP
}
?>