<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Make a donation</title>
</head>
<body>
<?php
// Typically you would just pass the item ID
// via the URL and in the process-order.php
// page you would extract the item name and
// the item price from a database using that ID.
// But for this example we'll just do it this way

$donation_sml = htmlentities(urlencode('0.1'));
$donation_med = htmlentities(urlencode('1'));
$donation_lrg = htmlentities(urlencode('5'));
$item = htmlentities(urlencode('user donation'));

if (empty($_GET['result'])) {
  echo "<h1>Donation Page</h1>\n";
  echo "<p>Have we helped you? Feeling generous? Then how about a small donation?</p>\n";
  echo "<p><a href='sci/process-order.php?donate=$donation_sml&item=$item'>Donate $donation_sml BTC</a></p>\n";
  echo "<p><a href='sci/process-order.php?donate=$donation_med&item=$item'>Donate $donation_med BTC</a></p>\n";
  echo "<p><a href='sci/process-order.php?donate=$donation_lrg&item=$item'>Donate $donation_lrg BTC</a></p>\n";
} elseif ($_GET['result'] == 'success') {
  echo "<h1>Transaction Successful!</h1>\n";
  echo "<p>Your payment was was successful! Thank you for your kind donation friend!</p>";
} elseif ($_GET['result'] == 'cancel') {
  echo "<h1>Transaction Failed!</h1>\n";
  echo "<p>The transaction was cancelled. Let the admin know if you had a problem.</p>";
}
?>
</body>
</html>