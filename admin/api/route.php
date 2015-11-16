<?php
	include("../include/common.php");	
	
	Tool::print_request(__METHOD__, __LINE__);
	Tool::logger(__METHOD__, __LINE__, $_SERVER["QUERY_STRING"], _LOG_DEBUG);
		
	$_SESSION["CURRENT_PAGE"] = $default;
	
	if(isset($_REQUEST["page"])){
		$page = strtolower($_REQUEST["page"]);
		$queryStr = "";

		/*
		foreach($_GET as $key => $value){
			if(strtolower($key) != "page"){
				$queryStr .= sprintf("&%s=%s", $key, $value);
			}
		}

		if(!empty($queryStr)){
			$queryStr = sprintf("?%s", substr($queryStr, 1));
		}
		*/

		$_SESSION["CURRENT_PAGE"] =  sprintf("pages/%s", $pages[$page]);
	}
	
	echo "{\"status\":\"true\", \"data\": \"" . $_SESSION["CURRENT_PAGE"] . "\"}";
?>