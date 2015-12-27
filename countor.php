<?php
	require_once("include/init.php");
	
	$cIP = getenv('REMOTE_ADDR');   
	$cIP1 = getenv('HTTP_X_FORWARDED_FOR');   
	$cIP2 = getenv('HTTP_CLIENT_IP');   
	$cIP1 ? $cIP = $cIP1 : null;   
	$cIP2 ? $cIP = $cIP2 : null; 


	if(!isset($_SESSION[$cIP]) || time() - $_SESSION[$cIP] > (60 * 5)){ //如果session不存在，或者超过5分钟，则记为一次有效访问
		$_SESSION[$cIP] = time();
		Countor::countNum();
	}
?>