<?PHP
include("includes/header.php");
$current_user =  $_SESSION['userID'];
// this creates a transaction taht will be displayed along with any account payments
if (isset($_POST['ledgersubmit'])){
    // print_r($_POST);
    $ledgerdate = $_POST['ledgerdate'];
    $ledgertime = $_POST['ledgertime'];
    $ledgercategory = "Living";
    $ledgertype = $_POST['ledgertype'];
    $ledgername = $_POST['ledgername'];
    $ledgernote = $_POST['ledgernote'];
    $ledgeramount = $_POST['ledgeramount'];

    $ledgerpaidtype = $_POST['ledgerpaidtype'];
    $accountID = NULL;
    
    $addLedger = "INSERT INTO `payment` (`paymentID`, `paymentDate` , `paymentTime` , `paymentCategory`, `paymentType`, `paymentName`, `paymentDescription`, `paymentPaidAmount`, `paidType`, `accountID`, `userID`)
    VALUES (NULL, '$ledgerdate', '$ledgertime', '$ledgercategory', '$ledgertype', '$ledgername', '$ledgernote', '$ledgeramount', '$ledgerpaidtype',  NULL, '$current_user' )"; 
    $conn->query($addLedger);
    ?><script type="text/javascript">location.href='ledger.php';</script><?PHP
}
else{
    display_form();
}
function display_form(){
    require('includes/db_conn.php');
    $current_user =  $_SESSION['userID'];
    global $CURRENT_DATE;

    //category_graph
    $results = $conn->query("SELECT sum(`paymentPaidAmount`) as YTD, paymentType FROM payment WHERE YEAR(`paymentDate`) = YEAR(CURRENT_DATE()) AND `userID` = '$current_user' AND `paymentCategory` = 'Living' GROUP BY paymentType;");
    $YTD_data = array();
    while($data = $results->fetch()){
        $paymentType = $data['paymentType'];
        $paymentPaidAmount = $data['YTD'];
        $YTD_data[] = array("label"=>$paymentType, "y"=>$paymentPaidAmount);
    }
    ?>
		<section id="ledger_top"> 
            <div id="ledger_graph"></div>
            <h3>Add Transaction (<span style="color: red; font-size: 12px;">*</span> <span style="font-size: 12px;">required</span>)</h3>
            <form id="ledger_form" name="ledger_add" action="ledger.php" method="POST">
                    <input type="hidden" name="paymentcategory" value="Living">
                    <table>
                        <tr>
                            <td>Date <span style="color: red;">*</span></td><td><input type="date" name="ledgerdate" value="<?PHP echo $CURRENT_DATE; ?>" required></td>
                            <td>Time <span style="color: red;">*</span></td><td><input type="time" name="ledgertime" required></td>
                            <td>Type <span style="color: red;">*</span></td>
                            <td><select id="ledgertype" name="ledgertype" required>
                                <option value=""></option>
                                <option value="Children">Children</option>
                                <option value="Cigarettes">Cigarettes</option>
                                <option value="Food">Food</option>
                                <option value="Gas(car)">Gas(car)</option>
                                <option value="Hair Cuts">Hair Cuts</option>
                                <option value="House Supplies">House Supplies</option>
                                <option value="Medical Supplies">Medical Supplies</option>
                                <option value="Misc">Misc</option>
                                <option value="Savings">Savings</option>
                                <option value="Special Events">Special Events</option>
                                <option value="Vehicle">Vehicle</option>
                                <option value="Yearly">Yearly</option>
                            </select>
                            </td>
                        </tr>


                        <tr>
                            <td>Name <span style="color: red;">*</span></td><td><input type="text" name="ledgername" value="" required></td>
                            <td>Amount <span style="color: red;">*</span></td><td><input type="number" name="ledgeramount" size="5" min="0.00" step="0.01" required></td>
                            <td>Paid Type <span style="color: red;">*</span></td>
                            <td><select id="ledgerpaidtype" name="ledgerpaidtype" required>
                                <option value=""></option>
                                <option value="Cash">Cash</option>
                                <option value="Card" selected>Card</option>
                                <option value="Check">Check</option>
                                <option value="Online">Online</option>
                                <option value="Auto Pay">Auto Pay</option>
                                <option value="In Person">In Person</option>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Description</td>
                                <td colspan="5"><textarea id="ledger_textarea" name="ledgernote" rows="2" cols="50" max-length="200" value=""></textarea></td>
                        </tr>

                        <tr><td colspan="6"><input type="submit" name="ledgersubmit" value="Add Transaction"></td></tr>

                </table>
            </form>
        </section>

        <section id="ledger_bottom">
            <div id="ledger_YTD_graph"></div>
            <h3>Transaction Activity (MTD)</h3>
            <table id="ledger_activity_table">
                <tr><th></th><th>Date</th><th>Time</th><th>Category</th><th>Type</th><th>Name</th><th>Description</th><th>Amount</th><th>Paid Type</th><th></th><th></th></tr>
                <?PHP
                    $results = $conn->query("SELECT * FROM `payment` WHERE MONTH(paymentDate) = MONTH(CURRENT_DATE()) AND `userID` = '$current_user' ORDER BY paymentDate DESC;");
                    while($data = $results->fetch()){
                        $paymentID = $data['paymentID'];
                        $paymentDate = $data['paymentDate'];
                        $paymentTime = date("h:i A", strtotime($data['paymentTime']));;
                        $paymentCategory = $data['paymentCategory'];
                        $paymentType = $data['paymentType'];
                        $paymentName = $data['paymentName'];
                        $paymentPaidAmount = $data['paymentPaidAmount'];
                        $paymentDescription = $data['paymentDescription'];
                        $paidType = $data['paidType'];
                        echo "<tr><td><img src=\"media/$paymentType.png\"></td><td>$paymentDate</td><td>$paymentTime</td><td>$paymentCategory</td><td>$paymentType</td><td>$paymentName</td><td>$paymentDescription</td><td>$$paymentPaidAmount</td><td>$paidType</td>
                        <td>
                            <form id=\"ledger_edit\" name=\"ledger_edit\" action=\"editpayment.php\" method=\"POST\">
                                <input type=\"hidden\" name=\"ledgereditID\" value=\"$paymentID\">
                                <button><img src=\"media/edit.ico\"></button>
                            </form>
                        </td>
                        <td>
                            <form id=\"ledger_delete\" name=\"ledger_delete\" action=\"deletepayconfirm.php\"  method=\"POST\">
                                <input type=\"hidden\" name=\"ledgerdeleteID\" value=\"$paymentID\">
                                <button><img src=\"media/delete.ico\"></button>
                            </form>
                        </td>
                        ";
                    };?>
            </table>
        </section>
        <script>
        window.onload = function() {
            // Section Chart
            var chart = new CanvasJS.Chart("ledger_graph", {
                theme: "light2",
                // colorSet: "greenShades",
                animationEnabled: true,
                title: {
                    text: "Living Type YTD"
                },
                data: [{
                    type: "pie",
                    yValueFormatString: "$#,##0.00",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($YTD_data, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
<?PHP
}
include("includes/footer.php");
?>