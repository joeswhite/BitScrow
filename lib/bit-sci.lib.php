<?php
/**
* Bitcoin SCI class
*
* @author Jacob Bruce
* www.bitfreak.info
*/

// requires AES.php & config.php

class bitsci {

  public function curl_simple_post($url_str) {
	
    // Initializing cURL
    $ch = curl_init();
  
    // Setting curl options
    curl_setopt($ch, CURLOPT_URL, $url_str);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, "PHP/".phpversion());

    // Getting jSON result string
    $result = curl_exec($ch); 
  
    // close cURL and json file
    curl_close($ch);

    // return cURL result
    return $result;
  
  }
  
  public function send_request($api_sel, $addr_str, $confirmations) {
  
    if ($api_sel === 1) {
	  return self::curl_simple_post('https://blockexplorer.com/q/getreceivedbyaddress/'.$addr_str.'/'.$confirmations);
	} else {
	  $result = self::curl_simple_post('https://blockchain.info/q/addressbalance/'.$addr_str.'?confirmations='.$confirmations);
	  if (is_numeric($result)) {
	    return $result / 100000000;
	  } else {
	    return $result;
	  }
	}
  }
  
  public function get_balance($addr_str, $confirmations=CONF_NUM) {
	
	// select an API based on settings
	if (!empty($_SESSION['api_sel'])) {
	  $api_sel = $_SESSION['api_sel'];
	} else {
      if ($GLOBALS['blockchain_api'] === 'blockexplorer.com') {
	    $api_sel = 1;
	  } else {
	    $api_sel = 2;
	  }
	}
	
	// change between API's every few calls
    if (!empty($_SESSION['call_num'])) {
	  if ($_SESSION['call_num'] > 2) {
	    $_SESSION['call_num'] = 1;
		$api_sel = ($api_sel === 1) ? 2 : 1;
		$_SESSION['api_sel'] = $api_sel;
	  } else {
	    $_SESSION['call_num']++;
	  }
	} else {
	  $_SESSION['call_num'] = 1;
	}

	// send request to API
	$result = self::send_request($api_sel, $addr_str, $confirmations);
	
	// if API is offline then try alternative
	if ($result === false) {
	  $api_sel = ($api_sel === 1) ? 2 : 1;
	  $_SESSION['api_sel'] = $api_sel;
	  $result = self::send_request($api_sel, $addr_str, $confirmations);
	}

	return $result;
  }
  
  public function check_payment($price, $addr_str, $confirmations=CONF_NUM) {
  
	$balance = self::get_balance($addr_str, $confirmations);
	$str_start = explode(' ', $balance);

	if ($balance === false) {
	  return 'e1';
	} elseif (($balance === 'ERROR: invalid address') || ($balance === 'Checksum does not validate')) {
	  return 'e2';
	} elseif (($str_start[0] === 'ERROR:') || !is_numeric($balance)) {
	  return 'e3';
	} elseif ($balance > 0) {
	  if (($balance + $p_variance) < $price) {
	    return 'e4';
	  } else {
	    return true;
	  }
	} else {
	  return false;
	}
  }
  
  public function rsa_encrypt($input_str, $key) {
  
    $rsa = new Crypt_RSA();
 
    $rsa->setPrivateKeyFormat(CRYPT_RSA_PRIVATE_FORMAT_PKCS1);
    $rsa->setPublicKeyFormat(CRYPT_RSA_PUBLIC_FORMAT_PKCS1);
    $rsa->setEncryptionMode(CRYPT_RSA_ENCRYPTION_PKCS1);

	$public_key = array(
		'n' => new Math_BigInteger($key, 16),
		'e' => new Math_BigInteger('65537', 10)
	);
	
	$rsa->loadKey($public_key, CRYPT_RSA_PUBLIC_FORMAT_RAW);

    return $rsa->encrypt($input_str);	
  }
  
  public function encrypt_data($input_str, $key=SEC_STR) {
  
    $aes = new Crypt_AES();
    $aes->setKey($key);	

    return $aes->encrypt($input_str);	
  }
  
  public function decrypt_data($input_str, $key=SEC_STR) {
  
    $aes = new Crypt_AES();
    $aes->setKey($key);	

    return $aes->decrypt($input_str);	
  }
  
  public function build_pay_query($pubAdd, $price, $quantity, $item, $seller, $success_url, $cancel_url, $note, $baggage) {
  
    $td = implode('|', array($pubAdd, $price, $quantity, $item, $seller, $success_url, $cancel_url, $note, $baggage));
	return base64_encode(self::encrypt_data($td));
  }
  
  public function btc_num_format($num) {
  
    return number_format($num, 8, '.', '');	
  }
 
  public function JSONtoAmount($value) {
  
    return round(value * 1e8);
  }
}
?>