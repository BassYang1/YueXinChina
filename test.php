<?php  
	require_once("include/Util.php"); 
	require_once("admin/include/loadClass.php");
	require_once("admin/include/loadClass.php");
	require_once("admin/include/loadClass.php");
	
	/*echo $_SERVER["HTTP_HOST"] . "<br />";
	echo $_SERVER['SERVER_NAME'] . "<br />";
	echo $_SERVER['SERVER_PORT'] . "<br />";
	*/
	
	foreach($_SERVER as $key => $value){
	echo $key . ": " . $value . "<br />";
	}
	
	/*
	try{
		$configs = Config::getValueByKey("abc123");
		foreach($configs as $key => $value){
			echo $key . ": " . $value . "<br />";
		}
	}
	catch(Exception $e){
		echo $e->getMessage();
	}
	//echo $_SERVER["DOCUMENT_ROOT"] . "<br />";
	//echo $_SERVER["PHP_SELF"];
	//unset($_SESSION["DB_CONFIG"]);
	echo Tool::getHTML("index.php");*/
?>
