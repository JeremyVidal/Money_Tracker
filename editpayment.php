<?PHP
include("includes/header.php");
// this updates a contact then redirects to to either payments.php or ledger.php
if(isset($_POST['updatesubmit'])){
	require('includes/db_conn.php');
	// print_r($_POST);
	$updateID = $_POST['updateID'];
	$updatedate = $_POST['editdate'];
	$updatetime = $_POST['edittime'];
	$paymentdescription = $_POST['editnotes'];

	$updateamount = $_POST['editamount'];
	$updatetype = $_POST['edittype'];
	$script_path = $_POST['script_path'];
	$updatePayment = "UPDATE `payment` 
		SET
			`paymentDate` = '$updatedate',
			`paymentTime` = '$updatetime',
			`paymentDescription` = '$paymentdescription',
			`paymentPaidAmount` = '$updateamount',
			`paidType` = '$updatetype'
		WHERE `paymentID` = '$updateID';
	";
	$conn->query($updatePayment);
	?><script type="text/javascript">location.href='<? echo $script_path;?>'</script><?PHP
}
else{
	display_form();
}
function display_form(){
	require('includes/db_conn.php');
	// this form is used to update a transaction from both payments.php and ledger.php
	if (isset($_POST['payeditID'])){
		$payeditID = $_POST['payeditID'];
		$script_path = "payments.php";
	}
	else if(isset($_POST['ledgereditID'])){
		$payeditID = $_POST['ledgereditID'];
		$script_path = "ledger.php";
	}
	$results = $conn->query("SELECT * FROM `payment` WHERE `paymentID` = '$payeditID';");
	while($data = $results->fetch()){
		$paidtype =  $data['paidType'];
	?>
<style>
	/* EditPayment */
	#payment_edit {width: 40%; margin: 200px auto 0 auto; padding: 10px;}	
	#edit_pay_img{width: 30px;}
	.edit_pay_img{width: 60px;}
</style>
<section id="payment_edit">

	<div class="card">
		<form class="form" name="payment_update" action="editpayment.php" method="POST">
			<input type="hidden" name="updateID" value="<?PHP echo $data['paymentID']; ?>">
			<input type="hidden" name="script_path" value="<?PHP echo $script_path; ?>">
			<div class="card-header d-flex justify-content-between">
				<div><h5><img id="edit_pay_img" src="media/update.png">&nbsp;&nbsp;Update RECORD?</h5></div>
				<div class="d-flex">
					<img class="edit_pay_img" src="media/<?PHP echo $data['paymentType']; ?>.png">
					<p><?PHP echo $data['paymentName']; ?></p>
				</div>
			</div>
			<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="accountName">Date</label>
						<input type="date" class="form-control" id="editdate" name="editdate" value="<?PHP echo $data['paymentDate']; ?>">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="edittime">Time</label>
						<input type="time" class="form-control" id="edittime" name="edittime" value="<?PHP echo $data['paymentTime']; ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<label for="editnotes">Description</label>
					<textarea id="editnotes" class="form-control" name="editnotes" rows="2" cols="40" value=""><?PHP echo $data['paymentDescription']; ?></textarea>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<label for="editamount">Amount</label>
					<input type="number" class="form-control" id="editamount" name="editamount" size="10" min="0.00" step="0.01" value="<?PHP echo $data['paymentPaidAmount']; ?>">
				</div>
				<div class="col-lg-6">
					<label for="editamount">Type</label>
					<select id="edittype" class="form-control" name="edittype">
						<option value="Cash" <?PHP if ($paidtype == "") {echo "selected";}; ?>></option>
						<option value="Cash" <?PHP if ($paidtype == "Cash") {echo "selected";}; ?>>Cash</option>
						<option value="Card" <?PHP if ($paidtype == "Card") {echo "selected";}; ?>>Card</option>
						<option value="Check" <?PHP if ($paidtype == "Check") {echo "selected";}; ?>>Check</option>
						<option value="Online" <?PHP if ($paidtype == "Online") {echo "selected";}; ?>>Online</option>
						<option value="Auto Pay" <?PHP if ($paidtype == "Auto Pay") {echo "selected";}; ?>>Auto Pay</option>
						<option value="In Person" <?PHP if ($paidtype == "In Person") {echo "selected";}; ?>>In Person</option>
					</select>
				</div>
			</div>
			</div>
			<div class="card-footer d-flex justify-content-between align-items-center">
				<input type="submit" name="updatesubmit" value="Update Payment">
				<a href="<?PHP echo $script_path; ?>" id="updatecancel">Cancel</a>
			</div>
		</form>
	</div>



</section>
	<?PHP
	}
}
include("includes/footer.php");
?>