<?PHP 
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
    ?><script type="text/javascript">location.href='contact.php';</script><?PHP
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
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
			<h4>Select Account</h4>
				<hr />
				<?PHP 
					$result = $conn->query("SELECT DISTINCT `accountCategory` FROM `account` WHERE `userID` = '$current_user';");
					while($record = $result->fetch()){
						$accountCategory = $record['accountCategory'];
						echo "<h5>$accountCategory</h5>";
						echo "<ul class=\"nav flex-column\">";
						$results = $conn->query("SELECT `accountName`, `accountID` FROM `account` WHERE `accountCategory` = '$accountCategory' AND `userID` = '$current_user';");
						while($data = $results->fetch()){
							$accountName = $data['accountName'];
							$accountID = $data['accountID'];
							echo "<li class=\"nav-item\">
							<form name=\"acct\" class=\"nav-link active\" action=\"contact.php\" method=\"POST\">
								<input type=\"hidden\" name=\"sidecontactID\" value=\"$accountID\">
								<input type=\"submit\" name = \"sidecontactsubmit\" class=\"contact_side_links\" value=\"$accountName\" style=\"text-align: left;\">
							</form>
							</li>";
						};
						echo "</ul>";
					};
				?>
			</div>
		</div>
	</div>
	<style>
		/* Contact */
		#contact_add_button {background-color: #4f81bc; color: white; margin-left: 15px; margin-top: 15px;}
		.contact_main {position: absolute; width: 87%; margin-left: 16%; padding: 25px; display: inline-block;}
		.account_image {width: 20px;}
		.account_button {border: none; background-color: white;}
		.contact_account_image {width: 60px;}
		.contact_account_img{width: 30px;}
		.contact_img{width: 20px;}
		.contact_side_links{padding: 7px; min-width: 175px; border: none; text-decoration: none; color: black; display: block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
		.contact_side_links:hover {color: black; background-color: #F0F0F0;}
		.sidebar {position: fixed; top: 132px; bottom: 0; left: 0; z-index: 1000; display: block; padding: 20px; overflow-x: hidden; overflow-y: auto; border-right: 1px solid #eee;}
</style>
<section class="contact_main">
    <?PHP
    $results = $conn->query("SELECT * FROM `account` WHERE `accountID` = '$current_side_id' AND `userID` = '$current_user';");
    while($data = $results->fetch()){
    ?>
        <section class="container"> 
            <div class="row">
				<div class="col-lg-5">
					<div class="d-flex justify-content-between">
						<div>
							<h4>Add Contact</h4>
						</div>
						<div class="d-flex">
							<h6><?PHP echo $data['accountName']; ?></h6>
							<img class="contact_account_image" src="media/companies/<?PHP echo $data['accountName']; ?>.png">
						</div>
					</div>
					<form class="form" name="contact_add_form" action="" method="POST">
						<input type="hidden" name="accountcategory" value="<?PHP echo $data['accountCategory']; ?>">
						<input type="hidden" name="accountname" value="<?PHP echo $data['accountName']; ?>">
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="accountName">Account</label>
									<input type="text" class="form-control" id="accountName" value="<?PHP echo $data['accountName'];?>" aria-describedby="accountHelp" disabled>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="accountPhone">Phone</label>
									<input type="text" class="form-control" id="accountPhone" value="<?PHP echo $data['accountPhone'];?>" aria-describedby="phoneHelp" disabled>
								</div>		
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="accountPayment">Payment</label>
									<input type="text" class="form-control" id="accountPayment" value="<?PHP echo $data['accountPayment'];?>" aria-describedby="paymentHelp" disabled>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="accountDueDate">Due Date</label>
									<input type="text" class="form-control" id="accountDueDate" value="<?PHP echo $data['accountDueDate'];?>" aria-describedby="dueDateHelp" disabled>
								</div>							
							</div>
						</div>
						<hr />
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
								<label for="contact_type">Type <span style="color: red;">*</span></label>
									<select id="contact_type" class="form-control" name="contacttype" required>
										<option value=""></option>
										<option value="Phone">Phone</option>
										<option value="Text">Text</option>
										<option value="Email">Email</option>
										<option value="In Person">In Person</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="contact_result">Result <span style="color: red;">*</span></label>
									<select id="contact_result" class="form-control" name="contactresult" required>
										<option value=""></option>
										<option value="Contacted" >Contacted</option>
										<option value="Voicemail">Voicemail</option>
										<option value="Incoming">Incoming</option>
									</select>	
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
									<label for="contactdate">Date <span style="color: red;">*</span></label>
									<input type="date" id="contactdate" class="form-control" name="contactdate" value="<?PHP echo $CURRENT_DATE; ?>" required>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label for="contacttime">Time <span style="color: red;">*</span></label>
									<input type="time" id="contacttime" class="form-control" name="contacttime" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<label for="contacttime">Notes </label>
								<textarea id="contactnotes" class="form-control" name="contactnotes" rows="2" cols="50" value=""></textarea>
							</div>
						</div>
						<div class="row">
							<button class="btn" id="contact_add_button" type="submit" name="contactsubmit" >Add Contact</button>
						</div>
					</form>
				</div>
				<div class="col-lg-7">
					<div class="container">
						<table class="table table-striped table-sm">
							<h4>Contact Activities</h4>
							<tr><th></th><th>Date</th><th>Time</th><th>Type</th><th>Results</th><th></th><th>Name</th><th></th><th></th></tr>
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
									echo "<tr>
									<td><img class=\"contact_img\" src=\"media/$phone_results.png\"></td><td>$contactDate</td><td>$contactTime</td><td><img class=\"contact_img\" src=\"media/$contactType.png\"></td><td>$contactResults</td><td><img class=\"contact_img\" src=\"media/companies/$contactName.png\"></td><td>$contactName</td>
									<td>
										<form name=\"contact_edit\" method=\"POST\">
											<input type=\"hidden\" name=\"contacteditID\" value=\"$contactID\">
											<button class=\"account_button\"><img class=\"contact_img\" src=\"media/edit.ico\"></button>
										</form>
									</td>
									<td>
										<form name=\"contact_delete\" method=\"POST\">
											<input type=\"hidden\" name=\"contactdeleteID\" value=\"$contactID\">
											<button class=\"account_button\"><img class=\"contact_img\" src=\"media/delete.ico\"></button>
										</form>
									</td>
									</tr>";
								};?>
						</table>
					</div>
				</div>
		</section>
		<hr />
		<section class="conatiner">
			<div class="row">
				<div class="col-lg-6">
					<h3>Future Contact (<span style="color: red; font-size: 12px;">*</span> <span style="font-size: 12px;">required</span>)</h3>
					<form class="form" name="future_contact_form" action="contact.php" method="POST">
						<input type="hidden" name="futurecategory" value="<?PHP echo $data['accountCategory']; ?>">
						<input type="hidden" name="futureaccounttype" value="<?PHP echo $data['accountType']; ?>">
						<input type="hidden" name="futureaccountname" value="<?PHP echo $data['accountName']; ?>"><br>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">
								<label for="futuretype">Contact Type <span style="color: red;">*</span></label>
									<select id="futuretype" class="form-control" name="futuretype" aria-describedby="futureTypetHelp" required>
										<option value=""></option>
										<option value="Phone">Phone</option>
										<option value="Text">Text</option>
										<option value="Email">Email</option>
										<option value="In Person">In Person</option>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="form-group">								
									<label for="futuredate">Date <span style="color: red;">*</span></label>
									<input type="date" class="form-control"  id="futuredate" name="futuredate" value="<?PHP echo $CURRENT_DATE; ?>" aria-describedby="futureDateHelp" required></td>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">								
									<label for="futuretime">Time <span style="color: red;">*</span> </label>
									<input type="time" class="form-control" id="futuretime" name="futuretime" required>
								</div>
							</div>

						</div>
						<div class="row">
							<div class="col-lg-12">
								<label for="futurenotes">Notes <span style="color: red;">*</span></label>
								<textarea id="futurenotes" class="form-control" name="futurenotes" rows="2" cols="50" value="" required></textarea>
							</div>
						</div>
						<div class="row">
							<button type="submit" class="btn" id="contact_add_button" name="futuresubmit">Add Future Contact</button>
						</div>
					</form>
				</div>
			</div>
		</section>
		<hr />
    <?PHP
    };
?>
    <section class="row" style="margin-top: 25px;">

    </section>
</section>
<?PHP
}
include("includes/footer.php");
?>