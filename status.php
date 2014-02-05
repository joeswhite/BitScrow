<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Check escrow status</title>
</head>
<body>
<?php
// Typically you would just pass the item ID
// via the URL and in the process-order.php
// page you would extract the item name and
// the item price from a database using that ID.
// But for this example we'll just do it this way


  echo "<h1>Check escrow status</h1>\n";
  echo "<p>Want to check on the status of your escrow payment?</p>\n";
  
  //table.to.input.price
echo " <h2>Enter Escrow Information Below:</h2><p> \n"; 
echo " <form action=\"check.php\" method=\"post\" enctype=\"application/x-www-form-urlencoded\"
> \n"; 
echo " <table> \n"; 
echo " <tr><td>Buyer:</td><td><input type=\"text\" name=\"buyer\" /></td></tr> \n"; 
echo " <tr><td>Seller:</td><td><input type=\"text\" name=\"seller\" /></td></tr> \n"; 
echo " <tr><td>BTC:</td><td><input type=\"text\" name=\"sendbtc\" /></td></tr> \n"; 
echo " <tr><td>Funds Verification PIN:</td><td><input type=\"text\" name=\"vpin\" /></td></tr> \n"; 
echo " <tr><td>Wallet ID:</td><td><input type=\"text\" name=\"wid\" /></td></tr> \n"; 
echo " <tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" /></td></tr> \n"; 
echo " </table> \n"; 
echo " </form> \n";
  

?>
</body>
</html>