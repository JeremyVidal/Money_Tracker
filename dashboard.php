<?PHP
include("includes/header.php");
$current_user =  $_SESSION['userID'];

//category_graph
$results = $conn->query("SELECT sum(`paymentPaidAmount`) as YTD, paymentCategory FROM payment WHERE MONTH(`paymentDate`) = MONTH(CURRENT_DATE()) AND `userID` = '$current_user' GROUP BY paymentCategory;");
while($data = $results->fetch()){
    $paymentCategory = $data['paymentCategory'];
    $paymentPaidAmount = $data['YTD'];
    $YTD_data[] = array("label"=>$paymentCategory, "y"=>$paymentPaidAmount);
}
//income_graph
$results = $conn->query("SELECT sum(`incomeGross`) as Gross, sum(`incomeNet`) as Net FROM income WHERE MONTH(`incomeDate`) = MONTH(CURRENT_DATE()) AND `userID` = '$current_user';");
while($data = $results->fetch()){
    $incomeGross = $data['Gross'];
    $incomeNet = $data['Net'];
    $incomeTaxes = $incomeGross - $incomeNet;
    $income_data[] = array("label"=>"Gross", "y"=>$incomeGross);
    $income_data[] = array("label"=>"Net", "y"=>$incomeNet);
    $income_data[] = array("label"=>"Taxes", "y"=>$incomeTaxes);
}
//bill_graph
$results = $conn->query("SELECT * FROM `payment` WHERE MONTH(paymentDate) = MONTH(CURRENT_DATE()) AND `paymentCategory` != 'Living' AND `userID` = '$current_user' ORDER BY paymentDate ASC;");
// $bill_data = array("label"=>"Bills", "y"=>0);
while($data = $results->fetch()){
    $paymentName = $data['paymentName'];
    $paymentPaidAmount = $data['paymentPaidAmount'];
    $bill_data[] = array("label"=>$paymentName, "y"=>$paymentPaidAmount);
}
?>
<style>
	/* Dashboard */
	.dash_links{color: red;}
	.dash_img {width: 18px;}
	.dash_graphs {height: 220px; width: 300px; display: inline-block;}
	#graphs {margin: 25px 0 50px 0;}

</style>
<section class="conatiner" style="height: 100vh; padding: 25px;">
	<section class="row">
		<section class="col-lg-6 my_tables">
			<table class="table table-striped table-sm">
				<h4>Upcoming Events</h4>
				<tr><th>Due Date</th><th></th><th>Time</th><th></th><th>Type</th><th></th><th>Name</th></tr>
				<?PHP 
				// union query to connect data from the account and contact tables. 
				// this is for the upcoing accont payments and any future contact evens that have been made 
				$results = $conn->query("(
					SELECT `accountDueDate` as `eventDate`, `accountDueTime` as `eventTime` , `accountName` as `eventName`, `accountType` as `eventType`
					FROM `account` 
					WHERE `accountID` NOT IN (select `accountID` from `payment` where `accountID` != 'NULL'  AND MONTH(`paymentDate`) = MONTH(CURRENT_DATE()) AND `userID` = '$current_user' AND `accountDueDate` !=  'NULL') AND `userID` = '$current_user' )     
					UNION
					(SELECT `contactDate` as `eventDate`, `contactTime` as `eventTime`, `contactName` as `eventName`, `contactType` as `eventType`
					FROM `contact`
					WHERE `contactResults` = 'Future' AND MONTH(`contactDate`) = MONTH(CURRENT_DATE()) AND `userID` = '$current_user')
					ORDER BY `eventDate` ASC;
				");
				while($data = $results->fetch()){
					$eventDate = $data['eventDate'];
					$eventTime = date("h:i A", strtotime($data['eventTime']));
					$eventName = $data['eventName'];
					$eventType = $data['eventType'];
					if ($eventType == 'Future'){
						$contactImage = '<img src="media/contact.png">';
					}
					else {
						$contactImage = '';
					}
					echo "<tr><td style=\"text-align: center;\">$eventDate</td><td style=\"width: 50px;\">$contactImage</td><td>$eventTime</td><td><img class=\"dash_img\" src=\"media/$eventType.png\"></td><td>$eventType</td><td><img class=\"dash_img\"  src=\"media/companies/$eventName.png\"></td><td>$eventName</td></tr>";
				};?>
			</table>
		</section>
		<section class="col-lg-6 my_tables">
			<table class="table table-striped table-sm">
				<h4>Income</h4>
			<tr><th></th><th>Company</th><th>Date</th><th>Gross</th><th>Net</th></tr>
			<?PHP
				$results = $conn->query("SELECT * FROM `income` WHERE YEAR(incomeDate) = YEAR(CURRENT_DATE()) AND `userID` = '$current_user' ORDER BY incomeDate DESC;");
				while($data = $results->fetch()){
						$incomeSource = $data['incomeSource'];
						$incomeDate = $data['incomeDate'];
						$incomeGross = $data['incomeGross'];
						$incomeNet = $data['incomeNet'];
					echo "<tr><td><img class=\"dash_img\" src=\"media/income.png\"></td><td>$incomeSource</td><td>$incomeDate</td><td>$$incomeGross</td><td>$$incomeNet</td></tr>";
				};?>
			</table>
		</section>
	</section>

	<section id="graphs" class="row justify-content-around text-center">
		<div id="YTD_graph" class="dash_graphs"></div><br />
		<div id="income_graph" class="dash_graphs"></div><br />
		<div id="bill_graph" class="dash_graphs"></div>
	</section>

	<section class="row">
		<section class="col-lg-4 my_tables"> 
			<table class="table table-striped table-sm">
			<h4>Category Totals</h4>
				<tr><th></th><th>Category</th><th>MTD</th><th>YTD</th></tr>
				<?PHP
					$results = $conn->query("SELECT sum(`paymentPaidAmount`) as YTD, paymentCategory FROM payment WHERE YEAR(`paymentDate`) = YEAR(CURRENT_DATE()) AND `userID` = '$current_user' GROUP BY paymentCategory;");
					while($data = $results->fetch()){
						$paymentCategory = $data['paymentCategory'];
						$paymentPaidAmountYTD = $data['YTD'];
						echo "<tr><td><img class=\"dash_img\" src=\"media/$paymentCategory.png\"></td><td>$paymentCategory</td><td>$$paymentPaidAmountMTD</td><td>$$paymentPaidAmountYTD</td></tr>";
					};?>
			</table>
		</section>
		<section class="col-lg-4 my_tables">
			<table class="table table-striped table-sm">
				<h4>Contact Activities</h4>
				<tr><th></th><th>Date</th><th>Time</th><th>Type</th><th>Name</th></tr>
			<?PHP
				$results = $conn->query("SELECT * FROM `contact` WHERE MONTH(contactDate) = MONTH(CURRENT_DATE()) AND `userID` = '$current_user' AND `contactResults` != 'Future' ORDER BY contactDate DESC, contactTime DESC;");
				while($data = $results->fetch()){
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
					echo "<tr><td><img class=\"dash_img\" src=\"media/$phone_results.png\"></td><td>$contactDate</td><td>$contactTime</td><td><img class=\"dash_img\" src=\"media/$contactType.png\"></td><td>$contactName</td></tr>";
				};?>
			</table>
		
		</section>
		<section class="col-lg-4 my_tables">
			<table class="table table-striped table-sm">
				<h4>Payments</h4>
					<tr><th></th><th>Date</th><th>Name</th><th>Payment</th></tr>
					<?PHP
					$results = $conn->query("SELECT * FROM `payment` WHERE MONTH(paymentDate) = MONTH(CURRENT_DATE()) AND `paymentCategory` != 'Living' AND `userID` = '$current_user' ORDER BY paymentDate DESC, paymentTime DESC;");
					while($data = $results->fetch()){
						$paymentDate = $data['paymentDate'];
						$paymentTime = date("h:i A", strtotime($data['paymentTime']));
						$paymentName = $data['paymentName'];
						$paymentPaidAmount = $data['paymentPaidAmount'];
					echo "<tr><td><img class=\"dash_img\" src=\"media/companies/$paymentName.png\"></td><td>$paymentDate</td><td>$paymentName</td><td>$$paymentPaidAmount</td></tr>";
					};?>
				</table>
		</section>
	</section>
</section>
<!-- Javascript for Charts -->
<script>
    window.onload = function() {
        CanvasJS.addColorSet("greenShades",
                [//colorSet Array
                "#2F4F4F",
                "#008080",
                "#2E8B57",
                "#3CB371",
                "#90EE90"                
                ]);
        // Section Chart
        var chart = new CanvasJS.Chart("YTD_graph", {
            theme: "light2",
            // colorSet: "greenShades",
            animationEnabled: true,
            title: {
                text: "Categories (MTD)"
            },
            data: [{
                type: "pie",
                yValueFormatString: "$#,##0.00",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($YTD_data, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

        // Incoming Chart
        var chart = new CanvasJS.Chart("income_graph", {
            theme: "light2",
            // colorSet: "greenShades",
            animationEnabled: true,
            title: {
                text: "Income (MTD)"
            },
            data: [{
                type: "funnel",
                yValueFormatString: "$#,##0.00",
                indexLabel: "{label} ({y})",
                dataPoints: <?php echo json_encode($income_data, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();
        // Bill Chart
        var chart = new CanvasJS.Chart("bill_graph", {
            theme: "light2",
            // colorSet: "greenShades",
            animationEnabled: true,
            title: {
                text: "Payments (MTD)"
            },
            data: [{
                type: "doughnut",
                yValueFormatString: "$#,##0.00",
                indexLabel: "{label} ({y})",
                dataPoints: <?PHP echo json_encode($bill_data, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
</script>
<?PHP
include("includes/footer.php");
?>