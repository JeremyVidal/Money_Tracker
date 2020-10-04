<?PHP
include("includes/header.php");
$current_user =  $_SESSION['userID'];
// this creates a payment transaction
if (isset($_POST['paymentsubmit'])){
    $paymentcategory = $_POST['paymentcategory'];
    $paymenttype = $_POST['paymenttype'];
    $paymentname = $_POST['paymentname'];
    $accountID = $_POST['accountid'];
    $paiddate = $_POST['paiddate'];
    $paidtime = $_POST['paidtime'];
    $paidamount = $_POST['paidamount'];
    $paidtype = $_POST['paidtype'];
    
    $addPayment = "INSERT INTO `payment` (`paymentID`, `paymentDate` , `paymentTime` , `paymentCategory`, `paymentType`, `paymentName`, `paymentDescription`, `paymentPaidAmount`, `paidType`, `accountID`, `userID`)
    VALUES (NULL, '$paiddate', '$paidtime', '$paymentcategory', '$paymenttype', '$paymentname', NULL, '$paidamount', '$paidtype', '$accountID', '$current_user' )"; 
    $conn->query($addPayment);
    ?><script type="text/javascript">location.href='payments.php';</script><?
}
else if(isset($_POST['paydeleteID'])){
    $_SESSION['paydeleteID'] = $_POST['paydeleteID'];
    ?><script type="text/javascript">location.href='deletepayconfirm.php';</script><?
}
// this uses JavaScript to open paymentdoc.php in a window over the browser
else if (isset($_POST['payprintID'])){
    $_SESSION['payprintID'] = $_POST['payprintID'];
    ?><script>
		var Window; 
		Window = window.open("paymentdoc.php", "_blank", "width=600, height=700, left=300");
    </script><?
    display_form();
}
// this uses JavaScript to open paymentenv.php in a window over the browser
else if (isset($_POST['payenvelopeID'])){
    $_SESSION['payenvelopeID'] = $_POST['payenvelopeID'];
    ?><script>
    var Window; 
    Window = window.open("paymentenv.php", "_blank", "width=950, height=350, left=300, top=150");
    </script><?
    display_form();
}
else if (isset($_POST['acctpaysubmit'])){
	$_SESSION['current_payment_id'] = $_POST['acctpayID'];
    ?><script type="text/javascript">location.href='payments.php';</script><?
}
else{
    display_form();
};

function display_form(){
    require('includes/db_conn.php');
    $current_user =  $_SESSION['userID'];
    if (isset($_SESSION['current_payment_id'])){
        $current_payment_id = $_SESSION['current_payment_id'];
    }
    else{
        $current_payment_id = 1;
    }
    global $CURRENT_DATE;
    
    //bill_graph
    $results = $conn->query("SELECT sum(`paymentPaidAmount`) as YTD, paymentName FROM payment WHERE YEAR(`paymentDate`) = YEAR(CURRENT_DATE()) AND `userID` = '$current_user'  AND `paymentCategory` !='Living' GROUP BY paymentName;");
    $YTD_data = array();
    while($data = $results->fetch()){
        $paymentName = $data['paymentName'];
        $paymentPaidAmount = $data['YTD'];
        $YTD_data[] = array("label"=>$paymentName, "y"=>$paymentPaidAmount);
    }
	?>
	<style>
	/* Payments */
	#payment_add_button {background-color: #4f81bc; color: white; margin-left: 15px;}
	#YTD_graph {float: right; height: 220px; width: 350px;}
	.payment_main {position: absolute; width: 87%; margin-left: 16%; padding: 25px; display: inline-block;}
	.account_image {width: 60px;}
	.account_button {border: none; background-color: white;}
	.payment_img{width: 20px;}
	.payment_side_links{padding: 7px; min-width: 175px; border: none; text-decoration: none; color: black; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;}
	.payment_side_links:hover {color: black; background-color: #F0F0F0;}
	.sidebar {position: fixed; top: 132px; bottom: 0; left: 0; z-index: 1000; display: block; padding: 20px; overflow-x: hidden; overflow-y: auto; border-right: 1px solid #eee;}
	</style>
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-3 col-md-2 sidebar">
				<h4>Select Account</h4>
				<hr />
				<?PHP 
					// this creates the sidebar selections
					$result = $conn->query("SELECT DISTINCT `accountCategory` FROM `account` WHERE `userID` = '$current_user'");
					while($record = $result->fetch()){
						$accountCategory = $record['accountCategory'];
						echo "<h5>$accountCategory</h5>";
						echo "<ul class=\"nav flex-column\">";
						$results = $conn->query("SELECT `accountName`, `accountID` FROM `account` WHERE `accountCategory` = '$accountCategory' AND `userID` = '$current_user';");
						while($data = $results->fetch()){
							$accountName = $data['accountName'];
							$accountID = $data['accountID'];
							echo "<li class=\"nav-item\">
							<form name=\"acct\" class=\"nav-link active\"  action=\"payments.php\" method=\"POST\">
								<input type=\"hidden\" name=\"acctpayID\" value=\"$accountID\">
								<input type=\"submit\" name = \"acctpaysubmit\" class=\"payment_side_links\" value=\"$accountName\" style=\"text-align: left;\">
							</form>
							</li>";
						};
						echo "</ul>";
					};
				?>
			</div>
		</div>
	</div>
	<section class="payment_main">
		<?PHP
        $results = $conn->query("SELECT * FROM `account` WHERE `accountID` = '$current_payment_id' AND `userID` = '$current_user';");
        while($data = $results->fetch()){
			?>
			<div class="conatiner">
				<div class="row">
					<div class="col-lg-6">
						<div class="d-flex justify-content-between">
							<div>
								<h4>Add Payment</h4>
							</div>
							<div class="d-flex">
								<h6><?PHP echo $data['accountName']; ?></h6>
								<img class="account_image" src="media/companies/<?PHP echo $data['accountName']; ?>.png">
							</div>
						</div>
						<form class="form" name="payment_add" action="payments.php" method="POST">
							<input type="hidden" name="paymentcategory" style="display: none;" value="<?PHP echo $data['accountCategory']; ?>"><br>
							<input type="hidden" name="paymenttype" style="display: none;" value="<?PHP echo $data['accountType']; ?>">
							<input type="hidden" name="paymentname" style="display: none;" value="<?PHP echo $data['accountName']; ?>">
							<input type="hidden" name="accountid" style="display: none;" value="<?PHP echo $data['accountID']; ?>">
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
										<label for="date">Date <span style="color: red;">*</span></label>
										<input type="date" class="form-control" id="date" name="paiddate"  value="<?PHP echo $CURRENT_DATE;?>" aria-describedby="dateHelp" required>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="accountDueDate">Time <span style="color: red;">*</span></label>
										<input type="time" class="form-control" id="accountDueDate"  name="paidtime" value="<?PHP echo $CURRENT_DATE;?>" aria-describedby="timeHelp" required>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label for="amount">Amount <span style="color: red;">*</span></label>
										<input type="number" class="form-control" id="amount" name="paidamount"  value="<?PHP echo $CURRENT_DATE;?>" aria-describedby="amountHelp" min="0.00" step="0.01" required>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label for="type">Type <span style="color: red;">*</span></label>
										<select class="form-control" id="type" name="paidtype" required>
											<option value=""></option>
											<option value="Cash">Cash</option>
											<option value="Card">Card</option>
											<option value="Check">Check</option>
											<option value="Online">Online</option>
											<option value="Auto Pay">Auto Pay</option>
											<option value="In Person">In Person</option>
										</select>
									</div>
								</div>
							</div>
							<div class="row">
								<button class="btn" id="payment_add_button" name="paymentsubmit" type="submit">Add Payment</button>
							</div>
						</form>
					</div>
					<div class="col-lg-6">
						<div class="row">
							<div id="YTD_graph"></div>
						</div>
					</div>
				</div>
			</div>
        <?PHP
        };
		?>
		<div class="container">
			<div class="row" style="margin-top: 25px;">
				<table class="table table-striped table-sm">
					<h4>Payment Activity (MTD)</h4>
					<tr><th></th><th>Date</th><th>Type</th><th>Amount</th><th>Paid Type</th><th></th><th></th><th></th><th></th></tr>
					<?PHP
					$results = $conn->query("SELECT * FROM `payment` WHERE MONTH(paymentDate) = MONTH(CURRENT_DATE()) AND `userID` = '$current_user' AND `paymentCategory` !='Living' ORDER BY paymentDate DESC;");
					while($data = $results->fetch()){
						$paymentID = $data['paymentID'];
						$paymentDate = $data['paymentDate'];
						$paymentName = $data['paymentName'];
						$paymentPaidAmount = $data['paymentPaidAmount'];
						$paidType = $data['paidType'];
						$accountID = $data['accountID'];
						echo "
						<tr>
							<td><img class=\"payment_img\" src=\"media/companies/$paymentName.png\"></td><td>$paymentDate</td><td>$paymentName</td><td>$$paymentPaidAmount</td><td>$paidType</td>
							<td>
								<form name=\"payment_edit\" action=\"editpayment.php\" method=\"POST\">
									<input type=\"hidden\" name=\"payeditID\" value=\"$paymentID\">
									<button class=\"account_button\"><img class=\"payment_img\" src=\"media/edit.ico\"></button>
								</form>
							</td>
							<td>
								<form name=\"payment_delete\" action=\"deletepayconfirm.php\" method=\"POST\">
									<input type=\"hidden\" name=\"paydeleteID\" value=\"$paymentID\">
									<button class=\"account_button\"><img class=\"payment_img\" src=\"media/delete.ico\"></button>
								</form>
							</td>
							<td>
								<form name=\"payment_print\" action=\"payments.php\" method=\"POST\">
									<input type=\"hidden\" name=\"payprintID\" value=\"$paymentID\">
									<button class=\"account_button\" onclick=\"windowOpen()\"><img class=\"payment_img\" src=\"media/print.png\"></button>
								</form>                           
							</td>
							<td>
								<form name=\"payment_envelope\" action=\"payments.php\" method=\"POST\">
									<input type=\"hidden\" name=\"payenvelopeID\" value=\"$accountID\">
									<button class=\"account_button\"><img class=\"payment_img\" src=\"media/envelope.png\"></button>
								</form>
							</td>
						</tr>";
					};?>
				</table>
			</div>
		</div>
	</section>
	<script>
		window.onload = function() {
			// Bill Chart
			var chart = new CanvasJS.Chart("YTD_graph", {
				theme: "light2",
				animationEnabled: true,
				title: {
					text: "Payment YTD Graph"
				},
				data: [{
					type: "doughnut",
					yValueFormatString: "#,##0.00",
					indexLabel: "{label} ({y})",
					dataPoints: <?php echo json_encode($YTD_data, JSON_NUMERIC_CHECK); ?>
				}]
			});
			chart.render();
		}
	</script>
<?PHP
};
include("includes/footer.php");
?>