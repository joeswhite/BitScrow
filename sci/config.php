<?php
// business name
$seller = '';

// base website url (with slash on end)
$site_url = '';

// location of bitcoin sci folder from root
$bitsci_url = 'sci/';

// number of confirmations needed (can't be 0)
$confirm_num = 1;

// amount of time between each refresh (in seconds)
$refresh_time = 20;

// amount the progress bar increases with each refresh
$prog_inc = 5;

// payment precision (allow a bit of wiggle room)
$p_variance = 0.00001;

// prefered API (blockexplorer.com or blockchain.info)
$blockchain_api = 'blockchain.info';

// should you receive an email upon confirmation?
$send_email = true;

// email for receiving cofirmation notices
$contact_email = '';

// admin control panel password
$admin_pass = '';

// security string used for encryption (16 chars)
$sec_str = '';

// public RSA key (base64) used to encrypt private keys
$pub_rsa_key = '
';

//URLS for payment cancelation success and donation
  $cancel_url = $site_url.'result.php?result=cancel';
  $success_url = $site_url.'result.php?result=success';


//MYSQL information here
$mysvr = "";
$myusr = "";
$mypass= "";
$paytable = "payment";
$mydb = "escrow";

  /////////////////////////////////////
/* IGNORE ANYTHING UNDER THIS LINE */
/////////////////////////////////////
define('CONF_NUM', $confirm_num);
define('SEC_STR', $sec_str);

// turn on/off error reporting
ini_set('display_errors', 1); 
error_reporting(0);
?>