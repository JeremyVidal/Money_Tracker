<?
session_start();
require('includes/db_conn.php');
	// this is a report created to send along with a payment for a collection account
    $payprintID = $_SESSION['payprintID'];
    $query = "SELECT paymentDate, paymentPaidAmount, accountName, accountNumber,accountStreet,accountStreet2,accountCity,accountState,accountZip,accountPhone
    FROM payment
    INNER JOIN account ON payment.accountID = account.accountID
    WHERE paymentID = $payprintID";

    $results = $conn->query($query);

    while($data = $results->fetch()){
        $paymentDate = $data['paymentDate'];
        $paymentPaidAmount = $data['paymentPaidAmount'];
        $accountName = $data['accountName'];
        $accountNumber = $data['accountNumber'];
        $accountStreet = $data['accountStreet'];
        $accountStreet2 = $data['accountStreet2'];
        $accountCity = $data['accountCity'];
        $accountState = $data['accountState'];
        $accountZip = $data['accountZip'];
        $accountPhone = $data['accountPhone'];
    }
?>
<style>
    #print_page {width: 600px; margin: 50px auto 0 auto;}
    #print_header {width: 99.9%; height: 260px;}
    #print_title {width: auto; color: white; background-color: gray; padding: 25px; font-size: 1.5em;}
    #print_account_table{float: left; width: 65%; font-size: 1em; text-align: left;}
    #print_from_table {float: right; width: 35%; font-size: 1em; text-align: left;}
    #print_body {border-top: 1px solid blue; width: auto; height: 350px; padding: 10px; font-size: 1em;}
    #print_date {width: 100%; text-decoration: underline;}
    #print_footer {border-top: 1px solid blue; width: auto; height: 130px; padding: 20px; font-size: 1em;}
    #signature {width: 200px;}
</style>
<section id="print_page">
    <section id="print_header">
        <div id="print_title">Payment Letter</div>
            <table id="print_account_table">
                <tr><th>To:</th></tr>
                <tr><td>Attn: Billing Department</td></tr>
                <tr><td><? echo $accountName;?></td></tr>
                <tr><td><? echo $accountStreet;?></td></tr>
                <?
                if ($accountStreet2 != ""){?>
                <tr><td><? echo $accountStreet2;?></td></tr>
                <?
                }
                ?>
                <tr><td><? echo $accountCity . " " . $accountState . ", " . $accountZip;?></td></tr>
                <tr><td><? echo $accountPhone;?></td></tr>
            </table>
            <table id="print_from_table">
                <tr><th>From:</th></tr>
                <tr><td>Jeremy Vidal</td></tr>
                <tr><td>6008 Moeller Rd</td></tr>
                <tr><td>Fort Wayne, IN 46806</td></tr>
                <tr><td>Account Number:</td></tr>
                <tr><td><? echo "#".$accountNumber;?></td></tr>
            </table>
    </section>
    <section id="print_body">
        <div id="print_date">Date: <? echo $paymentDate;?></div>
        <br><br>
        <p>
            This letter is in reference to Account Number <span style="text-decoration: underline;"><? echo $accountNumber;?></span> for the amount of <? echo "$".$paymentPaidAmount;?>.
        </p>
        <p style="text-indent: 50px;">
            I am trying to pay off this debt the best I can at the moment. I cannot make a payment arrangement because I do not know 
            how much I will be able to pay every time. I hope you see this as an attmept to make good on the debt owed.
        </p>
    </section>
    <section id="print_footer">
        <p>Thank you,</p>
        <p>Jeremy Vidal</p>
        <img id="signature" src="media/Signature.png">
    </section>
</section>