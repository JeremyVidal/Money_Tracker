<?PHP
include("includes/header.php");
// this updates a contact then redirects to contact.php
if(isset($_POST['contactupdatesubmit'])){
	require('includes/db_conn.php');
	$contactupdateID = $_POST['contactupdateID'];
	$contactupdatedate = $_POST['contactupdatedate'];
	$contactupdatetime = $_POST['contactupdatetime'];
	$contactupdatetype = $_POST['contactupdatetype'];
	$contactupdateresult = $_POST['contactupdateresult'];
	$contactupdatenote = $_POST['contactupdatenote'];
	
	$updateContact = "UPDATE `contact` 
		SET
			`contactDate` = '$contactupdatedate',
			`contactTime` = '$contactupdatetime',
			`contactType` = '$contactupdatetype',
			`contactResults` = '$contactupdateresult',
			`contactNotes` = '$contactupdatenote'
		WHERE `contactID` = '$contactupdateID';
	";
	$conn->query($updateContact);
	?><script type="text/javascript">location.href='contact.php';</script><?PHP
}
else{
	display_form();
}
function display_form(){
	require('includes/db_conn.php');
	$contacteditID = $_SESSION['contacteditID'];
	$results = $conn->query("SELECT * FROM `contact` WHERE `contactID` = '$contacteditID';");
	while($data = $results->fetch()){
		$contactType  =  $data['contactType'];
		$contactResult  =  $data['contactResults'];
	?>
	<style> 
		/* EditContact */
		#contact_edit {width: 40%; margin: 200px auto 0 auto; padding: 10px;}	
		#contact_editimg{width: 30px;}
		.contact_edit_img{width: 60px;}
	</style>
	<section id="contact_edit">
	<div class="card">
		<form class="form" name="contact_edit_form" action="editcontact.php" method="POST">
			<input type="hidden" name="contactupdateID" value="<?PHP echo $data['contactID']; ?>">
			<div class="card-header d-flex justify-content-between">
				<h5><img id="contact_editimg" src="media/update.png">&nbsp;&nbsp;Update CONTACT?</h5>
				<div class="d-flex">
					<p><?PHP echo $data['contactName']; ?></p>
					<img class="contact_edit_img" src="media/companies/<?PHP echo $data['contactName']; ?>.png">
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="contactupdatetype">Type</label>
							<select id="contactupdatetype" class="form-control" name="contactupdatetype">
								<option value="" <?PHP if ($contactType == "") {echo "selected";}; ?>></option>
								<option value="Phone" <?PHP if ($contactType == "Phone") {echo "selected";}; ?>>Phone</option>
								<option value="Text" <?PHP if ($contactType == "Text") {echo "selected";}; ?>>Text</option>
								<option value="Email" <?PHP if ($contactType == "Email") {echo "selected";}; ?>>Email</option>
								<option value="In Person" <?PHP if ($contactType == "In Person") {echo "selected";}; ?>>In Person</option>
							</select>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
						<label for="contactupdateresult">Result</label>
							<td><select id="contactupdateresult" class="form-control" name="contactupdateresult">
								<option value="Contacted" <?PHP if ($contactResult == "Contacted") {echo "selected";}; ?>>Contacted</option>
								<option value="Voicemail" <?PHP if ($contactResult == "Voicemail") {echo "selected";}; ?>>Voicemail</option>
								<option value="Incoming" <?PHP if ($contactResult == "Incoming") {echo "selected";}; ?>>Incoming</option>
								<option value="Future" <?PHP if ($contactResult == "Future") {echo "selected";}; ?>>Future</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="contactupdatedate">Date</label>
							<input type="date" id="contactupdatedate" name="contactupdatedate" class="form-control" value="<?PHP echo $data['contactDate']; ?>">
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="contactupdatetime">Time</label>
							<input type="time" id="contactupdatetime" name="contactupdatetime" class="form-control" value="<?PHP echo $data['contactTime']; ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<label for="contactupdatenote">Notes</label>
						<textarea id="contactupdatenote" class="form-control" name="contactupdatenote" rows="4" cols="40" value=""><?PHP echo $data['contactNotes']; ?></textarea>
					</div>
				</div>
			</div>
			<div class="card-footer d-flex justify-content-between align-items-center">
				<input type="submit" class="btn" name="contactupdatesubmit" value="Update Contact">
				<a href="contact.php" id="contactupdatecancel">Cancel</a>
			</div>
			</form>
	</section>
	<?PHP
	}
	}
	include("includes/footer.php");
    ?>