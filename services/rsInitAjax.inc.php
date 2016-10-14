<?php

 rsInitAjax();
 
 // What to do with the accumulated output:
 function sendResponse($buffer) {
   global $_RESPONSE;
   $_RESPONSE['data'] = $buffer;   // Package the accumulated output
   return json_encode($_RESPONSE); // Flatten it for transmission to the client
 }

 function rsInitAjax() {
   suppressMagicQuotes();         // Undo magic quotes, if they're turned on
   global $_RESPONSE;
   $_RESPONSE['error'] = false;    // Initialize the output array
   ob_start("sendResponse");      // Arrange for post processing of accumulated output

 }

// As recommended at http://php.net/manual/en/security.magicquotes.disabling.php#example-323
 function suppressMagicQuotes() {
	if (get_magic_quotes_gpc()) {
		$process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
		while (list($key, $val) = each($process)) {
			foreach ($val as $k => $v) {
				unset($process[$key][$k]);
				if (is_array($v)) {
					$process[$key][stripslashes($k)] = $v;
					$process[] = &$process[$key][stripslashes($k)];
				} else {
					$process[$key][stripslashes($k)] = stripslashes($v);
				}
			}
		}
		unset($process);
	}
 }

?>