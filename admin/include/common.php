<?php
	//auto load classes
	require_once("loadClass.php");
	
	session_start();
	error_reporting(0);
	ini_set('display_errors', 'On'); 
	
	//custom error
	function handleError($err_no, $err_msg, $err_file, $err_line, $err_vars){
		echo "<b>Error:</b>[$err_file] [$err_line] [$err_no] $err_msg <br />";
		echo wddx_serialize_value($vars, "Variables");
		die();
	}
	set_error_handler("handleError");	
	
	//page map
	$pages = array(
		"home" => "home.php", 
		//用户
		"modfypwd" => "modify_pwd.php",
		
		//公司信息
		"company" => "company.php", 
		"contact" => "contact.php", 
		"comaddr" => "comaddr.php", 
		"culture" => "culture.php", 
		"spirit" => "spirit.php", 
		"honor" => "honor.php", 

		 //网站信息
		"siteimg" => "siteimg.php",
		"site" => "site.php", 
		"recommend" => "recommend.php", 
		"links" => "links.php", 

		//产品管理
		"product" => "product.php",
		"edit_product" => "edit_product.php", 
		"sort" => "sort.php", 
		"edit_sort" => "edit_sort.php", 
		"problem" => "problem.php", 

		//站内新闻 
		"recruit" => "recruit.php", 
		"edit_recruit" => "edit_recruit.php",
		"case" => "case.php", 	
		"edit_case" => "edit_case.php", 

		"news" => "news.php", 
		"edit_news" => "edit_news.php", 
		"recruit" => "recruit.php", 
		"edit_recruit" => "edit_recruit.php",		
		"material" => "material.php", 
		"edit_material" => "edit_material.php",
		"message" => "message.php", 
		"reply_message" => "reply_message.php"
	);

	$default = "pages/home.php";
?>