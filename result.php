<?php
if (empty($_GET['result'])) {
  echo "<h1>Transaction Failed!</h1>\n";
  echo "<p>The transaction was cancelled. Let the admin know if you had a problem.</p>";
} elseif ($_GET['result'] == 'success') {
  echo "<h1>Transaction Successful!</h1>\n";
  echo "<p>Your payment was was successful! Thank you for your kind donation friend!</p>";
} elseif ($_GET['result'] == 'cancel') {
  echo "<h1>Transaction Failed!</h1>\n";
  echo "<p>The transaction was cancelled. Let the admin know if you had a problem.</p>";
}
echo "<br/> <a href = index.php> GO HOME</a>";
?>