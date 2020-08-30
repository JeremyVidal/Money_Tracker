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
        <section id="contact_delete">
            <div id="contact_delete_image"><img src="media/companies/<?PHP echo $data['contactName']; ?>.png"></div>
            <div id="contact_delete_type"><?PHP echo $data['contactName']; ?></div><br>       
            <h3><img id="contact_deleteimg" src="media/delete.ico">&nbsp;&nbsp;Delete RECORD?</h3>
            <form id="contact_del_form" name="contact_delete" action="deletecontactconfirm.php" method="POST">
                <input type="hidden" name="contactdeleteID" value="<?PHP echo $_SESSION['contactdeleteID']; ?>">
                <table>
                    <tr>
                        <td>Type</td><td><input type="text" name="deletetype" value="<?PHP echo $data['contactType']; ?>" disabled="disabled"></td>
                        <td>Result</td><td><input type="text" name="deleteresults" value="<?PHP echo $data['contactResults']; ?>" disabled="disabled"></td>
                    </tr>
                    <tr>
                        <td>Date</td><td><input type="date" name="deletedate" value="<?PHP echo $data['contactDate']; ?>" disabled="disabled"></td>
                        <td>Time</td><td><input type="time" name="deletetime" value="<?PHP echo $data['contactTime']; ?>" disabled="disabled"></td>
                    </tr>
                    <tr>
                        <td for="deletenotes">Notes</td>
                        <td colspan="3"><textarea id="deletenotes" name="deletenotes" rows="4" cols="50" disabled="disabled"><?PHP echo $data['contactNotes']; ?></textarea></td>
                    </tr>
                    <tr><td colspan="4"><input type="submit" name="contactdeletesubmit" value="Delete Payment"></td></tr>
                </table>
                <a href="contact.php"  id="contact_delete_cancel">Cancel</a>
            </form>
        </section>
        <?PHP
        }
    };
	include("includes/footer.php");
    ?>
