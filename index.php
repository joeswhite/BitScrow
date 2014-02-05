<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Use our escrow services</title>
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
echo "<img src='images/logo.png' aligh='right'>";
  echo "<h1>Escrow Services</h1>\n";
  echo "<p>This page is designed to help you start out using our escrow system. </p>\n";
  echo "<p>Please read below before proceeding. You agree to hold us harmless in any case. </p>\n";
   echo "<p>YOU MUST AGREE TO THE <a href='tos.php'>Terms Of Service</a> to continue. </p>\n";

echo "<p>Our services are provided as proof of concept only. use at your own risk.</p>";
echo "<br/>";
echo "<a href='status.php'>Check the status on an Escrow</a> <a href='rlsrev.php'>Release Funds</a>";
echo "<br/>";
echo "<p>To use our system you need to input all information in to the forum below. Once you have filled in ALL information. Submit your escrow request at the bottom of this page.</p>";
echo "<br/>";
echo "<br/>";

echo "<p>Explination of terms</p>";
//added start

echo "		<table style=\"width: 100%;\">\n"; 
echo "			<tbody>\n"; 
echo "				<tr>\n"; 
echo "					<td>\n"; 
echo "						Buyer</td>\n"; 
echo "					<td>\n"; 
echo "						Person sending the funds (buying the goods/item)</td>\n"; 
echo "				</tr>\n"; 
echo "				<tr>\n"; 
echo "					<td>\n"; 
echo "						Seller</td>\n"; 
echo "					<td>\n"; 
echo "						Person recieving the funds (selling the goods)</td>\n"; 
echo "				</tr>\n"; 
echo "				<tr>\n"; 
echo "					<td>\n"; 
echo "						BTC</td>\n"; 
echo "					<td>\n"; 
echo "						 Amount of Bitcoin to send from BUYER to SELLER</td>\n"; 
echo "				</tr>\n"; 

echo "				<tr>\n"; 
echo "					<td>\n"; 
echo "						Item</td>\n"; 
echo "					<td>\n"; 
echo "						This is the item to be escrowed for confirmation (YOU MUST ACCURATELY FILL OUT THIS FOR ANY CHANCE OF REFUNDS!)</td>\n"; 
echo "				</tr>\n";

echo "				<tr>\n"; 
echo "					<td>\n"; 
echo "						Funds Verification PIN (FVP)</td>\n"; 
echo "					<td>\n"; 
echo "						This is the secret password you give the Seller so they can confirm the bitcoin is in our escrow. (DO NOT REUSE PINS)</td>\n"; 
echo "				</tr>\n";

echo "				<tr>\n"; 
echo "					<td>\n"; 
echo "						Funds Release Pin (FRP)</td>\n"; 
echo "					<td>\n"; 
echo "						This is the secret password you give the seller so they can get the payment from escrow. ONLY GIVE THEM THIS NUMBER AFTER YOU HAVE YOUR ITEM!(DO NOT REUSE PINS)</td>\n"; 
echo "				</tr>\n";


echo "				<tr>\n"; 
echo "					<td>\n"; 
echo "						Wallet ID (WID)</td>\n"; 
echo "					<td>\n"; 
echo "						This is the wallet you sent information to. CASE SENSITIVE. YOU MUST WRITE IT DOWN</td>\n"; 
echo "				</tr>\n";


echo "				<tr>\n"; 
echo "					<td>\n"; 
echo "						Notes</td>\n"; 
echo "					<td>\n"; 
echo "						Any special information about your order. This includes purity guarentees, shipment arrival times, etc.
</td>\n"; 
echo "				</tr>\n";


echo "			</tbody>\n"; 
echo "		</table>\n";

//end01111111111111111


echo "<br/>";
echo "<br/>";

echo "You will be required to give the seller the following information so they can access";
echo "<br/>";
echo "Buyer, Seller, BTC, FVP, FRP (once item arrive), Wallet ID (available on page with QR/payment code)";
echo "<br/>";
echo "<br/>";


  
  //table.to.input.price
echo " <h2>Request Escrow Below:</h2><p> \n"; 
echo " <form action=\"review.php\" method=\"post\" enctype=\"application/x-www-form-urlencoded\"
> \n"; 
echo " <table> \n"; 
echo " <tr><td>Buyer:</td><td><input type=\"text\" name=\"buyer\" /></td></tr> \n"; 
echo " <tr><td>Seller:</td><td><input type=\"text\" name=\"seller\" /></td></tr> \n"; 

echo " <tr><td>BTC:</td><td><input type=\"text\" name=\"sendbtc\" /></td></tr> \n"; 
echo " <tr><td>Item:</td><td><input type=\"text\" name=\"item\" /></td></tr> \n"; 
echo " <tr><td>Funds Verfication PIN:</td><td><input type=\"text\" name=\"vpin\" /></td></tr> \n"; 
echo " <tr><td>Funds Release PIN:</td><td><input type=\"text\" name=\"pin\" /></td></tr> \n"; 
echo " <tr><td>Notes:</td><td><input type=\"text\" name=\"notes\" /></td></tr> \n"; 
echo " <tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" /></td></tr> \n"; 
echo " </table> \n"; 
echo " </form> \n";
echo "<br/>";
  echo "<p>YOU ARE USING OUR FREE SERVICES. FREE SERVICES DO NOT HAVE ANY WARRENTY OR VERFICATION OF SECURITY WHATSOEVER. WE ARE NOT RESPONSIBLE FOR LOST FUNDS. WE ARE NOT A FINANCIAL INSTITUTION, WE ARE NOT FDIC INSURED. IF WE LOSE YOUR MONEY, IT IS YOUR LOSS!</p>";

?>
</body>
</html>