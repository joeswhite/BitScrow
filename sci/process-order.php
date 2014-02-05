<?php
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/../lib/common.lib.php');

session_start($_GET['sid']);
  
if (empty($_GET['btc']) || !is_numeric($_GET['btc'])) {
  
  die('invalid input');
  
} else {
  
  // unset old session data (KEEP THIS)
  unset($_SESSION['tranHash']);
  unset($_SESSION['confirmed']);
  unset($_SESSION['total_price']);

  // generate a new key pair
  $keySet = bitcoin::getNewKeySet();
  
  // form encrypted key data
  $encWIF = bin2hex(bitsci::rsa_encrypt($keySet['privWIF'], $pub_rsa_key));
  $key_data = $encWIF . ':' . $keySet['pubAdd'];
  
  // set up sci variables
  $price = rawurldecode($_GET['btc']);
  $item = rawurldecode($_GET['item']);
  $quantity = 1;
  $note = rawurldecode($_GET['notes']);
  $buyer = rawurldecode($_GET['buyer']);
  $seller = rawurldecode($_GET['seller']);
  $frpin = rawurldecode($_GET['pin']);
  $vpin = rawurldecode($_GET['vpin']);
  $baggage = 'null';
  $pubAdd = $keySet['pubAdd'];
  $privwif = $keySet['privWIF'];
  $_SESSION['total_price'] = bitsci::btc_num_format($price * $quantity);
  $privkey = $key_data;

			
  
  // generate unique random string
  $random_str = bitcoin::randomString(26);
  while (file_exists('t_data/'.$random_str)) {
	$random_str = bitcoin::randomString(26);
  }

//send data to mysql

  //MYSQL CONNECT
  $con = mysql_connect($mysvr,$myusr,$mypass);

  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysql_select_db($mydb) or die(mysql_error());

// Insert a row of information into the table "payment"

mysql_query("INSERT INTO payment 
(price, quantity, item, seller, buyer, note, baggage, key_data, pubAdd, privwif, privkey, frpin, buyrel, verifypin) VALUES('$price', '$quantity', '$item', '$seller', '$buyer', '$note', '$baggage', '$key_data', '$pubAdd', '$privwif', '$privkey', '$frpin', 'NO', '$vpin') ") 
or die(mysql_error());  
  


  
  // encrypt transaction data and save to file
  $t_data = bitsci::build_pay_query($keySet['pubAdd'], $price, $quantity, $item, $seller, $success_url, $cancel_url, $note, $baggage);
  if (file_put_contents('t_data/'.$random_str, $t_data) !== false) {
	  chmod('t_data/'.$random_str, 0600);
  } else {
    echo "<p class='error_txt'>There was an error creating the transaction. Please go back and try again.</p>";
	mysql_close($con);

    exit;
  }

  // build the URL for the bitcoin payment gateway
  $payment_gateway = $site_url.$bitsci_url.'payment.php?sid='.session_id().'&t='.$random_str;
  
  // save encrypted private WIF key to file (along with address).
  // you might want to save these keys to a database instead.
  //$fp=fopen(dirname(__FILE__)."/wif-keys.csv","a");
 // if ($fp) {
  //  if (flock($fp, LOCK_EX)) {
  //    @fwrite($fp, $key_data.",\n");
  //    flock($fp, LOCK_UN);
 //   }
 //   fclose($fp);
 // }
mysql_close($con);

  // go to payment gateway
  redirect($payment_gateway);

}
?>