<?php
/**
* Bitcoin Payment Gateway
*
* @author Jacob Bruce
* www.bitfreak.info
*/
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/../lib/common.lib.php');

if (!empty($_GET['sid'])) {

  // start the session
  session_id($_GET['sid']);
  session_start();

  // save the transaction data to individual variables
  list($pubAdd, $price, $quantity, $item, $seller, $success_url, $cancel_url, $note, $baggage) = explode('|', $_SESSION['t_data']);
  
  // get the total price
  $total = $price * $quantity;

  // reset or increase the progress
  if (!isset($_SESSION[$pubAdd.'-confirms'])) {
    $_SESSION[$pubAdd.'-confirms'] = 1;
	$_SESSION['progress'] = 0;
  } else {
    $_SESSION['progress'] += $prog_inc;
    $_SESSION[$pubAdd.'-confirms']++;
  }
  
  // check if the payment has been recieved
  $check_result = bitsci::check_payment($total, $pubAdd, $_SESSION[$pubAdd.'-confirms']);
  
  if ($check_result === false) {
  
	// the payment isn't confirmed yet
    $_SESSION[$pubAdd.'-confirms']--;
    $payment_status = 'confirming payment';
	
  } elseif ($check_result === 'e1') {
	
	// we have no working API's...
    $_SESSION[$pubAdd.'-confirms']--;
    $payment_status = 'All API\'s are unavailable';
	
  } elseif ($check_result === 'e2') {
	
	// this really shouldn't happen...
    $_SESSION[$pubAdd.'-confirms']--;
    $payment_status = 'address is invalid!';
	
  } elseif ($check_result === 'e3') {
	
	// something weird happened...
    $_SESSION[$pubAdd.'-confirms']--;
    $payment_status = 'unexpected error occured';
	
  } elseif ($check_result === 'e4') {
	
	// not enough funds sent yet...
    $_SESSION[$pubAdd.'-confirms']--;
    $payment_status = 'partial payment received';
	
  } else {
  
    if ($_SESSION[$pubAdd.'-confirms'] >= $confirm_num)  {
      $payment_valid = true;
    } else {
      $payment_valid = false;
    }

    if ($payment_valid) {
	
	  // payment has been confirmed
      $payment_status = 'payment verified!';
	
    } else {

	  // doesn't have enough confirmations yet
      $payment_status = 'confirming payment';
    }
  }
  
  $perc_prog = ($_SESSION[$pubAdd.'-confirms'] / $confirm_num) * 100;
  $next_prog = (($_SESSION[$pubAdd.'-confirms']+1) / $confirm_num) * 100; 
  
  if ((($_SESSION['progress'] < $perc_prog) && ($perc_prog > 0))
     || ($_SESSION['progress'] >= 96)) {
    $_SESSION['progress'] = $perc_prog;
  } elseif ($_SESSION['progress'] > $next_prog) {
    $_SESSION['progress'] -= $prog_inc;
  }
  
  if ($_SESSION['progress'] > 100) {
    if ($payment_status === 'payment verified!') {
      $_SESSION['progress'] = 100;
	} else {
      $_SESSION['progress'] = 99;
	}
  }

  echo $_SESSION['progress'].':'.$payment_status;
}
?>