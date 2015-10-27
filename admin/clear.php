<?php
	require_once("include/util/DBHelp.php");
	require_once("include/class/SiteBuilder.class.php");
	
	session_unset();
	session_destroy();
	$_SESSION=array();
	
	SiteBuilder::clearCache();
	DBHelp::clearCache();
?>