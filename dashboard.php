<?PHP
include("includes/header.php");
$current_user =  $_SESSION['userID'];

//category_graph
$results = $conn->query("SELECT sum(`paymentPaidAmount`) as YTD, paymentCategory FROM payment WHERE YEAR(`paymentDate`) = YEAR(CURRENT_DATE()) AND `userID` = '$current_user' GROUP BY paymentCategory;");
while($data = $results->fetch()){
    $paymentCategory = $data['paymentCategory'];
    $paymentPaidAmount = $data['YTD'];
    $YTD_data[] = array("label"=>$paymentCategory, "y"=>$paymentPaidAmount);
}
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
	.dash_links{color: black;}
	#upcoming_events {width: 95%; max-height: 200px; margin: 20px auto 20px auto; padding: 10px; overflow-y:auto;}
	#upcoming_table {width: 95%; margin: 20px auto; border-collapse: collapse;}
	#upcoming_table th {border-bottom: 1px solid #4f81bc; text-align: left;}
	#upcoming_table td {border-bottom: 1px solid #4f81bc; padding: 2px;}
	
	#graphs{margin-top: 25px;}
	#YTD_graph {height: 220px; width: 350px;}
	#income_graph {height: 220px; width: 350px;}
	#bill_graph {height: 220px; width: 350px;}

	#activity_table {width: 95%; margin: 0 auto; border-collapse: collapse;}
	#activity_table th {border-bottom: 1px solid #4f81bc; text-align: left;}
	#activity_table td {border-bottom: 1px solid #4f81bc; padding: 2px;}

	#contact_table_dash {width: 95%; margin: 10px auto; border-collapse: collapse;}
	#contact_table_dash th {border-bottom: 1px solid #4f81bc; text-align: left;}
	#contact_table_dash td {border-bottom: 1px solid #4f81bc; max-width: 150px; padding: 2px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}

	#income {width: 95%; height: 140px; margin: 20px auto 20px auto; padding: 10px; overflow-y:auto;}
	#income_table {width: 100%; margin-top: 20px; border-collapse: collapse;}
	#income_table th {border-bottom: 1px solid #4f81bc; text-align: left;}
	#income_table td {border-bottom: 1px solid #4f81bc; padding: 2px;}

	#bill_breakdown {width: 95%; height: 220px; margin: 20px auto 20px auto; padding: 10px; overflow-y:auto;}
	#breakdown_table {width: 95%; margin: 20px auto; border-collapse: collapse;}
	#breakdown_table th {border-bottom: 1px solid #4f81bc; text-align: left;}
	#breakdown_table td {border-bottom: 1px solid #4f81bc;}
	.dash_img {width: 20px;}
</style>
<section class="conatiner">
	<section class="row justify-content-center">
		<section class="col-lg-6">
			<h3>Upcoming Events</h3>
			<table id="upcoming_table">
				<tr><th>Due Date</th><th></th><th>Time</th><th></th><th>Type</th><th></th><th>Name</th></tr>
				<?PHP 
				// union query to connect data from the account and contact tables. 
				// this is for the upcoing accont payments and any future contact evens that have been made 
				$results = $conn->query("(SELECT `accountDueDate` as `eventDate`, `accountDueTime` as `eventTime` , `accountName` as `eventName`, `accountType` as `eventType`
				FROM `account` 
				WHERE `accountID` NOT IN (select `accountID` from `payment` where `accountID` != 'NULL'  AND MONTH(`paymentDate`) = MONTH(CURRENT_DATE()) AND `userID` = '$current_user') AND `accountDueDate` !=  'NULL')     
				UNION
				(SELECT DAY(`contactDate`) as `eventDate`, `contactTime` as `eventTime`, `contactName` as `eventName`, `contactType` as `eventType`
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
		<section class="col-lg-6">
			<h3><a href="income.php" class="dash_links">Income</a></h3>
			<table id="income_table">
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
	<sectiom id="graphs" class="row justify-content-center">
		<section class="col-lg-4">	
			<div id="YTD_graph"></div>
		</section>
		<section class="col-lg-4">	
			<div id="income_graph"></div>
		</section>
		<section class="col-lg-4">	
			<div id="bill_graph"></div>
		</section>
	</section>
	<section class="row justify-content-around">
		<section class="col-lg-6"> 
			<h3>Payments (YTD)</h3>
			<table id="activity_table">
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
	</section>
<section class="container"> -->
	<section class="row justify-content-around">
		<section class="col-lg-6">
			<h3><a href="contact.php" class="dash_links">Contact Activities</a></h3>
			<table id="contact_table_dash">
			<tr><th></th><th>Date</th><th>Time</th><th>Type</th><th>Name</th><th>Notes</th></tr>
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
					echo "<tr><td><img class=\"dash_img\" src=\"media/$phone_results.png\"></td><td>$contactDate</td><td>$contactTime</td><td><img class=\"dash_img\" src=\"media/$contactType.png\"></td><td>$contactName</td><td>$contactNotes</td></tr>";
				};?>
			</table>
		
		</section>
		<section class="col-lg-6">
				<h3><a href="payments.php" class="dash_links" >Payments</a></h3>
				<table id="breakdown_table">
					<tr><th></th><th>Date</th><th>Time</th><th>Name</th><th>Payment</th></tr>
					<?PHP
					$results = $conn->query("SELECT * FROM `payment` WHERE MONTH(paymentDate) = MONTH(CURRENT_DATE()) AND `paymentCategory` != 'Living' AND `userID` = '$current_user' ORDER BY paymentDate DESC, paymentTime DESC;");
					while($data = $results->fetch()){
						$paymentDate = $data['paymentDate'];
						$paymentTime = date("h:i A", strtotime($data['paymentTime']));
						$paymentName = $data['paymentName'];
						$paymentPaidAmount = $data['paymentPaidAmount'];
					echo "<tr><td><img class=\"dash_img\" src=\"media/companies/$paymentName.png\"></td><td>$paymentDate</td><td>$paymentTime</td><td>$paymentName</td><td>$$paymentPaidAmount</td></tr>";
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
                text: "Payments (YTD)"
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
                text: "Income (YTD)"
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
                text: "Bills (MTD)"
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