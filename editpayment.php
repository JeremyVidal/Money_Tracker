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
            <section id="payment_edit">
                <div id="payment_edit_image"><img src="media/<? echo $data['paymentType']?>.png"></div>
                <div id="payment_edit_type"><? echo $data['paymentName']?></div><br>
                <h3><img id="editimg" src="media/update.png">&nbsp;&nbsp;Update RECORD?</h3>
                <form id="payment_edit_form" name="payment_update" action="editpayment.php" method="POST">
                    <input type="hidden" name="updateID" value="<? echo $data['paymentID']?>">
                    <input type="hidden" name="script_path" value="<? echo $script_path?>">
                    <table>
                        <tr>
                            <td>Date</td><td><input type="date" name="editdate" value="<? echo $data['paymentDate']?>"></td>
                            <td>Time</td><td><input type="time" name="edittime" value="<? echo $data['paymentTime']?>"></td>
                        </tr>
                        <tr>
                        <td>Description</td>
                            <td colspan="3"><textarea id="editnotes" name="editnotes" rows="2" cols="40" max-length="200" value=""><? echo $data['paymentDescription']?></textarea></td>
                        </tr>
                        <tr>
                            <td>Amount</td><td><input type="number" name="editamount" size="10" min="0.00" step="0.01" value="<? echo $data['paymentPaidAmount'] ?>"></td>
                            <td>Type</td>
                            <td><select id="edittype" name="edittype">
                                    <option value="Cash" <? if ($paidtype == "") {echo "selected";};?>></option>
                                    <option value="Cash" <? if ($paidtype == "Cash") {echo "selected";};?>>Cash</option>
                                    <option value="Card" <? if ($paidtype == "Card") {echo "selected";};?>>Card</option>
                                    <option value="Check" <? if ($paidtype == "Check") {echo "selected";};?>>Check</option>
                                    <option value="Online" <? if ($paidtype == "Online") {echo "selected";};?>>Online</option>
                                    <option value="Auto Pay" <? if ($paidtype == "Auto Pay") {echo "selected";};?>>Auto Pay</option>
                                    <option value="In Person" <? if ($paidtype == "In Person") {echo "selected";};?>>In Person</option>
                                </select>
                            </td>
                        </tr>
                        <tr><td colspan="4"><input type="submit" name="updatesubmit" value="Update Payment"></td></tr>
                    </table>
                    <a href="<? echo $script_path?>" id="updatecancel">Cancel</a>
                </form>
            </section>
            <?PHP
            }
    }
    ?>