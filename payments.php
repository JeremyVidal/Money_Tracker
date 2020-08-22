<?
include("includes/header.php");
$current_user =  $_SESSION['userID'];
// this creates a payment transaction
if (isset($_POST['paymentsubmit'])){
    // print_r($_POST);
    $paiddate = $_POST['paiddate'];
    $paidtime = $_POST['paidtime'];
    $paymentcategory = $_POST['paymentcategory'];
    $paymenttype = $_POST['paymenttype'];
    $paymentname = $_POST['paymentname'];
    $paidamount = $_POST['paidamount'];
    $paidtype = $_POST['paidtype'];
    $accountID = $_POST['accountid'];
    
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
    display_form();
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
    <section id="payment_sidenav">
        <h2>Account Payment</h2>
		<?PHP 
			// this creates the sidebar selections
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
                    <form name=\"acct\" id=\"payment_side_links\" action=\"payments.php\" method=\"POST\">
                        <input type=\"hidden\" name=\"acctpayID\" value=\"$accountID\">
                        <input type=\"submit\" name = \"acctpaysubmit\" value=\"$accountName\" style=\"text-align: left;\">
                    </form>
                    </li>";
                };
                echo "</ul>";
            };
        ?>
    </section>
    <section id="payment_main">
        <?PHP
        $results = $conn->query("SELECT * FROM `account` WHERE `accountID` = '$current_payment_id' AND `userID` = '$current_user';");
        while($data = $results->fetch()){
        ?>
        <section id="payment_top">
            <section id="payment"> 
                <div id="payment_image"><img src="media/companies/<? echo $data['accountName']?>.png"></div>
                <div id="payment_type"><? echo $data['accountName']?></div>
                <table id="payment_account_table">
                <h3>Add Payment (<span style="color: red; font-size: 12px;">*</span> <span style="font-size: 12px;">required</span>)</h3>
                    <tr><th>Name</th><th>Phone</th></tr>
                    <tr><td style="width: 100px; max-width: 100px; "><? echo $data['accountName']?></td><td style="width: 50px; max-width: 50px; "><? echo $data['accountPhone']?></td></tr>
                    <tr><th>Payment</th><th>Due Date</th></tr>
                    <tr><td>$<? echo $data['accountPayment']?></td><td><? echo $data['accountDueDate']?></td></tr>
                </table>
                <form id="payment_form" name="payment_add" action="payments.php" method="POST">
                        <input type="hidden" name="paymentcategory" style="display: none;" value="<? echo $data['accountCategory']?>"><br>
                        <input type="hidden" name="paymenttype" style="display: none;" value="<? echo $data['accountType']?>">
                        <input type="hidden" name="paymentname" style="display: none;" value="<? echo $data['accountName']?>">
                        <input type="hidden" name="accountid" style="display: none;" value="<? echo $data['accountID']?>">
                        <table>
                            <tr>
                                <td>Date <span style="color: red;">*</span></td><td><input type="date" name="paiddate" value="<?php echo $CURRENT_DATE;?>" required></td>
                                <td>Time <span style="color: red;">*</span></td><td><input type="time" name="paidtime" required></td>
                            </tr>
                            <tr>
                                <td>Amount <span style="color: red;">*</span></td><td><input type="number" name="paidamount" size="10" min="0.00" step="0.01" required></td>
                                <td>Type <span style="color: red;">*</span></td>
                                <td><select id="paidtype" name="paidtype" required>
                                        <option value=""></option>
                                        <option value="Cash">Cash</option>
                                        <option value="Card">Card</option>
                                        <option value="Check">Check</option>
                                        <option value="Online">Online</option>
                                        <option value="Auto Pay">Auto Pay</option>
                                        <option value="In Person">In Person</option>
                                    </select>
                                </td>
                            </tr>
                            <tr><td colspan="4"><input type="submit" name="paymentsubmit" value="Add Payment"></td></tr>
                        </table>
                </form>
            </section>
        </section>
        <?PHP
        };
        ?>
        <section id="payment_bottom">
            <section id="payment_activity">
                <div id="YTD_graph"></div>
                <h3>Payment Activity (MTD)</h3>
                <table id="pay_activity_table">
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

                            echo "<tr><td><img src=\"media/companies/$paymentName.png\"></td><td>$paymentDate</td><td>$paymentName</td><td>$$paymentPaidAmount</td><td>$paidType</td>
                            <td>
                                <form id=\"payment_edit\" name=\"payment_edit\" action=\"editpayment.php\" method=\"POST\">
                                    <input type=\"hidden\" name=\"payeditID\" value=\"$paymentID\">
                                    <button><img src=\"media/edit.ico\"></button>
                                </form>
                            </td>
                            <td>
                                <form id=\"payment_delete\" name=\"payment_delete\" action=\"deletepayconfirm.php\" method=\"POST\">
                                    <input type=\"hidden\" name=\"paydeleteID\" value=\"$paymentID\">
                                    <button><img src=\"media/delete.ico\"></button>
                                </form>
                            </td>
                            <td>
                                <form id=\"payment_print\" name=\"payment_print\" action=\"payments.php\" method=\"POST\">
                                    <input type=\"hidden\" name=\"payprintID\" value=\"$paymentID\">
                                    <button onclick=\"windowOpen()\"><img src=\"media/print.png\"></button>
                                </form>                           
                            </td>
                            <td>
                                <form id=\"payment_envelope\" name=\"payment_envelope\" action=\"payments.php\" method=\"POST\">
                                    <input type=\"hidden\" name=\"payenvelopeID\" value=\"$accountID\">
                                    <button><img src=\"media/envelope.png\"></button>
                                </form>
                            </td>
                            </tr>";
                        };?>
                </table>
            </section>
        </section>
    </section>
    <script>
        window.onload = function() {
            // Bill Chart
            var chart = new CanvasJS.Chart("YTD_graph", {
                theme: "light2",
                animationEnabled: true,
                title: {
                    text: "Payment Breakdown YTD"
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
?>