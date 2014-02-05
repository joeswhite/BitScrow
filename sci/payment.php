<?php
/**
* Bitcoin Payment Gateway
*
* @author Jacob Bruce
* www.bitfreak.info
*/
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/../lib/common.lib.php');

// start the session
if (!empty($_GET['sid'])) {
  session_start($_GET['sid']);
} else {
  session_start();
}

$sid = session_id();

// generic function to handle input errors
function invalid_input($error_msg='') {
  if (empty($error_msg)) {
    die('An unexpected error occured. Go back and try again.');
  } else {
    die($error_msg);
  }
}

// call ipn script when transaction is confirmed
function confirm_transaction($ipn_url, $pub_add, $sec_str) {	
  
  // set final session vars
  $_SESSION['tranHash'] = md5($pub_add.$sec_str);
  $_SESSION['confirmed'] = $pub_add.':confirmed';
  
  // execute IPN control
  header('Location: '.$ipn_url); 
  exit;
}

// decode the t_data (pulled from file)
if (!empty($_GET['t'])) {
  $t_data = file_get_contents('t_data/'.$_GET['t']);
  if ($t_data !== false) {
    $_SESSION['t_data'] = bitsci::decrypt_data(base64_decode($t_data));
  } else {
    invalid_input('Invalid transaction data. Go back and try again.');
  }
} else {
  invalid_input('Transaction ID is empty. Go back and try again.');
}

// save the transaction data to individual variables
list($pubAdd, $price, $quantity, $item, $seller, $success_url, $cancel_url, $note, $baggage) = explode('|', $_SESSION['t_data']);

// check for errors in price and quantity
if (empty($price) || !is_numeric($price) || empty($quantity) || !is_numeric($quantity)) {
  invalid_input('Error calculating item price. Go back and try again.');
}

// get the total price
if (empty($_SESSION['total_price'])) {
  $_SESSION['total_price'] = $price * $quantity;
}

// check for errors in address
if (!bitcoin::checkAddress($pubAdd)) {
  invalid_input('Invalid bitcoin address. Go back and try again.');
}

// success? confirm for a 2nd time then redirect
if (isset($_GET['success'])) {
  $check_result = bitsci::check_payment($_SESSION['total_price'], $pubAdd, $confirm_num);
  if ($check_result === true) {
  
  //change mysql to btc verified inhand
  
  
    //MYSQL CONNECT
  $con = mysql_connect($mysvr,$myusr,$mypass);

  if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
  mysql_select_db($mydb) or die(mysql_error());

// Insert a row of information into the table "payment"

mysql_query("INSERT INTO payment 
(inhand) VALUES('YES') ") 
or die(mysql_error());  
  
  
  
  
  
    confirm_transaction('ipn-control.php?sid='.$sid, $pubAdd, $sec_str);
  } else {
    invalid_input('Error confirming transaction. Refresh the page or go back and try again.');
  }
}

// check for potential errors before proceeding
if (empty($_GET['u'])) {
  $check_result = bitsci::check_payment($_SESSION['total_price'], $pubAdd, $confirm_num);
  if ($check_result === 'e1') {
    invalid_input('Block Explorer API is offline. Please try again later.');
  } elseif ($check_result === 'e2') {
    invalid_input('The address is corrupt. Please go back and try again.');
  } elseif ($check_result === 'e3') {
    invalid_input('An unknown error occured. Please try again later.');
  } elseif ($check_result === true) {
    confirm_transaction('ipn-control.php?sid='.$sid, $pubAdd, $sec_str);
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow">
<title>Bitcoin Payment Gateway</title>
<script type="text/javascript" src="../scripts/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="../scripts/jquery.qrcode.min.js"></script>
<?php if (!empty($_GET['u'])) { ?>
<script language="JavaScript" type="text/javascript">
var sid = encodeURIComponent('<?php echo $sid; ?>');
var ted = encodeURIComponent('<?php echo $_GET['t']; ?>');
var confHandle = 0;
  
function updateProgress(pro_txt) {
  pro_txt = pro_txt.split(':');
  $('#pro_txt').html(pro_txt[0]+'%');
  $('#pro_bar').css('width', pro_txt[0]);
  $('#con_sta').html("<b>Status:</b> "+pro_txt[1]);
  
  if (pro_txt[1] == 'payment verified!') {
    clearInterval(confHandle);
    window.location = '?t='+ted+'&success';
  }
}

function checkPaymentStatus(){
  if ($.support.ajax == false) {
    // lets go old school
    var scriptObject = document.createElement('script');
    scriptObject.type = 'text/javascript';
	scriptObject.async = true;
    scriptObject.src = '<?php echo $site_url.$bitsci_url; ?>ajax_hack.php?sid='+sid;
	document.getElementsByTagName('head')[0].appendChild(scriptObject);
  } else {
    // simple jquery ajax
    $.ajax({
	  url: 'check-status.php',
	  data: 'sid='+sid,
      dataType: "text",
	  success: function(txt_out) {
	    updateProgress(txt_out);
      }
    });
  }
}

function startConfirmation() {
  confHandle = setInterval('checkPaymentStatus();', <?php echo round($refresh_time*1000); ?>);	
}

function addEventOnload(myFunction) {
  if (window.addEventListener) {
    window.addEventListener('load', myFunction, false);
  } else {
	if (window.attachEvent) {
      window.attachEvent('onload', myFunction);
	} else {
	  if (window.onload) {
	    window.onload = myFunction;
	  }
	}
  }
}

addEventOnload(startConfirmation);
</script>
<?php } else { ?>
<script language="JavaScript">
function confirmCancel() {
  if (confirm('Are you sure you want to cancel this transaction?')) {
   window.top.location = '<?php echo $cancel_url; ?>';
 }
}
</script>
<?php } ?>
<style>
.alert_txt {
  color: red;
  font-weight: bold;
}

.small_txt {
	font-size: 8pt;
}

.nojs_box {
	border: 2px solid red;
	background-color: yellow;
	text-align: center;
}

#pro_box {
  width: 102px;
  height: 22px;
  border: solid 1px black;
  text-align: left;
}

#pro_bar {
  height: 20px;
  border: solid 1px red;
  background-color: orange;
}
</style>
</head>
<body onLoad="$('#qrcode').qrcode('bitcoin:<?php echo $pubAdd; ?>');">

<center>

  <noscript>
    <div class="nojs_box">
      <p class="alert_txt">WARNING: PLEASE ENABLE JAVASCRIPT IN YOUR WEB BROWSER!</p>
    </div>
  </noscript>
  
  <p><img src='img/bitcoin_logo.png' alt='' />
  <h1>Bitcoin Escrow Payment</h1>
  <br/>
  <b>PLEASE WRITE DOWN YOUR WALLET **CASE**SENSITIVE**</b>. If you do not, we are not responsible for the inability you will have to access your funds.";
  <br/><br/>
  <p>You are buying <b><?php echo $quantity; ?> x <?php safe_echo($item); ?> @ <?php echo $price; ?> BTC</b> from <b><?php safe_echo($seller); ?></b></p>
  <p>Please transfer <i>exactly</i> <b><?php echo bitsci::btc_num_format($_SESSION['total_price']); ?> BTC</b> to the following address:</p>
  
  <h3>
    <b><?php echo '<a href="bitcoin:'.$pubAdd.'?amount='.$_SESSION['total_price'].'" title="Click this address to launch your Bitcoin client" target="_blank">'.safe_str($pubAdd).'</a>'; ?></b>
  </h3> 
  <div id="qrcode"></div>
  
  <?php if (empty($_GET['u'])) { ?> 
  
  <p>Click the confirm button after the BTC has been sent.</p>
  <hr style="width:300px" />
  <p><a href="<?php echo safe_str('?t='.urlencode($_GET['t']).'&u=1'); ?>" target="_self"><img border='0' src='img/conf_btn.png' alt='CONFIRM PAYMENT' /></a></p>
  <p><a href="#" onClick="confirmCancel();"><img border='0' src='img/canc_btn.png' alt='CANCEL PAYMENT' /></a></p>

  <?php } else { ?> 
  
  <p>Please wait while the bitcoin network confirms the payment.<br />
  The progress bar may jump back to 0% after reaching 100%</p>
  
  <p><b>Progress:</b></p>
  <table cellpadding='0' cellspacing='0' id='pro_box'><tr><td align='left'>
    <div id='pro_bar' style='width:0px'></div>
  </td></tr></table>
  <span id='pro_txt'>0%</span>
  
  <p id="con_sta"><b>Status:</b> confirming payment</p>
  <hr style="width:300px" />
  <p class='alert_txt'>PLEASE DO NOT CLOSE THIS PAGE!</p>
  <p>You will be redirected when the payment is confirmed.</p>
  
  <?php } ?>
  
  <?php
$bnotes=$_GET['notes'];
$bitem=$_GET['item'];
$bbuyer=$_GET['buyer'];
$bseller=$_GET['seller'];
$bfrpin=$_GET['pin'];


echo "<b>PLEASE WRITE DOWN YOUR WALLET **CASE**SENSITIVE**</b>. If you do not, we are not responsible for the inability you will have to access your funds.";

  
  ?>
</center>

</body>
</html>
<?php
session_write_close();
?>