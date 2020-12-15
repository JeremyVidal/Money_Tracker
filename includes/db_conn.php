<?PHP
#connect to the local database
// $username = 'root';
// $password = 'Msql4jbv191';
// $host = 'mysql:dbname=mymoney;host=127.0.0.1';
// $conn = new PDO($host, $username, $password);
// if (!$conn) {
//   die('Could not connect!');
// }

#connect to the infinityFree database
$username = 'epiz_26771060';
$password = 'D2UxU2fUQlgiOPz';
$host = 'sql202.epizy.com';
$dbname = 'epiz_26771060_money_tracker_db';
$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
if (!$conn) {
  die('Could not connect!');
}

?>