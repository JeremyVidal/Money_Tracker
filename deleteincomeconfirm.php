<?PHP
	include("includes/header.php");
	// this deletes the contact and redirects back to the income.php
    if(isset($_POST['incomedeletesubmit'])){
        require('includes/db_conn.php');
        $deleteID = $_POST['incomedeleteID'];
        $deleteIncome = "DELETE FROM `income` WHERE incomeID = '$deleteID'";
        $conn->query($deleteIncome);
        ?><script type="text/javascript">location.href='income.php';</script><?PHP
    }
    else{
        display_form();
    }
    function display_form(){
        require('includes/db_conn.php');
        $incomedeleteID = $_SESSION['incomedeleteID'];
        $results = $conn->query("SELECT * FROM `income` WHERE `incomeID` = '$incomedeleteID';");
        while($data = $results->fetch()){
		?>
		<style>
			#income_delete {width: 40%; margin: 200px auto 0 auto; padding: 10px;}	
			#income_deleteimg{width: 30px;}
			.income_delete_img{width: 60px;}
		</style>
        <section id="income_delete">
		<div class="card">
            <form class="form" id="income_del_form" name="income_delete" action="deleteincomeconfirm.php" method="POST">
				<input type="hidden" name="incomedeleteID" value="<?PHP echo $_SESSION['incomedeleteID']; ?>">
				<div class="card-header d-flex justify-content-between">
					<h5><img id="income_deleteimg" src="media/delete.ico">&nbsp;&nbsp;Delete INCOME?</h5>
					<div class="d-flex">
						<img class="income_delete_img" src="media/Income.png">
						<p><?PHP echo $data['incomeSource']; ?></p>      
					</div>
				</div>
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="deletedate">Date</label>
								<input type="date" id="deletedate" class="form-control" name="deletedate" value="<?PHP echo $data['incomeDate']; ?>" disabled>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="deletegross">Gross</label>
								<input type="number" id="deletegross" class="form-control" name="deletegross" value="<?PHP echo $data['incomeGross']; ?>" disabled>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="deletenet">Net</label>
								<input type="number" id="deletenet" class="form-control" name="deletenet" value="<?PHP echo $data['incomeNet']; ?>" disabled>		
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer d-flex justify-content-between align-items-center">
						<input type="submit" class="btn" name="incomedeletesubmit" value="Delete Income">
						<a href="income.php" class="btn"  id="income_delete_cancel">Cancel</a>
				</div>
            </form>
        </section>
        <?PHP
        }
	};
	include("includes/footer.php");
    ?>
