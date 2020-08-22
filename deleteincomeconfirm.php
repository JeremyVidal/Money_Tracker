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
        <section id="income_delete">
            <div id="income_delete_image"><img src="media/Income.png"></div>
            <div id="income_delete_type"><? echo $data['incomeSource']?></div><br>       
            <h3><img id="income_deleteimg" src="media/delete.ico">&nbsp;&nbsp;Delete INCOME?</h3>
            <form id="income_del_form" name="income_delete" action="deleteincomeconfirm.php" method="POST">
                <input type="hidden" name="incomedeleteID" value="<? echo $_SESSION['incomedeleteID']?>">
                <table>
                    <tr>
                        <td>Date</td><td colspan="3"><input type="date" name="deletedate" value="<? echo $data['incomeDate']?>" disabled="disabled"></td>
                    </tr>
                    <tr>
                        <td>Gross</td><td><input type="number" name="deletegross" value="<? echo $data['incomeGross']?>" disabled="disabled"></td>
                        <td>Net</td><td><input type="number" name="deletenet" value="<? echo $data['incomeNet']?>" disabled="disabled"></td>
                    </tr>
                    <tr><td colspan="4"><input type="submit" class="button_red" name="incomedeletesubmit" value="Delete Income"></td></tr>
                    
                </table>
                <a href="income.php" class="button_green"  id="income_delete_cancel">Cancel</a>
            </form>
        </section>
        <?
        }
    };
    ?>
