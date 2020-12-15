<?PHP
include("includes/header.php");
// this updates a contact then redirects to income.php
if(isset($_POST['incomeupdatesubmit'])){
	require('includes/db_conn.php');
	$incomeupdateID = $_POST['incomeupdateID'];
	$incomeeditsource = $_POST['incomeeditsource'];
	$incomeupdatedate = $_POST['incomeupdatedate'];
	$incomeupdategross = $_POST['incomeupdategross'];
	$incomeupdatenet = $_POST['incomeupdatenet'];
	$incomeupdatenotes = $_POST['incomeupdatenotes'];
	
	$updateIncome = "UPDATE `income` 
		SET
			`incomeSource` = '$incomeeditsource',
			`incomeDate` = '$incomeupdatedate',
			`incomeGross` = '$incomeupdategross',
			`incomeNet` = '$incomeupdatenet',
			`incomeNote` = '$incomeupdatenotes'
		WHERE `incomeID` = '$incomeupdateID';
	";
	$conn->query($updateIncome);
	?><script type="text/javascript">location.href='income.php';</script><?PHP
}
else{
	display_form();
}
function display_form(){
	require('includes/db_conn.php');
	$incomeeditID = $_SESSION['incomeeditID'];
	$results = $conn->query("SELECT * FROM `income` WHERE `incomeID` = '$incomeeditID';");
	while($data = $results->fetch()){
	$updatesource = $data['incomeSource'];

	?>
	<style>
		/* EditIncome */
		#income_edit {width: 40%; margin: 200px auto 0 auto; padding: 10px;}	
		#income_editimg{width: 30px;}
		.income_pay_img{width: 60px;}
	</style>
	<section id="income_edit">
	<div class="card">
		<form class="form" name="income_edit_form" action="editincome.php" method="POST">
			<input type="hidden" name="incomeupdateID" value="<?PHP echo $data['incomeID']; ?>">
			<div class="card-header d-flex justify-content-between">
				<h5><img id="income_editimg" src="media/update.png">&nbsp;&nbsp;Update INCOME?</h5>
				<div class="d-flex">
					<p><?PHP echo $data['incomeSource']; ?></p>
					<img class="income_pay_img" src="media/Income.png">
				</div>
			</div>
			<div class="card-body">
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="incomeeditsource">Source</label>
						<input type="text" class="form-control" id="incomeeditsource" name="incomeeditsource" value="<?PHP echo $data['incomeSource']; ?>">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="incomeupdatedate">Date</label>
						<input type="date" class="form-control" id="incomeupdatedate" name="incomeupdatedate" size='35' value="<?PHP echo $data['incomeDate']; ?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="form-group">
						<label for="incomeupdategross">Gross Pay</label>
						<input type="number" class="form-control" id="incomeupdategross" name="incomeupdategross" min="0.00" step="0.01" size='5' value="<?PHP echo $data['incomeGross']; ?>">		
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<label for="incomeupdatenet">Net Pay</label>
						<input type="number" class="form-control" id="incomeupdatenet" name="incomeupdatenet" min="0.00" step="0.01" size='5' value="<?PHP echo $data['incomeNet']; ?>">			
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label for="incomeupdatenotes">Notes</label>
						<textarea id="incomeupdatenotes" class="form-control" name="incomeupdatenotes" rows="4" cols="40" value=""><?PHP echo $data['incomeNote']; ?></textarea>	
					</div>
				</div>
			</div>
			<div class="card-footer d-flex justify-content-between align-items-center">
				<input type="submit" value="Update Income" name="incomeupdatesubmit" value="Update Income">
				<a href="income.php" id="incomeupdatecancel">Cancel</a>
			</div>
		</form>
	</section>
	<?PHP
	}
}
include("includes/footer.php");
?>