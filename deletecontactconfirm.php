<?PHP
	include("includes/header.php");
	// this deletes the contact and redirects back to the contact.php
    if(isset($_POST['contactdeletesubmit'])){
        require('includes/db_conn.php');
        $deleteID = $_POST['contactdeleteID'];
        $deleteContact = "DELETE FROM `contact` WHERE `contactID` = '$deleteID'";
        $conn->query($deleteContact);
        ?><script type="text/javascript">location.href='contact.php';</script><?PHP
    }
    else{
        display_form();
    }
    function display_form(){
        require('includes/db_conn.php');
        $contactdeleteID = $_SESSION['contactdeleteID'];
        $results = $conn->query("SELECT * FROM `contact` WHERE `contactID` = '$contactdeleteID';");
        while($data = $results->fetch()){
		?>
		<style> 
		/* DeleteContactConfirm */
		#contact_delete {width: 40%; margin: 200px auto 0 auto; padding: 10px;}	
		#contact_deleteimg{width: 30px;}
		.contact_delete_img{width: 60px;}
		</style>
        <section id="contact_delete">
		<div class="card">
            <form class="form" name="contact_delete" action="deletecontactconfirm.php" method="POST">
				<input type="hidden" name="contactdeleteID" value="<?PHP echo $_SESSION['contactdeleteID']; ?>">
				<div class="card-header d-flex justify-content-between">
					<h5><img id="contact_deleteimg" src="media/delete.ico">&nbsp;&nbsp;Delete RECORD?</h5>
					<div class="d-flex">
						<img class="contact_delete_img" src="media/companies/<?PHP echo $data['contactName']; ?>.png">
						<p><?PHP echo $data['contactName']; ?></p>     
					</div>
				</div>
				<div class="card-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="deletetype">Type</label>
							<input type="text" id="deletetype" name="deletetype" class="form-control" value="<?PHP echo $data['contactType']; ?>" disabled>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="deleteresults">Result</label>
							<input type="text" id="deleteresults" name="deleteresults" class="form-control" value="<?PHP echo $data['contactResults']; ?>" disabled>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
							<label for="deletedate">Date</label>
							<input type="date" id="deletedate" name="deletedate" class="form-control" value="<?PHP echo $data['contactDate']; ?>" disabled>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="form-group">
							<label for="deletetime">Time</label>
							<input type="time" id="deletetime" name="deletetime" class="form-control" value="<?PHP echo $data['contactTime']; ?>" disabled>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<label for="deletenotes">Notes</label>
						<textarea id="deletenotes" name="deletenotes" class="form-control" rows="4" cols="40" disabled><?PHP echo $data['contactNotes']; ?></textarea>
					</div>
				</div>
				<div class="card-footer d-flex justify-content-between align-items-center">
					<input type="submit" class="btn" name="contactdeletesubmit" value="Delete Payment">
					<a href="contact.php"  id="contact_delete_cancel">Cancel</a>
				</div>       
            </form>
        </section>
        <?PHP
        }
    };
	include("includes/footer.php");
    ?>
