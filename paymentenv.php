<?
session_start();
require('includes/db_conn.php');
	// this is a script to print out an envelope with the address to go along with paymentdoc.php for an account payment
    $payenvelopeID = $_SESSION['payenvelopeID'];
    $query = "SELECT accountName, accountStreet, accountStreet2, accountCity, accountState, accountZip
    FROM account
    WHERE accountID = $payenvelopeID";

    $results = $conn->query($query);

    while($data = $results->fetch()){
        $accountName = $data['accountName'];
        $accountNumber = $data['accountNumber'];
        $accountStreet = $data['accountStreet'];
        $accountStreet2 = $data['accountStreet2'];
        $accountCity = $data['accountCity'];
        $accountState = $data['accountState'];
        $accountZip = $data['accountZip'];
    }
?>
<style>
    #envelope {width: 900px; height: 300px;  margin: 0 auto; padding: 10px;}
    #envelope_table {margin: 65px auto 0 auto;}
</style>
<section id="envelope">
<section id="return_address">
    <table id="return_table">
        <tr><td>Jeremy Vidal</td></tr>
        <tr><td>6008 Moller Rd Lot 92</td></tr>
        <tr><td>Fort Wayne, In 46806</td></tr>
    </table>   
    <table id="envelope_table">
        <tr><td>Attn: Billing</td></tr>
        <tr><td><? echo $accountName;?></td></tr>
        <tr><td><? echo $accountStreet;?></td></tr>
        <?
        if ($accountStreet2 != ""){?>
        <tr><td><? echo $accountStreet2;?></td></tr>
        <?
        }
        ?>
        <tr><td><? echo $accountCity . " " . $accountState . ", " . $accountZip;?></td></tr>
    </table>
</section>