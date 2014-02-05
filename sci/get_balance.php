<?php
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/../lib/common.lib.php');

session_start();

if (!empty($_GET['address'])) {
  echo bitsci::get_balance(urlencode($_GET['address']), 1);
}

?>