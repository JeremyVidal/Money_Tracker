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
		<style> 

		/* DeletePayConfirm */
			#pay_delete {width: 40%; margin: 200px auto 0 auto; padding: 10px;}	
			#pay_deleteimg{width: 30px;}
			.pay_delete_img{width: 60px;}
		</style>
        <section id="pay_delete">
		<div class="card">
            <form id="payment_del_form" name="payment_delete" action="deletepayconfirm.php" method="POST">
				<input type="hidden" name="paydeleteID" value="<?PHP echo $paydeleteID; ?>">
				<input type="hidden" name="script_path" value="<?PHP echo $script_path; ?>">
				<div class="card-header d-flex justify-content-between">
					<h5><img id="pay_deleteimg" src="media/delete.ico">&nbsp;&nbsp;Delete record?</h5>
					<div class="d-flex">
						<p><?PHP echo $data['paymentName']; ?></p>       
						<img class="pay_delete_img" src="media/<?PHP echo $data['paymentType']; ?>.png">
					</div>
				</div>
				<div class="card-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="deletepaydate">Date</label>
							<input type="date" id="deletepaydate" class="form-control" value="<?PHP echo $data['paymentDate']; ?>" disabled>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="deletepaytime">Time</label>
							<input type="time" id="deletepaytime" class="form-control" value="<?PHP echo $data['paymentTime']; ?>" disabled>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="deletepayamount">Amount</label>
							<input type="number" id="deletepayamount" class="form-control" value="<?PHP echo $data['paymentPaidAmount']; ?>" disabled>
					
						</div>
					</div>
				</div>
				<div class="card-footer d-flex justify-content-between align-items-center">
					<input type="submit" class="btn" name="paydeletesubmit" value="Delete Payment">
					<a href="<?PHP echo $script_path; ?>" class="btn"  id="deletecancel">Cancel</a>
				</div>
            </form>
        </section>
        <?PHP
        }
	};
	include("includes/footer.php");
	?>

