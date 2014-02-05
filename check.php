<?php

require_once(dirname(__FILE__).'/sci/config.php');
require_once(dirname(__FILE__).'/lib/common.lib.php');

$btc=rawurldecode($_POST['sendbtc']);
$buyer=rawurldecode($_POST['buyer']);
$seller=rawurldecode($_POST['seller']);
$wid=rawurldecode($_POST['wid']);
$vpin=rawurldecode($_POST['vpin']);
$pin=rawurldecode($_POST['pin']);



echo "<h1>Review your order</h1>";
//echo $btc." ".$buyer." ".$seller." ".$wid." ".$vpin;

//send data to mysql

  //MYSQL CONNECT
  $con = mysql_connect($mysvr,$myusr,$mypass);

  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysql_select_db($mydb) or die(mysql_error('Could not select daatabase'));

$result = mysql_query("SELECT * FROM payment WHERE pubadd='".$wid."' AND seller='".$seller."' AND buyer='".$buyer."' AND price='".$btc."' AND verifypin='".$vpin."' ");

while($row = mysql_fetch_array($result))
  {
    echo "Buyer: ".$row['buyer'];
  echo "<br />";
  echo "Seller: ".$row['seller'];
  echo "<br />";
  echo "Item: ".$row['item'];
  echo "<br />";
  echo "Wallet ID: ".$row['pubadd'];
  echo "<br/>";
  echo "Transaction Date: ".$row['start'];
  echo "<br/>";
  echo "Available: ".$row['inhand'];
  echo "<br/>";
  echo "Released: ".$row['buyrel'];
  echo "<br/>";
  echo "BTC to Escrow: ".$row['price'];
  echo "<br />";

  echo "Notes: ".$row['notes'];
  echo "<br />";
}
  


  
  
  
  mysql_close($con);
  
  
  
  
  
  ?>