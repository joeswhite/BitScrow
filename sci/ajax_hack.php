<?php
require_once(dirname(__FILE__).'/config.php');
require_once(dirname(__FILE__).'/../lib/bit-sci.lib.php');

if (!empty($_GET['sid'])) {
  echo "updateProgress('".bitsci::curl_simple_post($site_url.$bitsci_url.'check-status.php?sid='.urlencode($_GET['sid']))."');";
}
?>