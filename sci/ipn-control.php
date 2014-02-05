<?php
  /**
  * Bitcoin Payment Gateway
  *
  * @author Jacob Bruce
  * www.bitfreak.info
  */

  // here you can use the following variables to access details
  // about the transaction and/or update the status of an order
  // (typically the order details should be stored in a database)
  // 
  // $pubAdd : bitcoin address holding funds
  // $tranHash : a unique hash for each transaction
  // $price : the cost of each item (in BTC)
  // $quantity : the number of items purchased
  // $total : the total cost of the order
  // $item : the name/id of the item purchased
  // $note : note/description possibly attached to transaction
  // $baggage : extra data possibly attached to transaction
  
  require_once(dirname(__FILE__).'/config.php');
  require_once(dirname(__FILE__).'/../lib/common.lib.php');
  
  session_start($_GET['sid']);
  
  if (!empty($_SESSION['t_data'])) {
  
    // save the transaction data to individual variables
    list($pubAdd, $price, $quantity, $item, $seller, $success_url, $cancel_url, $note, $baggage) = explode('|', $_SESSION['t_data']);
  
    // ensure the transaction has been confirmed
    if (!empty($_SESSION['tranHash']) && ($_SESSION['confirmed'] === $pubAdd.':confirmed')) {
	
	  // save some other data to vars
	  $total = $_SESSION['total_price'];
	  $tranHash = $_SESSION['tranHash'];
	  $confirm_date = date('Y-m-d H:i:s');
	  
	  // !!!!!!!!!!!!!!!!!!!!!!!! //
	  // YOUR CODE SHOULD GO HERE //
	  // !!!!!!!!!!!!!!!!!!!!!!!! //

      if ($send_email) {
		  
		// create an email to alert admin of confirmation
		$to = $contact_email;
	    $subject="You have a new order!";
	    $from = $contact_email;
		
		// form body of email message
		$body = "A new transaction has been confirmed: \n\n".
		"Item: $item \n".
		"Qnty: $quantity \n".
        "Total: $total BTC \n".
		"Date: $confirm_date \n".
		"Sent to: $pubAdd \n\n".
		"Note: $note";	
		
		// form email headers
		$headers = "From: $from \r\n";
		$headers .= "Reply-To: noreply@noreply.com \r\n";
		
		// send email to admin
		mail($to, $subject, $body, $headers);
	  }
  
      // log the transaction data
      $ts = "Address: ".$pubAdd."\nHash: ".$tranHash."\nPrice(BTC): ".
	      $price."\nTotal: ".$total."\nItem: ".$item."\nQnty: ".
          $quantity."\nDate: ".$confirm_date."\nNote: ".$note."\nBaggage: ".$baggage;
      $fp=fopen(dirname(__FILE__)."/ipn-control.log","a");
      if ($fp) {
        if (flock($fp,LOCK_EX)) {
          @fwrite($fp,$ts."\n\n");
          flock($fp,LOCK_UN);
         }
        fclose($fp);
		chmod(dirname(__FILE__)."/ipn-control.log", 0600);
      }
	
//insert into mysql that it completed
  //MYSQL CONNECT
  $con = mysql_connect($mysvr,$myusr,$mypass);

  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysql_select_db($mydb) or die(mysql_error());

// Insert a row of information into the table "payment"

mysql_query("INSERT INTO payment 
(inhand, confirm) VALUES('YES', 'NOW()') ") 
or die(mysql_error()); 


	
      // go to success page
      header('Location: '.$success_url);
	  exit;

    } else {
      echo "<p class='error_txt'>An error occured. Go back and try again.</p>";
    }
  } else {
    echo "<p class='error_txt'>An error occured. Go back and try again.</p>";
  }
?>