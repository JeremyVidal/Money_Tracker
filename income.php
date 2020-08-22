<?php
include("includes/header.php");
$current_user =  $_SESSION['userID'];
//income_graph
$results = $conn->query("SELECT sum(`incomeGross`) as Gross, sum(`incomeNet`) as Net FROM income WHERE YEAR(`incomeDate`) = YEAR(CURRENT_DATE()) AND `userID` = '$current_user';");
$income_data = array();
while($data = $results->fetch()){
    $incomeGross = $data['Gross'];
    $incomeNet = $data['Net'];
    $incomeTaxes = $incomeGross - $incomeNet;
    $income_data[] = array("label"=>"Gross", "y"=>$incomeGross);
    $income_data[] = array("label"=>"Net", "y"=>$incomeNet);
    $income_data[] = array("label"=>"Taxes", "y"=>$incomeTaxes);
}
if(isset($_POST['incomesubmit'])){
    // print_r($_POST);
    $incomesource = $_POST['incomesource'];
    $incomedate = $_POST['incomedate'];
    $incomegross = $_POST['incomegross'];
    $incomenet = $_POST['incomenet'];
    $incomenote = $_POST['incomenote'];

    $addIncome = "INSERT INTO `income` (`incomeID`, `incomeSource`, `incomeDate`, `incomeGross`, `incomeNet`, `incomeNote`, `userID`)
    VALUES (NULL, '$incomesource', '$incomedate', '$incomegross', '$incomenet', '$incomenote', '$current_user')";
    $conn->query($addIncome);
    ?><script type="text/javascript">location.href='income.php';</script><?PHP
}
else if(isset($_POST['incomedeleteID'])){
    $_SESSION['incomedeleteID'] = $_POST['incomedeleteID'];
    ?><script type="text/javascript">location.href='deleteincomeconfirm.php';</script><?PHP
}
else if(isset($_POST['incomeeditID'])){
    $_SESSION['incomeeditID'] = $_POST['incomeeditID'];
    ?><script type="text/javascript">location.href='editincome.php';</script><?PHP
}
else{
    display_form();
}

function display_form(){
    require('includes/db_conn.php');
    $current_user =  $_SESSION['userID'];
    global $CURRENT_DATE;
    ?>
        <section id="income_add">
            <div id="income_graph"></div>
            <h3>Add Income (<span style="color: red; font-size: 12px;">*</span> <span style="font-size: 12px;">required</span>)</h3><br>
            <form id="income_form" name="income_form" action="income.php" method="POST">
                <table>
                    <tr>
                        <td>Source <span style="color: red;">*</span></td>
                        <td>
                            <input list="source" id="incomesource" name="incomesource" required>
                            <datalist id="source">
                                <?PHP 
                                    $result = $conn->query("SELECT DISTINCT `incomeSource` FROM `income`;");
                                    while($record = $result->fetch()){
                                        $incomeSource = $record['incomeSource'];
                                        echo "<option value=\"$incomeSource\">";
                                    };
                                    ?>
                            </datalist>
                        </td>          
                          <td>Date <span style="color: red;">*</span></td> 
                          <td><input type="date" name="incomedate" size='35' value="<?php echo $CURRENT_DATE;?>" required></td>  
                    </tr>    
                    <tr>   
                    <td>Gross Pay <span style="color: red;">*</span></td><td><input type="number" name="incomegross" min="0.00" step="0.01" size='5' required></td>
                    <td>Net Pay <span style="color: red;">*</span></td><td><input type="number" name="incomenet" min="0.00" step="0.01" size='5' required></td>
                    </tr>
                    <tr>
                        <td>Notes</td>
                        <td colspan="3"><textarea id="income_notes" name="incomenotes" rows="2" cols="50" value="" max-length="200" ></textarea></td>
                    </tr>
                    <tr><td colspan="4"><input type="submit" value="Add Income" name="incomesubmit"></td></tr>
                </table>
            </form>
        </section>
            <section id="income_activity">
                <table id="income_activity_table">
                    <h3>Income Activity (YTD)</h3>
                <tr><th></th><th>Company</th><th>Date</th><th>Gross</th><th>Net</th><th>Taxes</th><th></th><th></th></tr>
                <?PHP
                    $results = $conn->query("SELECT * FROM `income` WHERE YEAR(incomeDate) = YEAR(CURRENT_DATE()) AND `userID` = '$current_user' ORDER BY incomeDate DESC;");
                    while($data = $results->fetch()){
                        $incomeID = $data['incomeID'];
                        $incomeSource = $data['incomeSource'];
                        $incomeDate = $data['incomeDate'];
                        $incomeGross = $data['incomeGross'];
                        $incomeNet = $data['incomeNet'];
                        $incomeTaxes = $incomeGross - $incomeNet;
                        echo "<tr><td><img src=\"media/income.png\"></td><td>$incomeSource</td><td>$incomeDate</td><td>$$incomeGross</td><td>$$incomeNet</td><td>$$incomeTaxes</td>
                            <td>
                            <form id=\"income_edit\" name=\"income_edit\" method=\"POST\">
                                <input type=\"hidden\" name=\"incomeeditID\" value=\"$incomeID\">
                                <button><img src=\"media/edit.ico\"></button>
                            </form>
                            </td>
                            <td>
                            <form id=\"income_delete\" name=\"income_delete\" method=\"POST\">
                                <input type=\"hidden\" name=\"incomedeleteID\" value=\"$incomeID\">
                                <button><img src=\"media/delete.ico\"></button>
                            </form>
                            </td>
                        <tr>";
                    };?>
            </table>
        </section>
    </section>
<?
};
?>
<script>
    window.onload = function() {    
        // Incoming Chart
            var chart = new CanvasJS.Chart("income_graph", {
                theme: "light2",
                // colorSet: "greenShades",
                animationEnabled: true,
                title: {
                    text: "Income (YTD)"
                },
                data: [{
                    type: "funnel",
                    yValueFormatString: "$#,##0.00",
                    indexLabel: "{label} ({y})",
                    dataPoints: <?php echo json_encode($income_data, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
    }
</script>