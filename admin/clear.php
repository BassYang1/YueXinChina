<?php
	require_once("include/class/DBHelp.class.php");
	require_once("include/class/SiteBuilder.class.php");
	
	session_unset();
	session_destroy();
	$_SESSION=array();
	
	SiteBuilder::clearCache();
	DBHelp::clearCache();
?>