<?PHP
include("includes/header.php");
// this updates a contact then redirects to contact.php
if(isset($_POST['contactupdatesubmit'])){
	require('includes/db_conn.php');
	// print_r($_POST);
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
	<section id="contact_edit">
		<div id="contact_edit_image"><img src="media/companies/<?PHP echo $data['contactName']; ?>.png"></div>
		<div id="contact_edit_name"><?PHP echo $data['contactName']; ?></div><br>
		<h3><img id="contact_editimg" src="media/update.png">&nbsp;&nbsp;Update CONTACT?</h3>
		<form id="contact_edit_form" name="contact_edit_form" action="editcontact.php" method="POST">
				<input type="hidden" name="contactupdateID" value="<?PHP echo $data['contactID']; ?>">
				<table>
					<tr>
						<td>Type</td>
						<td><select id="contactupdatetype" name="contactupdatetype">
							<option value="" <?PHP if ($contactType == "") {echo "selected";}; ?>></option>
							<option value="Phone" <?PHP if ($contactType == "Phone") {echo "selected";}; ?>>Phone</option>
							<option value="Text" <?PHP if ($contactType == "Text") {echo "selected";}; ?>>Text</option>
							<option value="Email" <?PHP if ($contactType == "Email") {echo "selected";}; ?>>Email</option>
							<option value="In Person" <?PHP if ($contactType == "In Person") {echo "selected";}; ?>>In Person</option>
						</select>
						</td>
						<td>Result</td>
						<td><select id="contactupdateresult" name="contactupdateresult">
							<option value="Contacted" <?PHP if ($contactResult == "Contacted") {echo "selected";}; ?>>Contacted</option>
							<option value="Voicemail" <?PHP if ($contactResult == "Voicemail") {echo "selected";}; ?>>Voicemail</option>
							<option value="Incoming" <?PHP if ($contactResult == "Incoming") {echo "selected";}; ?>>Incoming</option>
							<option value="Future" <?PHP if ($contactResult == "Future") {echo "selected";}; ?>>Future</option>
						</select>
						</td>
					</tr>
					<tr>
						<td>Date</td><td><input type="date" name="contactupdatedate" value="<?PHP echo $data['contactDate']; ?>"></td>
						<td>Time</td><td><input type="time" name="contactupdatetime" value="<?PHP echo $data['contactTime']; ?>"></td>
					</tr>
					<tr>
						<td for="contactupdatenote">Notes</td>
						<td colspan="3"><textarea id="contactupdatenote" name="contactupdatenote" rows="4" cols="50" value=""><?PHP echo $data['contactNotes']; ?></textarea></td>
					</tr>
					<tr><td colspan="4"><input type="submit" name="contactupdatesubmit" value="Update Contact"></td></tr>
				</table>
				<a href="contact.php" id="contactupdatecancel">Cancel</a>
			</form>

	</section>
	<?PHP
	}
	}
	include("includes/footer.php");
    ?>