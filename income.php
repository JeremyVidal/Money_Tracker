<?PHP
include("includes/header.php");
$current_user =  $_SESSION['userID'];
//income_graph
$results = $conn->query("SELECT sum(`incomeGross`) as Gross, sum(`incomeNet`) as Net FROM income WHERE YEAR(`incomeDate`) = YEAR(CURRENT_DATE()) AND `userID` = '$current_user';");
while($data = $results->fetch()){
    $incomeGross = $data['Gross'];
    $incomeNet = $data['Net'];
	$incomeTaxes = $incomeGross - $incomeNet;
	$income_data[] = array("label"=>"Gross", "y"=>$incomeGross);
	$income_data[] = array("label"=>"Net", "y"=>$incomeNet);
	$income_data[] = array("label"=>"Taxes", "y"=>$incomeTaxes);
}
if(isset($_POST['incomesubmit'])){
    // print_r($_POST);
    $incomesource = $_POST['incomesource'];
    $incomedate = $_POST['incomedate'];
    $incomegross = $_POST['incomegross'];
    $incomenet = $_POST['incomenet'];
    $incomenote = $_POST['incomenote'];

    $addIncome = "INSERT INTO `income` (`incomeID`, `incomeSource`, `incomeDate`, `incomeGross`, `incomeNet`, `incomeNote`, `userID`)
    VALUES (NULL, '$incomesource', '$incomedate', '$incomegross', '$incomenet', '$incomenote', '$current_user')";
    $conn->query($addIncome);
    ?><script type="text/javascript">location.href='income.php';</script><?PHP
}
else if(isset($_POST['incomedeleteID'])){
    $_SESSION['incomedeleteID'] = $_POST['incomedeleteID'];
    ?><script type="text/javascript">location.href='deleteincomeconfirm.php';</script><?PHP
}
else if(isset($_POST['incomeeditID'])){
    $_SESSION['incomeeditID'] = $_POST['incomeeditID'];
    ?><script type="text/javascript">location.href='editincome.php';</script><?PHP
}
else{
    display_form();
}

function display_form(){
    require('includes/db_conn.php');
    $current_user =  $_SESSION['userID'];
    global $CURRENT_DATE;
	?>
	<style>

		/* Income */
		#income_graph {float: right; height: 220px; width: 300px;}
		.record_images {width: 20px;}
		#income_table {margin-top: 30px;}
		#income_table th{background-color: #4f81bc; color: white;}
		#income_add_button {background-color: #4f81bc; color: white; margin-left: 15px;}
		.buttons {border: none; background-color: white;}

	</style>
    <section class="container" style="padding: 25px">
		<div class="row">
			<div class="col-lg-6">
				<form class="form" name="income_form" action="income.php" method="POST">
				<div class="d-flex justify-content-between">
						<div>	
							<h4>Add Income</h4>
						</div>
						<div>
							<span style="color: red; font-size: 12px;">*</span><span style="font-size: 12px;"> = required</span>
						</div>
					</div>
					<br />
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Source <span style="color: red;">*</span></label>
								<input list="source" class="form-control mb-4" id="incomesource" name="incomesource" required>
								<datalist id="source">
									<?PHP 
										$result = $conn->query("SELECT DISTINCT `incomeSource` FROM `income`;");
										while($record = $result->fetch()){
											$incomeSource = $record['incomeSource'];
											echo "<option value=\"$incomeSource\">";
										};
										?>
								</datalist>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Date <span style="color: red;">*</span></label> 
								<input type="date" class="form-control mb-4" name="incomedate" size='35' value="<?PHP echo $CURRENT_DATE; ?>" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Gross Pay <span style="color: red;">*</span></label>
								<input type="number" class="form-control mb-4" name="incomegross" min="0.00" step="0.01" size='5' required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Net Pay <span style="color: red;">*</span></label>
								<input type="number" class="form-control mb-4" name="incomenet" min="0.00" step="0.01" size='5' required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div  class="form-group">
								<label>Notes</label>
								<td colspan="3"><textarea class="form-control rounded-0" name="incomenotes" rows="2" cols="50" value="" max-length="200" ></textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<button class="btn" id="income_add_button" name="incomesubmit" type="submit">Add Income</button>
						<!-- <input type="submit" value="Add Income" name="incomesubmit"> -->
					</div>
				</form>
			</div>
			<div class="col-lg-6">
				<div id="income_graph"></div>
			</div>
		</div>
	</section>
	<hr />
	<section class="container" id="income_table">
		<table class="table table-sm">
			<h4>Income Activity (YTD)</h4>
			<tr><th></th><th>Company</th><th>Date</th><th>Gross</th><th>Net</th><th>Taxes</th><th></th><th></th></tr>
		<?PHP
			$results = $conn->query("SELECT * FROM `income` WHERE YEAR(incomeDate) = YEAR(CURRENT_DATE()) AND `userID` = '$current_user' ORDER BY incomeDate DESC;");
			while($data = $results->fetch()){
				$incomeID = $data['incomeID'];
				$incomeSource = $data['incomeSource'];
				$incomeDate = $data['incomeDate'];
				$incomeGross = $data['incomeGross'];
				$incomeNet = $data['incomeNet'];
				$incomeTaxes = $incomeGross - $incomeNet;
				echo "
					<tr>
						<td><img class=\"record_images\" src=\"media/income.png\"></td><td>$incomeSource</td><td>$incomeDate</td><td>$$incomeGross</td><td>$$incomeNet</td><td>$$incomeTaxes</td>
						<td>
							<form name=\"income_edit\" method=\"POST\">
								<input type=\"hidden\" name=\"incomeeditID\" value=\"$incomeID\">
								<button class=\"buttons\"><img class=\"record_images\" src=\"media/edit.ico\"></button>
							</form>
						</td>
						<td>
							<form name=\"income_delete\" method=\"POST\">
								<input type=\"hidden\" name=\"incomedeleteID\" value=\"$incomeID\">
								<button class=\"buttons\"><img class=\"record_images\" src=\"media/delete.ico\"></button>
							</form>
						</td>
					<tr>
				";
			};
		?>
		</table>
    </section>
<?PHP
};
?>
<script>
    window.onload = function() {    
        // Incoming Chart
            var chart = new CanvasJS.Chart("income_graph", {
                theme: "light2",
                // colorSet: "greenShades",
                animationEnabled: true,
                title: {
                    text: "Income (YTD) Graph"
                },
                data: [{
                    type: "funnel",
                    yValueFormatString: "$#,##0.00",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($income_data, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
    }
</script>
<?PHP
	include("includes/footer.php");
?>