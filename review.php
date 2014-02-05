<?php
$btc=$_POST['sendbtc'];
$notes=$_POST['notes'];
$item=$_POST['item'];
$buyer=$_POST['buyer'];
$seller=$_POST['seller'];
$frpin=$_POST['pin'];
$vpin=$_POST['vpin'];


$encnote =  rawurlencode($_POST['notes']);
$encbtc = rawurlencode($_POST['sendbtc']);
$encitem = rawurlencode($_POST['item']);
$encbuyer = rawurlencode($_POST['buyer']);
$encseller = rawurlencode($_POST['seller']);
$encfrpin = rawurlencode($_POST['pin']);

echo "<h1>Review your order</h1>";
echo "<br/>";

echo "<b>BTC: </b>".$btc;
echo '<br/>';
echo "<b>Buyer: </b>".rawurldecode($buyer);
echo "<br/>";
echo "<b>Seller: </b>".rawurldecode($seller);
echo "<br/>";
echo "<b>For Item: </b>".rawurldecode($item);
echo "<br/>";
echo "<b>Funds Verfication PIN: </b>".rawurldecode($vpin);
echo "<br/>";
echo "<b>Funds Release PIN: </b>".rawurldecode($frpin);
echo "<br/>";
echo "<b>Notes: </b>".rawurldecode($notes);
echo "<br/>";
echo "<br/>";
echo "Everything look good?";
echo "<br/>";
echo "Print this page for your records, this is your sales recipt";
echo "<br/>";
echo "<br/>";
echo "AFTER PRINTING THIS PAGE, PLEASE write down your WIF, import and immediately change the btc WIF transaction ASAP. You can not release funds without using WIF!";
echo "<br/>";
echo "<br/>";
echo "<br/>";
echo "<a href=sci/process-order.php?btc=$encbtc&buyer=$encbuyer&seller=$encseller&item=$encitem&notes=$encnote&pin=$encfrpin&vpin=$vpin>Confirm Payment</a> (By comfirming payment you agree to all TOS.)";
?>