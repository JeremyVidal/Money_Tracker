<?php
$username = 'root';
$password = 'Msql4jbv191';
$host = 'mysql:dbname=mymoney;host=127.0.0.1';

#connect to the database or die
$conn = new PDO($host, $username, $password);
if (!$conn) {
  die('Could not connect!');
}
// else{
//     echo "Connection Successful!" . "\n";
// }






?>