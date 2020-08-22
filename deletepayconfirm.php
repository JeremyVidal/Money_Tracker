<?PHP
	include("includes/header.php");
	// this deletes a contact then redirects to to either payments.php or ledger.php
    if(isset($_POST['paydeletesubmit'])){
        require('includes/db_conn.php');
        $deleteID = $_POST['paydeleteID'];
        $script_path = $_POST['script_path'];
        $deletePayment = "DELETE FROM `payment` WHERE paymentID = '$deleteID'";
        $conn->query($deletePayment);
        ?><script type="text/javascript">location.href='<? echo $script_path;?>';</script><?PHP // $script_path is used in display_form()
    }
    else{
        display_form();
    }
    function display_form(){
		require('includes/db_conn.php');
		// this form is used to delete a transaction from both payments.php and ledger.php
        if (isset($_POST['paydeleteID'])){
            $paydeleteID = $_POST['paydeleteID'];
            $script_path = "payments.php";
        }
        else if(isset($_POST['ledgerdeleteID'])){
            $paydeleteID = $_POST['ledgerdeleteID'];
            $script_path = "ledger.php";
        }
        $results = $conn->query("SELECT * FROM `payment` WHERE `paymentID` = '$paydeleteID';");
        while($data = $results->fetch()){
        ?>
        <section id="payment_delete">
            <div id="payment_delete_image"><img src="media/companies/<? echo $data['paymentName']?>.png"></div>
            <div id="payment_delete_type"><? echo $data['paymentName']?></div><br>       
            <h3><img id="deleteimg" src="media/delete.ico">&nbsp;&nbsp;Delete record?</h3>
            <form id="payment_del_form" name="payment_delete" action="deletepayconfirm.php" method="POST">
                <input type="hidden" name="paydeleteID" value="<? echo $paydeleteID?>">
                <input type="hidden" name="script_path" value="<? echo $script_path?>">
                <table>
                    <tr>
                        <td>Date</td><td><input type="date" value="<? echo $data['paymentDate']?>" disabled="disabled"></td>
                        <td>Time</td><td><input type="time" value="<? echo $data['paymentTime']?>" disabled="disabled"></td>
                    </tr>
                    <tr>
                    <td>Amount</td><td><input type="number" size="10" value="<? echo $data['paymentPaidAmount']?>" disabled="disabled"></td>
                    </tr>
                    <tr><td colspan="4"><input type="submit" name="paydeletesubmit" value="Delete Payment"></td></tr>
                </table>
                <a href="<? echo $script_path?>" class="button_green"  id="deletecancel">Cancel</a>
            </form>
        </section>
        <?
        }
    };
    ?>
