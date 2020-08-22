<?PHP
	include("includes/header.php");
	// this updates a contact then redirects to income.php
    if(isset($_POST['incomeupdatesubmit'])){
        require('includes/db_conn.php');
        // print_r($_POST);
        $incomeupdateID = $_POST['incomeupdateID'];
        $incomeeditsource = $_POST['incomeeditsource'];
        $incomeupdatedate = $_POST['incomeupdatedate'];
        $incomeupdategross = $_POST['incomeupdategross'];
        $incomeupdatenet = $_POST['incomeupdatenet'];
        $incomeupdatenotes = $_POST['incomeupdatenotes'];
        
        $updateIncome = "UPDATE `income` 
            SET
                `incomeSource` = '$incomeeditsource',
                `incomeDate` = '$incomeupdatedate',
                `incomeGross` = '$incomeupdategross',
                `incomeNet` = '$incomeupdatenet',
                `incomeNote` = '$incomeupdatenotes'
            WHERE `incomeID` = '$incomeupdateID';
        ";
        $conn->query($updateIncome);
        ?><script type="text/javascript">location.href='income.php';</script><?PHP
    }
    else{
        display_form();
    }
    function display_form(){
            require('includes/db_conn.php');
            $incomeeditID = $_SESSION['incomeeditID'];
            $results = $conn->query("SELECT * FROM `income` WHERE `incomeID` = '$incomeeditID';");
            while($data = $results->fetch()){
            $updatesource = $data['incomeSource'];

            ?>
            <section id="income_edit">
                <div id="income_edit_image"><img src="media/Income.png"></div>
                <div id="income_edit_name"><? echo $data['incomeSource']?></div><br>
                <h3><img id="income_editimg" src="media/update.png">&nbsp;&nbsp;Update INCOME?</h3>
                <form id="income_edit_form" name="income_edit_form" action="editincome.php" method="POST">
                    <input type="hidden" name="incomeupdateID" value="<? echo $data['incomeID']?>">
                    <table>
                        <tr>
                            <td>Source</td><td><input type="text" id="incomeeditsource" name="incomeeditsource" value="<?php echo $data['incomeSource']?>"></td>
                            <td>Date</td><td><input type="date" name="incomeupdatedate" size='35' value="<?php echo $data['incomeDate']?>"></td>
                        </tr>
                        <tr>
                            <td>Gross Pay</td><td><input type="number" name="incomeupdategross" min="0.00" step="0.01" size='5' value="<?php echo $data['incomeGross']?>"></td>
                            <td>Net Pay</td><td><input type="number" name="incomeupdatenet" min="0.00" step="0.01" size='5' value="<?php echo $data['incomeNet']?>"></td>
                        </tr>
                        <tr>
                            <td>Notes</td>
                            <td colspan="3"><textarea id="incomeupdatenotes" name="incomeupdatenotes" rows="4" cols="50" value=""><?php echo $data['incomeNote']?></textarea></td>
                        </tr>
                        <tr><td colspan="4"><input type="submit" value="Update Income" name="incomeupdatesubmit"></td></tr>
                    </table>
                    <a href="income.php" id="incomeupdatecancel">Cancel</a>
                </form>
            </section>
            <?PHP
            }
    }
    ?>