<?php
	session_start();
	error_reporting(0);
	
	//custom error
	function handleError($err_no, $err_msg){
		echo "<b>Error:</b>[$err_no] $err_msg";		
		die();
	}
	set_error_handler("handleError");
	
	//auto load classes
	require_once("loadClass.php");
	
	//page map
	$pages = array(
		"home" => "home.php", 
		"company" => "company.php", 
		"site" => "site.php", 
		"links" => "links.php",
		"culture" => "culture.php", 
		"product" => "product.php", 
		"edit_product" => "edit_product.php", 
		"sort" => "sort.php", 
		"edit_sort" => "edit_sort.php", 
		"news" => "news.php", 
		"edit_news" => "edit_news.php", 
		"case" => "case.php", 
		"edit_case" => "edit_case.php", 
		"recruit" => "recruit.php", 
		"edit_recruit" => "edit_recruit.php",		
		"material" => "material.php", 
		"edit_material" => "edit_material.php",
		"message" => "message.php", 
		"reply_message" => "reply_message.php"
	);

	$default = "pages/home.php";
	$lbl_current_page = "CURRENT_PAGE";
	
	//login user
	$lblCurrentUser = "CURRENT_USER";
	$user = new User("admin1");
	$_SESSION[$lblCurrentUser] = $user;

	//¼ÓÔØContentÊý¾Ý
	//Content::cache();
?>